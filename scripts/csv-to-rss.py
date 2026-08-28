#!/usr/bin/env python3
"""Convert Desteia blog CSV export to RSS 2.0 feed."""

from __future__ import annotations

import argparse
import csv
import sys
from datetime import datetime, timezone
from email.utils import format_datetime
from pathlib import Path
from xml.sax.saxutils import escape


def parse_date(iso_date: str) -> datetime:
    normalized = iso_date.strip()
    if normalized.endswith("Z"):
        normalized = normalized[:-1] + "+00:00"
    dt = datetime.fromisoformat(normalized)
    if dt.tzinfo is None:
        dt = dt.replace(tzinfo=timezone.utc)
    return dt.astimezone(timezone.utc)


def cdata(value: str) -> str:
    return f"<![CDATA[{value.replace(']]>', ']]]]><![CDATA[>')}]]>"


def split_tags(tags: str) -> list[str]:
    if not tags.strip():
        return []
    return [tag.strip() for tag in tags.split(",") if tag.strip()]


def build_item(row: dict[str, str], base_url: str) -> str:
    slug = row["Slug"].strip()
    link = f"{base_url.rstrip('/')}/{slug}"
    pub_date = format_datetime(parse_date(row["Date"]), usegmt=True)

    categories = []
    if row.get("Category", "").strip():
        categories.append(f"    <category>{escape(row['Category'].strip())}</category>")
    for tag in split_tags(row.get("Tags", "")):
        categories.append(f"    <category>{escape(tag)}</category>")

    enclosure = ""
    hero = row.get("Hero Image", "").strip()
    if hero:
        enclosure = f'    <enclosure url="{escape(hero)}" type="image/jpeg" length="0"/>'

    lines = [
        "  <item>",
        f"    <title>{escape(row['Title'].strip())}</title>",
        f"    <link>{escape(link)}</link>",
        f'    <guid isPermaLink="true">{escape(link)}</guid>',
        f"    <pubDate>{pub_date}</pubDate>",
        f"    <dc:creator>{escape(row['Author Name'].strip())}</dc:creator>",
        f"    <description>{escape(row['Excerpt'].strip())}</description>",
        f"    <content:encoded>{cdata(row['Content'])}</content:encoded>",
    ]
    lines.extend(categories)
    if enclosure:
        lines.append(enclosure)
    lines.append("  </item>")
    return "\n".join(lines)


def convert_csv_to_rss(
    csv_path: Path,
    rss_path: Path,
    *,
    base_url: str = "https://desteia.com/blog",
    include_drafts: bool = False,
    channel_title: str = "Desteia Blog",
    channel_description: str = "Logistics and supply chain insights from Desteia",
    channel_link: str = "https://desteia.com/blog",
    feed_self_link: str | None = None,
) -> int:
    with csv_path.open(encoding="utf-8", newline="") as handle:
        rows = list(csv.DictReader(handle))

    if not include_drafts:
        rows = [row for row in rows if row.get(":draft", "").strip().lower() != "true"]

    rows.sort(key=lambda row: parse_date(row["Date"]), reverse=True)

    self_link = feed_self_link or f"{channel_link.rstrip('/')}/Blog.rss"
    items_xml = "\n".join(build_item(row, base_url) for row in rows)

    rss = f"""<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0"
     xmlns:content="http://purl.org/rss/1.0/modules/content/"
     xmlns:dc="http://purl.org/dc/elements/1.1/"
     xmlns:atom="http://www.w3.org/2005/Atom">
  <channel>
    <title>{escape(channel_title)}</title>
    <link>{escape(channel_link)}</link>
    <description>{escape(channel_description)}</description>
    <language>es</language>
    <lastBuildDate>{format_datetime(datetime.now(timezone.utc), usegmt=True)}</lastBuildDate>
    <atom:link href="{escape(self_link)}" rel="self" type="application/rss+xml"/>
{items_xml}
  </channel>
</rss>
"""

    rss_path.parent.mkdir(parents=True, exist_ok=True)
    rss_path.write_text(rss, encoding="utf-8")
    return len(rows)


def main() -> int:
    parser = argparse.ArgumentParser(description="Convert blog CSV export to RSS 2.0")
    parser.add_argument(
        "csv_path",
        nargs="?",
        default="/home/ubuntu/.cursor/projects/workspace/uploads/Blog_df5f.csv",
        help="Path to the input CSV file",
    )
    parser.add_argument(
        "-o",
        "--output",
        default="/workspace/Blog.rss",
        help="Path to the output RSS file",
    )
    parser.add_argument(
        "--include-drafts",
        action="store_true",
        help="Include draft posts in the feed",
    )
    args = parser.parse_args()

    csv_path = Path(args.csv_path)
    rss_path = Path(args.output)

    if not csv_path.exists():
        print(f"Error: CSV file not found: {csv_path}", file=sys.stderr)
        return 1

    count = convert_csv_to_rss(
        csv_path,
        rss_path,
        include_drafts=args.include_drafts,
    )
    print(f"Created {rss_path} with {count} items")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
