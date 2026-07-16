export type Testimonial = {
  quote: string;
  name: string;
  location: string;
  rating: number;
};

export const testimonials: Testimonial[] = [
  {
    quote:
      'PDQ remodeled our kitchen and the quality exceeded our expectations. The team was professional, kept the site clean, and finished exactly as promised.',
    name: 'Sacramento Homeowner',
    location: 'Sacramento, CA',
    rating: 5,
  },
  {
    quote:
      'Our home addition was completed on schedule and the craftsmanship is outstanding. Clear communication from estimate through final walkthrough.',
    name: 'Citrus Heights Client',
    location: 'Citrus Heights, CA',
    rating: 5,
  },
  {
    quote:
      'Clear communication, fair pricing, and excellent results. Highly recommend PDQ Construction for anyone needing a licensed general contractor in the Sacramento area.',
    name: 'Roseville Property Owner',
    location: 'Roseville, CA',
    rating: 5,
  },
];

export const whyChooseUs = [
  {
    title: 'Licensed Class B General Contractor',
    description: `Operating under CSLB License #1013079 with the credentials and accountability a serious project deserves.`,
  },
  {
    title: 'Transparent Pricing',
    description:
      'Written estimates with clear scope — no hidden surprises, no vague allowances that balloon at the end.',
  },
  {
    title: 'Sacramento Valley Focused',
    description:
      'Locally owned and rooted in Citrus Heights — we know local codes, neighborhoods, and how Sacramento homes are built.',
  },
  {
    title: 'Clean Professional Job Sites',
    description:
      'We protect floors, manage debris, and leave the property respectful every day — not just at handover.',
  },
  {
    title: 'Quality Materials & Craftsmanship',
    description:
      'Durable products installed with precision finishing so your remodel or addition performs for years.',
  },
  {
    title: 'On-Time Project Delivery',
    description:
      'Pretty Darn Quick means disciplined scheduling and communication — we respect your time and your home.',
  },
];

export const aboutContent = {
  heroTitle: 'Built on Trust. Driven by Quality.',
  heroSubtitle:
    'PDQ Construction is a Sacramento-area Class B general building contractor delivering residential and commercial construction with speed, integrity, and premium craftsmanship.',
  storyTitle: 'Our Story',
  story: [
    'PDQ Construction was built on a simple idea: homeowners and businesses deserve construction that is both fast and done right. Operating under California CSLB License #1013079, we serve Citrus Heights, Sacramento, and the surrounding valley as a full-service general building contractor.',
    'Since 2016, our team has delivered remodeling, additions, kitchen and bath renovations, new construction, commercial build-outs, and custom projects. We believe great construction starts with honest quotes, proper planning, and skilled execution — never shortcuts.',
    'Whether we are opening walls for a kitchen remodel or framing a new addition, every project gets the same standard: clear communication, code-compliant workmanship, and a clean handover you can be proud of.',
  ],
  mission:
    'To provide reliable, code-compliant construction services that exceed client expectations — with clear communication at every step from first call to final walkthrough.',
  vision:
    'To be the most trusted general contractor in the Sacramento Valley, known for quality workmanship, integrity, and results delivered Pretty Darn Quick.',
  values: [
    {
      title: 'Integrity',
      description: 'Honest scopes, fair pricing, and work we stand behind long after the job is done.',
    },
    {
      title: 'Quality',
      description: 'Premium materials and craftsmanship that look right and perform under daily use.',
    },
    {
      title: 'Communication',
      description: 'Updates you can count on — no radio silence when decisions need to be made.',
    },
    {
      title: 'Accountability',
      description: 'One licensed general contractor responsible for schedule, trades, and finish quality.',
    },
    {
      title: 'Community',
      description: 'Local Sacramento Valley roots — we build where we live and work.',
    },
  ],
};
