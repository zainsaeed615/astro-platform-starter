// Blue Jay Family Services — On-Page SEO report
// Regenerate: npm install pptxgenjs@4.0.1 && node generate-report.mjs [output.pptx]
import pptxgen from "pptxgenjs";

const pres = new pptxgen();
pres.defineLayout({ name: "WIDE", width: 13.333, height: 7.5 });
pres.layout = "WIDE";
pres.title = "On-Page SEO Optimization Report — Blue Jay Family Services";
pres.author = "Blue Jay Family Services";
pres.subject = "On-page SEO optimization completed October 14, 2026";
pres.company = "Blue Jay Family Services";

const C = {
  blue: "046BD2",
  deep: "045CB4",
  navy: "033E78",
  ink: "1E293B",
  slate: "334155",
  muted: "64748B",
  ice: "F0F5FA",
  white: "FFFFFF",
  line: "E2E8F0",
  soft: "E8F1FB",
  green: "047857",
  greenBg: "ECFDF5",
  mist: "D6E4F5",
};
const FONT = "Calibri";
const TOTAL = 17;
let slideNo = 0;

const pages = [
  {
    name: "Family Court Counseling California",
    short: "Family Court Counseling",
    url: "https://bluejayfams.com/family-court-counseling-california/",
    path: "/family-court-counseling-california/",
    title: "Family Court Counseling California | Ontario",
    meta: "Family court counseling in Ontario, CA for adults facing court-related stress, parenting and communication issues. Call 909-544-9322.",
    work: [
      "Optimized the SEO title and meta description.",
      "Incorporated relevant family court counseling keywords into the page content.",
      "Added internal links to relevant service pages.",
      "Added descriptive image alt text.",
      "Reviewed page indexability and SEO metadata.",
    ],
  },
  {
    name: "Ashley Saldaña",
    short: "Ashley Saldaña, LCSW",
    url: "https://bluejayfams.com/ashley-saldana/",
    path: "/ashley-saldana/",
    title: "Ashley Saldaña LCSW | Professional Mental Health Support",
    meta: "Meet Ashley Saldaña, LCSW, at Blue Jay Family Services for compassionate mental health support, emotional healing, and personalized care.",
    work: [
      "Optimized the SEO title and meta description.",
      "Incorporated relevant mental health and professional service keywords into the page content.",
      "Added internal links to relevant website pages.",
      "Added descriptive image alt text.",
      "Checked indexability and the self-referencing canonical URL.",
    ],
  },
  {
    name: "Specialities",
    short: "Specialities",
    url: "https://bluejayfams.com/specialities/",
    path: "/specialities/",
    title: "Therapy Services | Trusted Support for Life’s Challenges",
    meta: "Explore compassionate therapy services for anxiety, trauma, young adults, motherhood, parenting, and relationship concerns at Blue Jay Family Services.",
    work: [
      "Optimized the SEO title and meta description.",
      "Added relevant therapy and counseling keywords to the content.",
      "Added internal links to related therapy and counseling pages.",
      "Added descriptive image alt text.",
      "Reviewed page indexability and metadata.",
    ],
  },
  {
    name: "Court Services",
    short: "Court Services",
    url: "https://bluejayfams.com/court-services/",
    path: "/court-services/",
    title: "Court Mandated Counseling | Trusted Support",
    meta: "Court mandated counseling for anger management, reunification, co-parenting, and court-ordered counseling at Blue Jay Family Services.",
    work: [
      "Optimized the SEO title and meta description.",
      "Incorporated court-related counseling keywords naturally into the page content.",
      "Added internal links to relevant counseling services.",
      "Added descriptive image alt text.",
      "Reviewed the page's indexability and SEO metadata.",
    ],
  },
  {
    name: "Therapy FAQs",
    short: "Therapy FAQs",
    url: "https://bluejayfams.com/therapy-faqs/",
    path: "/therapy-faqs/",
    title: "Therapy FAQs | Helpful Questions & Answers",
    meta: "Get helpful answers to common therapy FAQs about confidentiality, online therapy, fees, insurance, cancellations, and getting started.",
    work: [
      "Optimized the SEO title and meta description.",
      "Incorporated relevant therapy FAQ keywords into the page content.",
      "Added internal links to relevant service pages.",
      "Added descriptive image alt text.",
      "Reviewed page indexability and available SEO metadata.",
    ],
  },
];

function card(slide, x, y, w, h, fill = C.white) {
  slide.addShape("roundRect", {
    x,
    y,
    w,
    h,
    fill: { color: fill },
    line: { color: C.line, width: 1 },
    rectRadius: 0.1,
  });
}

function footer(slide) {
  slide.addShape("rect", {
    x: 0,
    y: 7.18,
    w: 13.333,
    h: 0.32,
    fill: { color: C.navy },
  });
  slide.addText("Blue Jay Family Services", {
    x: 0.48,
    y: 7.18,
    w: 4.2,
    h: 0.32,
    fontFace: FONT,
    fontSize: 11,
    color: C.white,
    valign: "middle",
    margin: 0,
  });
  slide.addText("On-Page SEO Report   ·   October 14, 2026", {
    x: 4.5,
    y: 7.18,
    w: 5.6,
    h: 0.32,
    fontFace: FONT,
    fontSize: 11,
    color: C.mist,
    align: "center",
    valign: "middle",
    margin: 0,
  });
  slide.addText(`${String(slideNo).padStart(2, "0")}  /  ${String(TOTAL).padStart(2, "0")}`, {
    x: 10.4,
    y: 7.18,
    w: 2.45,
    h: 0.32,
    fontFace: FONT,
    fontSize: 11,
    color: C.white,
    align: "right",
    valign: "middle",
    margin: 0,
  });
}

function header(slide, eyebrow, title) {
  slide.addShape("rect", {
    x: 0,
    y: 0,
    w: 13.333,
    h: 0.08,
    fill: { color: C.blue },
  });
  slide.addShape("roundRect", {
    x: 0.48,
    y: 0.26,
    w: 0.18,
    h: 0.18,
    fill: { color: C.blue },
    rectRadius: 0.3,
  });
  slide.addText(eyebrow, {
    x: 0.78,
    y: 0.2,
    w: 11.8,
    h: 0.28,
    fontFace: FONT,
    fontSize: 12,
    bold: true,
    color: C.blue,
    margin: 0,
    charSpacing: 1.1,
    valign: "middle",
  });
  slide.addText(title, {
    x: 0.48,
    y: 0.5,
    w: 12.35,
    h: 0.46,
    fontFace: FONT,
    fontSize: 26,
    bold: true,
    color: C.ink,
    margin: 0,
    valign: "middle",
  });
}

function contentSlide(eyebrow, title) {
  slideNo += 1;
  const slide = pres.addSlide();
  slide.background = { color: C.ice };
  header(slide, eyebrow, title);
  footer(slide);
  return slide;
}

function coverSlide() {
  slideNo += 1;
  const s = pres.addSlide();
  s.background = { color: C.deep };

  s.addShape("rect", {
    x: 0,
    y: 6.42,
    w: 13.333,
    h: 1.08,
    fill: { color: C.navy },
  });

  s.addText("CLIENT REPORT", {
    x: 0.62,
    y: 0.48,
    w: 7.5,
    h: 0.3,
    fontFace: FONT,
    fontSize: 13,
    bold: true,
    color: C.mist,
    margin: 0,
    charSpacing: 1.6,
  });
  s.addShape("rect", {
    x: 0.62,
    y: 0.9,
    w: 1.15,
    h: 0.045,
    fill: { color: C.white },
  });
  s.addText("Blue Jay Family Services", {
    x: 0.62,
    y: 1.55,
    w: 8,
    h: 0.38,
    fontFace: FONT,
    fontSize: 18,
    color: C.mist,
    margin: 0,
  });
  s.addText("On-Page SEO\nOptimization Report", {
    x: 0.62,
    y: 2.05,
    w: 8,
    h: 1.85,
    fontFace: FONT,
    fontSize: 42,
    bold: true,
    color: C.white,
    margin: 0,
  });
  s.addText(
    "Completed on-page optimization for five pages covering family court counseling, therapy services, court services, a provider profile, and therapy FAQs.",
    {
      x: 0.62,
      y: 4.15,
      w: 7.7,
      h: 0.85,
      fontFace: FONT,
      fontSize: 16,
      color: "EAF3FC",
      margin: 0,
    },
  );

  s.addShape("roundRect", {
    x: 9.05,
    y: 0.42,
    w: 3.78,
    h: 5.62,
    fill: { color: C.navy },
    rectRadius: 0.08,
  });
  s.addText("PAGES IN THIS REPORT", {
    x: 9.3,
    y: 0.62,
    w: 3.3,
    h: 0.28,
    fontFace: FONT,
    fontSize: 11,
    bold: true,
    color: C.mist,
    margin: 0,
    charSpacing: 0.8,
  });

  pages.forEach((page, i) => {
    const y = 1.15 + i * 0.92;
    s.addText(String(i + 1).padStart(2, "0"), {
      x: 9.3,
      y,
      w: 0.5,
      h: 0.32,
      fontFace: FONT,
      fontSize: 13,
      bold: true,
      color: "7EB6F0",
      margin: 0,
    });
    s.addText(page.short, {
      x: 9.85,
      y,
      w: 2.7,
      h: 0.32,
      fontFace: FONT,
      fontSize: 14,
      bold: true,
      color: C.white,
      margin: 0,
    });
    s.addText(page.path, {
      x: 9.85,
      y: y + 0.3,
      w: 2.7,
      h: 0.26,
      fontFace: FONT,
      fontSize: 11,
      color: "9CC4EE",
      margin: 0,
    });
  });

  s.addText("Prepared for Blue Jay Family Services", {
    x: 0.62,
    y: 6.42,
    w: 5.4,
    h: 1.08,
    fontFace: FONT,
    fontSize: 14,
    color: C.white,
    valign: "middle",
    margin: 0,
  });
  s.addText("October 14, 2026", {
    x: 6.1,
    y: 6.42,
    w: 3.2,
    h: 1.08,
    fontFace: FONT,
    fontSize: 14,
    color: C.mist,
    align: "center",
    valign: "middle",
    margin: 0,
  });
  s.addText("bluejayfams.com", {
    x: 9.3,
    y: 6.42,
    w: 3.5,
    h: 1.08,
    fontFace: FONT,
    fontSize: 14,
    color: C.white,
    align: "right",
    valign: "middle",
    margin: 0,
    hyperlink: { url: "https://bluejayfams.com/" },
  });
}

function overviewSlide() {
  const s = contentSlide("PROJECT OVERVIEW", "A stronger on-page foundation");
  s.addText(
    "On-page SEO optimization was completed for five important pages of Blue Jay Family Services. The work strengthens page-level SEO, keyword relevance, internal linking, image accessibility, and indexability, while staying aligned with mental health, therapy, family counseling, and court-related services.",
    {
      x: 0.48,
      y: 1.12,
      w: 12.35,
      h: 0.78,
      fontFace: FONT,
      fontSize: 15,
      color: C.slate,
      margin: 0,
    },
  );

  const objectives = [
    ["Titles and metas", "Each page now has a clear SEO title and meta description."],
    ["Keyword relevance", "Service terms were added naturally into the existing content."],
    ["Internal linking", "Related services and information are connected across pages."],
    ["Access and indexing", "Images have descriptive alt text, and indexability was reviewed."],
  ];
  objectives.forEach((item, i) => {
    const x = 0.48 + i * 3.18;
    card(s, x, 2.1, 3.04, 2.85);
    s.addShape("roundRect", {
      x: x + 0.22,
      y: 2.32,
      w: 0.46,
      h: 0.46,
      fill: { color: C.soft },
      rectRadius: 0.2,
    });
    s.addText(String(i + 1).padStart(2, "0"), {
      x: x + 0.22,
      y: 2.32,
      w: 0.46,
      h: 0.46,
      fontFace: FONT,
      fontSize: 13,
      bold: true,
      color: C.blue,
      align: "center",
      valign: "middle",
      margin: 0,
    });
    s.addText(item[0], {
      x: x + 0.22,
      y: 2.96,
      w: 2.6,
      h: 0.7,
      fontFace: FONT,
      fontSize: 16,
      bold: true,
      color: C.ink,
      margin: 0,
    });
    s.addText(item[1], {
      x: x + 0.22,
      y: 3.7,
      w: 2.6,
      h: 0.95,
      fontFace: FONT,
      fontSize: 13,
      color: C.slate,
      margin: 0,
    });
  });

  card(s, 0.48, 5.15, 12.37, 1.8, C.white);
  s.addText("SCOPE OF THE WORK", {
    x: 0.74,
    y: 5.32,
    w: 6,
    h: 0.26,
    fontFace: FONT,
    fontSize: 11,
    bold: true,
    color: C.blue,
    margin: 0,
    charSpacing: 0.8,
  });
  s.addText(
    "Optimization focused on existing website content. Relevance to the practice’s mental health, therapy, family counseling, and court-related services was maintained. The five page URLs were reviewed for search engine indexability, and the Ashley Saldaña page was checked for a self-referencing canonical URL.",
    {
      x: 0.74,
      y: 5.64,
      w: 11.85,
      h: 1.05,
      fontFace: FONT,
      fontSize: 15,
      color: C.slate,
      margin: 0,
    },
  );
}

function directorySlide() {
  const s = contentSlide("PAGES OPTIMIZED", "Five pages updated");
  s.addText("Each page received an SEO title, meta description, keyword integration, internal links, alt text, and an indexability review.", {
    x: 0.48,
    y: 1.08,
    w: 12.3,
    h: 0.32,
    fontFace: FONT,
    fontSize: 14,
    color: C.slate,
    margin: 0,
  });

  pages.forEach((page, i) => {
    const y = 1.54 + i * 1.06;
    card(s, 0.48, y, 12.37, 0.96);
    s.addShape("roundRect", {
      x: 0.66,
      y: y + 0.24,
      w: 0.48,
      h: 0.48,
      fill: { color: C.deep },
      rectRadius: 0.18,
    });
    s.addText(String(i + 1).padStart(2, "0"), {
      x: 0.66,
      y: y + 0.24,
      w: 0.48,
      h: 0.48,
      fontFace: FONT,
      fontSize: 13,
      bold: true,
      color: C.white,
      align: "center",
      valign: "middle",
      margin: 0,
    });
    s.addText(page.name, {
      x: 1.32,
      y: y + 0.12,
      w: 6.3,
      h: 0.38,
      fontFace: FONT,
      fontSize: 16,
      bold: true,
      color: C.ink,
      margin: 0,
      valign: "middle",
    });
    s.addText(page.path, {
      x: 1.32,
      y: y + 0.48,
      w: 6.3,
      h: 0.3,
      fontFace: FONT,
      fontSize: 13,
      color: C.blue,
      margin: 0,
      hyperlink: { url: page.url },
    });
    s.addText(page.title, {
      x: 7.7,
      y: y + 0.16,
      w: 4.9,
      h: 0.64,
      fontFace: FONT,
      fontSize: 13,
      color: C.slate,
      margin: 0,
      valign: "middle",
      align: "right",
    });
  });
}

function pageSlide(page, index) {
  const s = contentSlide(`PAGE ${String(index + 1).padStart(2, "0")} OF 05`, page.name);
  s.addText(page.url, {
    x: 0.48,
    y: 1.05,
    w: 9.6,
    h: 0.28,
    fontFace: FONT,
    fontSize: 13,
    color: C.blue,
    margin: 0,
    hyperlink: { url: page.url },
  });
  s.addShape("roundRect", {
    x: 10.55,
    y: 1.02,
    w: 2.3,
    h: 0.34,
    fill: { color: C.greenBg },
    line: { color: "A7F3D0", width: 1 },
    rectRadius: 0.5,
  });
  s.addText("Completed", {
    x: 10.55,
    y: 1.02,
    w: 2.3,
    h: 0.34,
    fontFace: FONT,
    fontSize: 12,
    bold: true,
    color: C.green,
    align: "center",
    valign: "middle",
    margin: 0,
  });

  card(s, 0.48, 1.5, 12.37, 1.18, C.soft);
  s.addText("SEO TITLE", {
    x: 0.74,
    y: 1.62,
    w: 11.8,
    h: 0.24,
    fontFace: FONT,
    fontSize: 11,
    bold: true,
    color: C.blue,
    margin: 0,
    charSpacing: 0.8,
  });
  s.addText(page.title, {
    x: 0.74,
    y: 1.9,
    w: 11.85,
    h: 0.58,
    fontFace: FONT,
    fontSize: 20,
    bold: true,
    color: C.ink,
    margin: 0,
    valign: "middle",
  });

  card(s, 0.48, 2.82, 12.37, 1.28);
  s.addText("META DESCRIPTION", {
    x: 0.74,
    y: 2.94,
    w: 11.8,
    h: 0.24,
    fontFace: FONT,
    fontSize: 11,
    bold: true,
    color: C.blue,
    margin: 0,
    charSpacing: 0.8,
  });
  s.addText(page.meta, {
    x: 0.74,
    y: 3.22,
    w: 11.85,
    h: 0.7,
    fontFace: FONT,
    fontSize: 15,
    color: C.slate,
    margin: 0,
  });

  card(s, 0.48, 4.24, 12.37, 2.76);
  s.addText("WORK COMPLETED", {
    x: 0.74,
    y: 4.38,
    w: 11.8,
    h: 0.24,
    fontFace: FONT,
    fontSize: 11,
    bold: true,
    color: C.blue,
    margin: 0,
    charSpacing: 0.8,
  });
  page.work.forEach((item, i) => {
    const y = 4.74 + i * 0.42;
    s.addShape("ellipse", {
      x: 0.76,
      y: y + 0.04,
      w: 0.24,
      h: 0.24,
      fill: { color: C.greenBg },
    });
    s.addText("✓", {
      x: 0.76,
      y: y + 0.04,
      w: 0.24,
      h: 0.24,
      fontFace: FONT,
      fontSize: 11,
      bold: true,
      color: C.green,
      align: "center",
      valign: "middle",
      margin: 0,
    });
    s.addText(item, {
      x: 1.14,
      y,
      w: 11.4,
      h: 0.38,
      fontFace: FONT,
      fontSize: 14,
      color: C.ink,
      margin: 0,
      valign: "middle",
    });
  });
}

function keywordsSlide() {
  const s = contentSlide("KEYWORD OPTIMIZATION", "Service terms placed in context");
  s.addText(
    "Relevant keywords were incorporated into the appropriate page content to improve topical relevance for counseling and therapy services.",
    {
      x: 0.48,
      y: 1.08,
      w: 12.35,
      h: 0.4,
      fontFace: FONT,
      fontSize: 15,
      color: C.slate,
      margin: 0,
    },
  );

  const keywords = [
    "Anger Management",
    "Court-Ordered Counseling",
    "Reunification Counseling",
    "Co-Parenting",
    "Co-Parenting Counseling",
  ];
  keywords.forEach((keyword, i) => {
    const x = 0.48 + i * 2.52;
    card(s, x, 1.62, 2.4, 1.85);
    s.addText(String(i + 1).padStart(2, "0"), {
      x: x + 0.18,
      y: 1.78,
      w: 2.04,
      h: 0.28,
      fontFace: FONT,
      fontSize: 12,
      bold: true,
      color: C.blue,
      margin: 0,
    });
    s.addText(keyword, {
      x: x + 0.18,
      y: 2.14,
      w: 2.04,
      h: 1.05,
      fontFace: FONT,
      fontSize: 16,
      bold: true,
      color: C.ink,
      margin: 0,
    });
  });

  card(s, 0.48, 3.66, 12.37, 3.32);
  s.addText("HOW THE KEYWORDS WERE APPLIED", {
    x: 0.74,
    y: 3.84,
    w: 11.8,
    h: 0.28,
    fontFace: FONT,
    fontSize: 12,
    bold: true,
    color: C.blue,
    margin: 0,
    charSpacing: 0.7,
  });
  const activities = [
    "Added relevant keywords naturally within the existing page content.",
    "Aligned keywords with the relevant service pages.",
    "Improved the relevance of content for court-related counseling and family support.",
    "Supported connections between related service topics through internal linking.",
  ];
  activities.forEach((item, i) => {
    const y = 4.28 + i * 0.62;
    s.addShape("roundRect", {
      x: 0.74,
      y: y,
      w: 0.42,
      h: 0.42,
      fill: { color: C.soft },
      rectRadius: 0.2,
    });
    s.addText(String(i + 1), {
      x: 0.74,
      y,
      w: 0.42,
      h: 0.42,
      fontFace: FONT,
      fontSize: 14,
      bold: true,
      color: C.blue,
      align: "center",
      valign: "middle",
      margin: 0,
    });
    s.addText(item, {
      x: 1.34,
      y,
      w: 11.1,
      h: 0.42,
      fontFace: FONT,
      fontSize: 16,
      color: C.ink,
      margin: 0,
      valign: "middle",
    });
  });
}

function linkingSlide() {
  const s = contentSlide("INTERNAL LINKING", "Related services now connect");
  s.addText("Internal links were added across the selected pages so visitors and search engines can move between related services and information.", {
    x: 0.48,
    y: 1.08,
    w: 12.35,
    h: 0.42,
    fontFace: FONT,
    fontSize: 15,
    color: C.slate,
    margin: 0,
  });

  const items = [
    ["Court services", "Family court counseling content is connected with relevant court services."],
    ["Therapy and specialties", "Therapy and specialty content links to related counseling pages."],
    ["Clearer navigation", "Service pages and informational content are easier to move between."],
    ["Search context", "Relationships between relevant pages are easier for search engines to understand."],
  ];
  items.forEach((item, i) => {
    const col = i % 2;
    const row = Math.floor(i / 2);
    const x = 0.48 + col * 6.28;
    const y = 1.68 + row * 2.55;
    card(s, x, y, 6.1, 2.4);
    s.addShape("roundRect", {
      x: x + 0.26,
      y: y + 0.28,
      w: 0.52,
      h: 0.52,
      fill: { color: C.deep },
      rectRadius: 0.16,
    });
    s.addText(String(i + 1).padStart(2, "0"), {
      x: x + 0.26,
      y: y + 0.28,
      w: 0.52,
      h: 0.52,
      fontFace: FONT,
      fontSize: 14,
      bold: true,
      color: C.white,
      align: "center",
      valign: "middle",
      margin: 0,
    });
    s.addText(item[0], {
      x: x + 0.96,
      y: y + 0.32,
      w: 4.8,
      h: 0.46,
      fontFace: FONT,
      fontSize: 18,
      bold: true,
      color: C.ink,
      margin: 0,
      valign: "middle",
    });
    s.addText(item[1], {
      x: x + 0.28,
      y: y + 1.1,
      w: 5.54,
      h: 0.95,
      fontFace: FONT,
      fontSize: 15,
      color: C.slate,
      margin: 0,
    });
  });
}

function altTextSlide() {
  const s = contentSlide("IMAGE ALT TEXT", "Descriptive text on relevant images");
  s.addText("Descriptive alt text was added to relevant images across the five selected pages.", {
    x: 0.48,
    y: 1.08,
    w: 12.35,
    h: 0.36,
    fontFace: FONT,
    fontSize: 15,
    color: C.slate,
    margin: 0,
  });

  const items = [
    ["Accessibility", "Visitors using screen readers receive a useful description of each relevant image."],
    ["Search context", "Search engines receive clearer context about what those images show."],
    ["Image SEO", "Descriptive, relevant text supports image search understanding."],
    ["Page alignment", "Image descriptions align with the subject of each page where appropriate."],
  ];
  items.forEach((item, i) => {
    const y = 1.62 + i * 1.32;
    card(s, 0.48, y, 12.37, 1.2);
    s.addShape("roundRect", {
      x: 0.7,
      y: y + 0.32,
      w: 0.56,
      h: 0.56,
      fill: { color: C.soft },
      rectRadius: 0.16,
    });
    s.addText(String(i + 1).padStart(2, "0"), {
      x: 0.7,
      y: y + 0.32,
      w: 0.56,
      h: 0.56,
      fontFace: FONT,
      fontSize: 14,
      bold: true,
      color: C.blue,
      align: "center",
      valign: "middle",
      margin: 0,
    });
    s.addText(item[0], {
      x: 1.5,
      y: y + 0.16,
      w: 10.9,
      h: 0.38,
      fontFace: FONT,
      fontSize: 18,
      bold: true,
      color: C.ink,
      margin: 0,
      valign: "middle",
    });
    s.addText(item[1], {
      x: 1.5,
      y: y + 0.56,
      w: 10.9,
      h: 0.42,
      fontFace: FONT,
      fontSize: 15,
      color: C.slate,
      margin: 0,
    });
  });
}

function metadataSlide() {
  const s = contentSlide("SEO METADATA", "Titles and descriptions for all five pages");
  const aims = [
    ["Clear purpose", "Each snippet states what the page is for."],
    ["Service terms", "Relevant counseling and therapy terms are included."],
    ["Search display", "Pages are easier to understand in search results."],
    ["Content match", "Metadata stays relevant to the page and the practice."],
  ];
  aims.forEach((item, i) => {
    const x = 0.48 + i * 3.18;
    card(s, x, 1.12, 3.04, 1.18);
    s.addText(item[0], {
      x: x + 0.16,
      y: 1.22,
      w: 2.72,
      h: 0.32,
      fontFace: FONT,
      fontSize: 14,
      bold: true,
      color: C.ink,
      margin: 0,
    });
    s.addText(item[1], {
      x: x + 0.16,
      y: 1.54,
      w: 2.72,
      h: 0.62,
      fontFace: FONT,
      fontSize: 12,
      color: C.slate,
      margin: 0,
    });
  });

  const headerOpts = {
    fill: { color: C.deep },
    color: C.white,
    bold: true,
    align: "left",
    valign: "middle",
    fontFace: FONT,
    fontSize: 12,
    margin: [6, 8, 6, 10],
  };
  const cell = (text, fill) => ({
    text,
    options: {
      fill: { color: fill },
      color: C.ink,
      align: "left",
      valign: "middle",
      fontFace: FONT,
      fontSize: 11,
      margin: [5, 8, 5, 10],
    },
  });

  const rows = [
    [
      { text: "Page", options: headerOpts },
      { text: "SEO title", options: headerOpts },
      { text: "Meta description", options: headerOpts },
    ],
    ...pages.map((page, i) => {
      const fill = i % 2 === 0 ? C.white : "F8FBFE";
      return [cell(page.name, fill), cell(page.title, fill), cell(page.meta, fill)];
    }),
  ];

  s.addTable(rows, {
    x: 0.48,
    y: 2.48,
    w: 12.37,
    colW: [2.7, 4.15, 5.52],
    rowH: [0.38, 0.78, 0.78, 0.82, 0.7, 0.7],
    border: [
      { pt: 0, color: C.ice },
      { pt: 0, color: C.ice },
      { pt: 0.5, color: "E6EEF6" },
      { pt: 0, color: C.ice },
    ],
    fontFace: FONT,
    valign: "middle",
  });
}

function indexSlide() {
  const s = contentSlide("INDEXABILITY REVIEW", "Pages checked for search access");
  const items = [
    ["Five URLs reported as indexable", "The five listed page URLs were confirmed as indexable during review."],
    ["Canonical on Ashley Saldaña", "The Ashley Saldaña page was checked for a self-referencing canonical URL."],
    ["Page-level metadata reviewed", "Available SEO titles, descriptions, and related metadata were reviewed."],
  ];
  items.forEach((item, i) => {
    const y = 1.2 + i * 1.42;
    card(s, 0.48, y, 12.37, 1.28);
    s.addShape("ellipse", {
      x: 0.74,
      y: y + 0.4,
      w: 0.46,
      h: 0.46,
      fill: { color: C.greenBg },
    });
    s.addText("✓", {
      x: 0.74,
      y: y + 0.4,
      w: 0.46,
      h: 0.46,
      fontFace: FONT,
      fontSize: 16,
      bold: true,
      color: C.green,
      align: "center",
      valign: "middle",
      margin: 0,
    });
    s.addText(item[0], {
      x: 1.46,
      y: y + 0.2,
      w: 11,
      h: 0.4,
      fontFace: FONT,
      fontSize: 18,
      bold: true,
      color: C.ink,
      margin: 0,
    });
    s.addText(item[1], {
      x: 1.46,
      y: y + 0.64,
      w: 11,
      h: 0.4,
      fontFace: FONT,
      fontSize: 15,
      color: C.slate,
      margin: 0,
    });
  });

  card(s, 0.48, 5.52, 12.37, 1.46, C.soft);
  s.addText("NOTE", {
    x: 0.74,
    y: 5.68,
    w: 11.8,
    h: 0.24,
    fontFace: FONT,
    fontSize: 12,
    bold: true,
    color: C.blue,
    margin: 0,
    charSpacing: 0.8,
  });
  s.addText(
    "Indexability does not guarantee that a page is indexed by Google or will appear in search results. Rankings, impressions, clicks, and traffic still depend on crawling, competition, website authority, and ongoing SEO work.",
    {
      x: 0.74,
      y: 6.0,
      w: 11.85,
      h: 0.76,
      fontFace: FONT,
      fontSize: 14,
      color: C.slate,
      margin: 0,
    },
  );
}

function summarySlide() {
  const s = contentSlide("WORK COMPLETED", "Completed on-page activities");
  const activities = [
    "SEO title optimization",
    "Meta description optimization",
    "Keyword integration into content",
    "Internal linking",
    "Image alt text optimization",
    "Indexability review",
    "Canonical URL review for the Ashley Saldaña page",
    "Relevant counseling service keyword targeting",
  ];
  const headerOpts = {
    fill: { color: C.deep },
    color: C.white,
    bold: true,
    valign: "middle",
    fontFace: FONT,
    fontSize: 14,
    margin: [8, 12, 8, 14],
  };
  const rows = [
    [
      { text: "SEO activity", options: { ...headerOpts, align: "left" } },
      { text: "Status", options: { ...headerOpts, align: "center" } },
    ],
    ...activities.map((activity, i) => {
      const fill = i % 2 === 0 ? C.white : "F8FBFE";
      return [
        {
          text: activity,
          options: {
            fill: { color: fill },
            color: C.ink,
            align: "left",
            valign: "middle",
            fontFace: FONT,
            fontSize: 15,
            margin: [6, 12, 6, 14],
          },
        },
        {
          text: "Completed",
          options: {
            fill: { color: fill },
            color: C.green,
            bold: true,
            align: "center",
            valign: "middle",
            fontFace: FONT,
            fontSize: 15,
            margin: [6, 12, 6, 12],
          },
        },
      ];
    }),
  ];
  s.addTable(rows, {
    x: 0.48,
    y: 1.2,
    w: 12.37,
    colW: [9.17, 3.2],
    rowH: 0.58,
    border: [
      { pt: 0, color: C.ice },
      { pt: 0, color: C.ice },
      { pt: 0.6, color: "E6EEF6" },
      { pt: 0, color: C.ice },
    ],
    valign: "middle",
  });
}

function benefitsSlide() {
  const s = contentSlide("EXPECTED BENEFITS", "What this work supports");
  const benefits = [
    "Clearer understanding of each page’s topic and services.",
    "Stronger relevance for targeted counseling and therapy searches.",
    "Better navigation between related pages.",
    "Improved image accessibility and contextual relevance.",
    "A foundation for organic search visibility over time.",
  ];
  card(s, 0.48, 1.2, 8.05, 5.75);
  s.addText("THESE IMPROVEMENTS MAY HELP", {
    x: 0.74,
    y: 1.4,
    w: 7.5,
    h: 0.28,
    fontFace: FONT,
    fontSize: 12,
    bold: true,
    color: C.blue,
    margin: 0,
    charSpacing: 0.7,
  });
  benefits.forEach((item, i) => {
    const y = 1.9 + i * 0.92;
    s.addShape("roundRect", {
      x: 0.74,
      y,
      w: 0.46,
      h: 0.46,
      fill: { color: C.soft },
      rectRadius: 0.16,
    });
    s.addText(String(i + 1).padStart(2, "0"), {
      x: 0.74,
      y,
      w: 0.46,
      h: 0.46,
      fontFace: FONT,
      fontSize: 13,
      bold: true,
      color: C.blue,
      align: "center",
      valign: "middle",
      margin: 0,
    });
    s.addText(item, {
      x: 1.4,
      y,
      w: 6.8,
      h: 0.7,
      fontFace: FONT,
      fontSize: 16,
      color: C.ink,
      margin: 0,
      valign: "middle",
    });
  });

  card(s, 8.72, 1.2, 4.13, 5.75, C.navy);
  s.addText("A CLEAR EXPECTATION", {
    x: 8.98,
    y: 1.48,
    w: 3.65,
    h: 0.5,
    fontFace: FONT,
    fontSize: 13,
    bold: true,
    color: "7EB6F0",
    margin: 0,
    charSpacing: 0.6,
  });
  s.addText("Results take time", {
    x: 8.98,
    y: 2.1,
    w: 3.65,
    h: 0.7,
    fontFace: FONT,
    fontSize: 22,
    bold: true,
    color: C.white,
    margin: 0,
  });
  s.addText(
    "Actual changes in rankings, impressions, clicks, and traffic depend on Google’s crawling and indexing, competition, website authority, and ongoing SEO efforts.",
    {
      x: 8.98,
      y: 2.95,
      w: 3.65,
      h: 2.2,
      fontFace: FONT,
      fontSize: 15,
      color: "E7F1FB",
      margin: 0,
    },
  );
  s.addText("This report covers completed on-page work. It does not project a ranking or traffic outcome.", {
    x: 8.98,
    y: 5.35,
    w: 3.65,
    h: 1.2,
    fontFace: FONT,
    fontSize: 14,
    color: C.mist,
    margin: 0,
  });
}

function nextStepsSlide() {
  const s = contentSlide("RECOMMENDED NEXT STEPS", "Continue from this foundation");
  const steps = [
    ["Search Console", "Monitor impressions, clicks, and average keyword positions in Google Search Console."],
    ["Indexing status", "Review Google indexing status for the five optimized pages."],
    ["Keyword tracking", "Track performance for court-related counseling and co-parenting keywords."],
    ["More internal links", "Identify additional internal linking opportunities across relevant pages."],
    ["Content updates", "Review and update service content when new SEO opportunities are identified."],
  ];
  steps.forEach((step, i) => {
    const y = 1.18 + i * 1.12;
    card(s, 0.48, y, 12.37, 1.02);
    s.addShape("roundRect", {
      x: 0.68,
      y: y + 0.24,
      w: 0.54,
      h: 0.54,
      fill: { color: C.deep },
      rectRadius: 0.14,
    });
    s.addText(String(i + 1).padStart(2, "0"), {
      x: 0.68,
      y: y + 0.24,
      w: 0.54,
      h: 0.54,
      fontFace: FONT,
      fontSize: 14,
      bold: true,
      color: C.white,
      align: "center",
      valign: "middle",
      margin: 0,
    });
    s.addText(step[0], {
      x: 1.46,
      y: y + 0.12,
      w: 10.9,
      h: 0.36,
      fontFace: FONT,
      fontSize: 16,
      bold: true,
      color: C.ink,
      margin: 0,
    });
    s.addText(step[1], {
      x: 1.46,
      y: y + 0.48,
      w: 11,
      h: 0.38,
      fontFace: FONT,
      fontSize: 14,
      color: C.slate,
      margin: 0,
    });
  });
}

function closeSlide() {
  slideNo += 1;
  const s = pres.addSlide();
  s.background = { color: C.ice };
  s.addShape("rect", {
    x: 0,
    y: 0,
    w: 5.15,
    h: 7.5,
    fill: { color: C.deep },
  });
  s.addText("REPORT COMPLETE", {
    x: 0.48,
    y: 0.55,
    w: 4.3,
    h: 0.3,
    fontFace: FONT,
    fontSize: 13,
    bold: true,
    color: C.mist,
    margin: 0,
    charSpacing: 1.2,
  });
  s.addText("On-page SEO\nis in place.", {
    x: 0.48,
    y: 1.7,
    w: 4.3,
    h: 1.7,
    fontFace: FONT,
    fontSize: 32,
    bold: true,
    color: C.white,
    margin: 0,
  });
  s.addText("Five pages optimized for Blue Jay Family Services.", {
    x: 0.48,
    y: 3.6,
    w: 4.2,
    h: 0.8,
    fontFace: FONT,
    fontSize: 16,
    color: "E7F1FB",
    margin: 0,
  });
  s.addText("bluejayfams.com\ninfo@bluejayfams.com\n909-544-9322", {
    x: 0.48,
    y: 5.55,
    w: 4.2,
    h: 1.2,
    fontFace: FONT,
    fontSize: 15,
    color: C.white,
    margin: 0,
  });

  s.addText("Conclusion", {
    x: 5.55,
    y: 0.48,
    w: 7.3,
    h: 0.4,
    fontFace: FONT,
    fontSize: 14,
    bold: true,
    color: C.blue,
    margin: 0,
    charSpacing: 0.6,
  });
  s.addText("A foundation for ongoing search optimization", {
    x: 5.55,
    y: 0.9,
    w: 7.3,
    h: 0.85,
    fontFace: FONT,
    fontSize: 26,
    bold: true,
    color: C.ink,
    margin: 0,
  });
  card(s, 5.55, 1.95, 7.3, 3.15);
  s.addText(
    "On-page SEO optimization was completed for five key pages. The work included SEO titles and meta descriptions, natural keyword integration, internal linking, image alt text, and indexability checks.\n\nThese improvements support the website’s SEO structure and provide a foundation for ongoing organic search optimization.",
    {
      x: 5.8,
      y: 2.15,
      w: 6.85,
      h: 2.75,
      fontFace: FONT,
      fontSize: 15,
      color: C.slate,
      margin: 0,
    },
  );

  card(s, 5.55, 5.28, 3.52, 1.55);
  s.addText("PREPARED FOR", {
    x: 5.75,
    y: 5.44,
    w: 3.15,
    h: 0.24,
    fontFace: FONT,
    fontSize: 11,
    bold: true,
    color: C.blue,
    margin: 0,
    charSpacing: 0.7,
  });
  s.addText("Blue Jay\nFamily Services", {
    x: 5.75,
    y: 5.74,
    w: 3.15,
    h: 0.85,
    fontFace: FONT,
    fontSize: 16,
    bold: true,
    color: C.ink,
    margin: 0,
  });

  card(s, 9.22, 5.28, 3.63, 1.55);
  s.addText("REPORTING DATE", {
    x: 9.42,
    y: 5.44,
    w: 3.25,
    h: 0.24,
    fontFace: FONT,
    fontSize: 11,
    bold: true,
    color: C.blue,
    margin: 0,
    charSpacing: 0.7,
  });
  s.addText("October 14, 2026", {
    x: 9.42,
    y: 5.82,
    w: 3.25,
    h: 0.6,
    fontFace: FONT,
    fontSize: 18,
    bold: true,
    color: C.ink,
    margin: 0,
  });
}

coverSlide();
overviewSlide();
directorySlide();
pages.forEach((page, i) => pageSlide(page, i));
keywordsSlide();
linkingSlide();
altTextSlide();
metadataSlide();
indexSlide();
summarySlide();
benefitsSlide();
nextStepsSlide();
closeSlide();

if (slideNo !== TOTAL) {
  throw new Error(`Expected ${TOTAL} slides, built ${slideNo}`);
}

const out = process.argv[2] || "/tmp/pptx-build/Blue-Jay-Family-Services-On-Page-SEO-Report.pptx";
await pres.writeFile({ fileName: out });
console.log(`Wrote ${slideNo} slides to ${out}`);
