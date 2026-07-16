export type FAQItem = {
  question: string;
  answer: string;
};

export const faqs: FAQItem[] = [
  {
    question: 'How do I request a free estimate?',
    answer:
      'Call or text 916-871-4325, email info@pdqbuilt.com, or submit the form on our Contact page. Share a few photos and a short description of the work you need. We will follow up to schedule a site visit and provide a clear, written estimate with no obligation.',
  },
  {
    question: 'Is PDQ Construction licensed and insured?',
    answer:
      'Yes. PDQ Construction operates under California CSLB License #1013079 as a Class B General Building contractor. We are bonded and carry appropriate insurance so homeowners and commercial clients can hire with confidence. Always verify our license at cslb.ca.gov.',
  },
  {
    question: 'What areas do you serve?',
    answer:
      'We are based in Citrus Heights and serve the greater Sacramento Valley — including Sacramento, Roseville, Rocklin, Folsom, Elk Grove, Rancho Cordova, Fair Oaks, Orangevale, Carmichael, Antelope, Rio Linda, and nearby communities. If your project is outside this list, contact us and we will let you know if we can help.',
  },
  {
    question: 'What types of projects do you take on?',
    answer:
      'As a full-service general contractor, we handle residential remodeling, home additions, kitchen and bathroom renovations, new construction, commercial build-outs, ADUs, garage conversions, and custom specialty projects. If it requires permits, structure, and professional finish work, we are built for it.',
  },
  {
    question: 'How long does a typical remodel take?',
    answer:
      'Timelines depend on scope. A focused bathroom remodel may take a few weeks, while a full kitchen or multi-room renovation can run longer. Additions and new construction follow their own schedules based on engineering, permits, and material lead times. After the site visit, we provide a realistic timeline in your written estimate.',
  },
  {
    question: 'Do you handle permits?',
    answer:
      'Yes. For projects that require city or county permits, we coordinate the permit process, prepare documentation as needed, and schedule inspections. Proper permitting protects your investment and keeps the work code-compliant — we do not cut corners on this step.',
  },
  {
    question: 'Can I see examples of past work?',
    answer:
      'Absolutely. Browse our Portfolio page for real project photography from Sacramento-area jobs. We can also walk through relevant past work during your consultation so you can see craftsmanship that matches the type of project you are planning.',
  },
  {
    question: 'Do you offer financing?',
    answer:
      'We do not directly underwrite financing, but many clients use home equity lines, personal loans, or third-party remodeling financing. We can discuss payment milestones that align with construction phases so cash flow stays clear throughout the project.',
  },
  {
    question: 'What is your payment schedule?',
    answer:
      'Payment schedules are outlined in your contract and typically follow project milestones — for example a deposit to start, progress payments at defined phases, and a final payment after walkthrough. Exact terms depend on project size and duration. Everything is documented in writing before work begins.',
  },
  {
    question: 'How do I get started with PDQ Construction?',
    answer:
      'Start with a free estimate request. We review your goals, visit the property when needed, and deliver a written scope and quote. Once you approve, we lock in the schedule, handle permits if required, and begin construction with regular updates until final walkthrough.',
  },
];

export const homeFaqs = faqs.slice(0, 3);
