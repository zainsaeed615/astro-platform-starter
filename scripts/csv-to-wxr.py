#!/usr/bin/env python3
"""Convert Desteia blog CSV export to WordPress WXR (WordPress eXtended RSS) format."""

from __future__ import annotations

import argparse
import csv
import re
import unicodedata
from datetime import datetime, timezone
from email.utils import format_datetime
from pathlib import Path


SITE_TITLE = "Desteia Blog"
SITE_URL = "https://desteia.com"
BLOG_URL = f"{SITE_URL}/blog"
LANGUAGE = "es"


def slugify(value: str) -> str:
    normalized = unicodedata.normalize("NFKD", value)
    ascii_text = normalized.encode("ascii", "ignore").decode("ascii")
    slug = re.sub(r"[^\w\s-]", "", ascii_text.lower())
    slug = re.sub(r"[\s_-]+", "-", slug).strip("-")
    return slug or "untitled"


def cdata(value: str) -> str:
    if not value:
        return "<![CDATA[]]>"
    return f"<![CDATA[{value.replace(']]>', ']]]]><![CDATA[>')}]]>"


def parse_iso_date(value: str) -> datetime:
    if value.endswith("Z"):
        value = value[:-1] + "+00:00"
    parsed = datetime.fromisoformat(value)
    if parsed.tzinfo is None:
        parsed = parsed.replace(tzinfo=timezone.utc)
    return parsed.astimezone(timezone.utc)


def wp_datetime(value: datetime) -> str:
    return value.strftime("%Y-%m-%d %H:%M:%S")


def rfc822_datetime(value: datetime) -> str:
    return format_datetime(value, usegmt=True)


def author_login(name: str) -> str:
    return slugify(name).replace("-", "_") or "author"


def load_rows(csv_path: Path) -> list[dict[str, str]]:
    with csv_path.open("r", encoding="utf-8", newline="") as handle:
        return list(csv.DictReader(handle))


def unique_authors(rows: list[dict[str, str]]) -> list[str]:
    seen: set[str] = set()
    authors: list[str] = []
    for row in rows:
        name = (row.get("Author Name") or "Desteia").strip()
        if name not in seen:
            seen.add(name)
            authors.append(name)
    return authors


def unique_categories(rows: list[dict[str, str]]) -> list[str]:
    seen: set[str] = set()
    categories: list[str] = []
    for row in rows:
        category = (row.get("Category") or "Uncategorized").strip()
        if category not in seen:
            seen.add(category)
            categories.append(category)
    return categories


def build_wxr(rows: list[dict[str, str]], include_drafts: bool = True) -> str:
    if not include_drafts:
        rows = [row for row in rows if (row.get(":draft") or "").lower() != "true"]

    rows = sorted(rows, key=lambda row: parse_iso_date(row["Date"]), reverse=True)

    authors = unique_authors(rows)
    categories = unique_categories(rows)
    now = datetime.now(timezone.utc)

    author_blocks = []
    for index, name in enumerate(authors, start=1):
        login = author_login(name)
        author_blocks.append(
            "\n".join(
                [
                    "    <wp:author>",
                    f"        <wp:author_id>{index}</wp:author_id>",
                    f"        <wp:author_login>{cdata(login)}</wp:author_login>",
                    f"        <wp:author_email>{cdata(f'{login}@desteia.com')}</wp:author_email>",
                    f"        <wp:author_display_name>{cdata(name)}</wp:author_display_name>",
                    "        <wp:author_first_name><![CDATA[]]></wp:author_first_name>",
                    "        <wp:author_last_name><![CDATA[]]></wp:author_last_name>",
                    "    </wp:author>",
                ]
            )
        )

    category_blocks = []
    for index, category in enumerate(categories, start=1):
        category_blocks.append(
            "\n".join(
                [
                    "    <wp:category>",
                    f"        <wp:term_id>{index}</wp:term_id>",
                    f"        <wp:category_nicename>{cdata(slugify(category))}</wp:category_nicename>",
                    "        <wp:category_parent><![CDATA[]]></wp:category_parent>",
                    f"        <wp:cat_name>{cdata(category)}</wp:cat_name>",
                    "    </wp:category>",
                ]
            )
        )

    item_blocks = []
    for index, row in enumerate(rows, start=1):
        slug = (row.get("Slug") or slugify(row.get("Title", ""))).strip()
        title = (row.get("Title") or slug).strip()
        author = (row.get("Author Name") or "Desteia").strip()
        excerpt = (row.get("Excerpt") or "").strip()
        content = (row.get("Content") or "").strip()
        category = (row.get("Category") or "Uncategorized").strip()
        tags = [tag.strip() for tag in (row.get("Tags") or "").split(",") if tag.strip()]
        hero_image = (row.get("Hero Image") or "").strip()
        hero_alt = (row.get("Hero Image:alt") or title).strip()
        is_draft = (row.get(":draft") or "").lower() == "true"
        is_featured = (row.get("Featured") or "").lower() == "true"
        post_date = parse_iso_date(row["Date"])
        post_link = f"{BLOG_URL}/{slug}"
        status = "draft" if is_draft else "publish"

        tag_lines = [
            f'        <category domain="post_tag" nicename="{slugify(tag)}">{cdata(tag)}</category>'
            for tag in tags
        ]

        meta_lines = [
            "\n".join(
                [
                    "        <wp:postmeta>",
                    "            <wp:meta_key><![CDATA[_desteia_featured]]></wp:meta_key>",
                    f"            <wp:meta_value>{cdata('1' if is_featured else '0')}</wp:meta_value>",
                    "        </wp:postmeta>",
                ]
            )
        ]

        if hero_image:
            meta_lines.append(
                "\n".join(
                    [
                        "        <wp:postmeta>",
                        "            <wp:meta_key><![CDATA[_desteia_hero_image]]></wp:meta_key>",
                        f"            <wp:meta_value>{cdata(hero_image)}</wp:meta_value>",
                        "        </wp:postmeta>",
                        "        <wp:postmeta>",
                        "            <wp:meta_key><![CDATA[_desteia_hero_image_alt]]></wp:meta_key>",
                        f"            <wp:meta_value>{cdata(hero_alt)}</wp:meta_value>",
                        "        </wp:postmeta>",
                    ]
                )
            )

        item_blocks.append(
            "\n".join(
                [
                    "    <item>",
                    f"        <title>{cdata(title)}</title>",
                    f"        <link>{post_link}</link>",
                    f"        <pubDate>{rfc822_datetime(post_date)}</pubDate>",
                    f"        <dc:creator>{cdata(author)}</dc:creator>",
                    f'        <guid isPermaLink="false">{post_link}</guid>',
                    "        <description></description>",
                    f"        <content:encoded>{cdata(content)}</content:encoded>",
                    f"        <excerpt:encoded>{cdata(excerpt)}</excerpt:encoded>",
                    f"        <wp:post_id>{index}</wp:post_id>",
                    f"        <wp:post_date>{wp_datetime(post_date)}</wp:post_date>",
                    f"        <wp:post_date_gmt>{wp_datetime(post_date)}</wp:post_date_gmt>",
                    f"        <wp:post_modified>{wp_datetime(post_date)}</wp:post_modified>",
                    f"        <wp:post_modified_gmt>{wp_datetime(post_date)}</wp:post_modified_gmt>",
                    "        <wp:comment_status>open</wp:comment_status>",
                    "        <wp:ping_status>open</wp:ping_status>",
                    f"        <wp:post_name>{cdata(slug)}</wp:post_name>",
                    f"        <wp:status>{cdata(status)}</wp:status>",
                    "        <wp:post_parent>0</wp:post_parent>",
                    "        <wp:menu_order>0</wp:menu_order>",
                    "        <wp:post_type><![CDATA[post]]></wp:post_type>",
                    "        <wp:post_password><![CDATA[]]></wp:post_password>",
                    f"        <wp:is_sticky>{1 if is_featured else 0}</wp:is_sticky>",
                    f'        <category domain="category" nicename="{slugify(category)}">{cdata(category)}</category>',
                    *tag_lines,
                    *meta_lines,
                    "    </item>",
                ]
            )
        )

    return "\n".join(
        [
            '<?xml version="1.0" encoding="UTF-8" ?>',
            '<rss version="2.0"',
            '    xmlns:excerpt="http://wordpress.org/export/1.2/excerpt/"',
            '    xmlns:content="http://purl.org/rss/1.0/modules/content/"',
            '    xmlns:wfw="http://wellformedweb.org/CommentAPI/"',
            '    xmlns:dc="http://purl.org/dc/elements/1.1/"',
            '    xmlns:wp="http://wordpress.org/export/1.2/">',
            "<channel>",
            f"    <title>{cdata(SITE_TITLE)}</title>",
            f"    <link>{BLOG_URL}</link>",
            f"    <description>{cdata('Logistics and supply chain insights from Desteia')}</description>",
            f"    <pubDate>{rfc822_datetime(now)}</pubDate>",
            f"    <language>{LANGUAGE}</language>",
            "    <wp:wxr_version>1.2</wp:wxr_version>",
            f"    <wp:base_site_url>{SITE_URL}</wp:base_site_url>",
            f"    <wp:base_blog_url>{BLOG_URL}</wp:base_blog_url>",
            *author_blocks,
            *category_blocks,
            *item_blocks,
            "</channel>",
            "</rss>",
            "",
        ]
    )


def main() -> None:
    parser = argparse.ArgumentParser(description="Convert blog CSV export to WordPress WXR.")
    parser.add_argument(
        "--input",
        type=Path,
        default=Path(__file__).resolve().parent.parent / "data" / "Blog.csv",
        help="Path to the source CSV file.",
    )
    parser.add_argument(
        "--output",
        type=Path,
        default=Path(__file__).resolve().parent.parent / "public" / "desteia-blog-export.wxr",
        help="Path to the generated WXR file.",
    )
    parser.add_argument(
        "--exclude-drafts",
        action="store_true",
        help="Omit draft posts from the export.",
    )
    args = parser.parse_args()

    rows = load_rows(args.input)
    wxr = build_wxr(rows, include_drafts=not args.exclude_drafts)
    args.output.parent.mkdir(parents=True, exist_ok=True)
    args.output.write_text(wxr, encoding="utf-8")

    published = sum(1 for row in rows if (row.get(":draft") or "").lower() != "true")
    drafts = len(rows) - published
    exported = published if args.exclude_drafts else len(rows)

    print(f"Converted {exported} posts from {args.input}")
    print(f"Published: {published} | Drafts: {drafts}")
    print(f"WXR written to {args.output}")


if __name__ == "__main__":
    main()
