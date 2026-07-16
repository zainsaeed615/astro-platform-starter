export type ProcessStep = {
  number: string;
  title: string;
  summary: string;
  details: string[];
};

export const processSteps: ProcessStep[] = [
  {
    number: '01',
    title: 'Initial Consultation',
    summary: 'We discuss your vision, timeline, and budget — by phone, form, or on-site.',
    details: [
      'Share photos, sketches, or inspiration for the space you want to create',
      'We clarify goals: remodel, addition, kitchen/bath, commercial, or custom work',
      'Early budget ranges help us recommend the right scope and materials',
      'No-pressure conversation — you decide if PDQ is the right fit',
    ],
  },
  {
    number: '02',
    title: 'On-Site Evaluation',
    summary: 'We visit your property, assess conditions, take measurements, and note access needs.',
    details: [
      'Structural, layout, and systems review relevant to your project',
      'Measurements and photos for accurate estimating',
      'Discussion of finishes, fixtures, and practical daily-use requirements',
      'Identification of permits, engineering, or specialty trades if needed',
    ],
  },
  {
    number: '03',
    title: 'Detailed Written Estimate',
    summary: 'You receive a transparent quote covering scope, materials approach, and timeline.',
    details: [
      'Written scope of work so inclusions and exclusions are clear',
      'Pricing structured around the phases of construction',
      'Suggested materials and finish levels aligned to your budget',
      'Estimated start window and project duration',
    ],
  },
  {
    number: '04',
    title: 'Construction & Updates',
    summary: 'Expert build phase with protected job sites and regular progress communication.',
    details: [
      'Permits pulled and inspections scheduled when required',
      'Skilled construction with attention to structure, systems, and finish quality',
      'Daily site care — we respect your home and neighbors',
      'Progress updates so you always know what is happening next',
    ],
  },
  {
    number: '05',
    title: 'Final Inspection & Walkthrough',
    summary: 'Punch list completion, client sign-off, and a clean handover ready for use.',
    details: [
      'Final inspection coordination for permitted work',
      'Detailed walkthrough of every finished area',
      'Punch list items completed before final payment',
      'Clean site turnover — you get a space ready to live in or open for business',
    ],
  },
];

export const homeProcessSteps = processSteps.slice(0, 4).map((step, index) => ({
  ...step,
  number: String(index + 1).padStart(2, '0'),
}));

export const whatToExpect = [
  {
    title: 'Typical Timelines',
    body: 'Focused bathroom or kitchen scopes often span several weeks. Multi-room remodels and additions take longer depending on engineering, permits, and material lead times. Your written estimate includes a realistic schedule for your project.',
  },
  {
    title: 'Permits & Inspections',
    body: 'When permits are required, PDQ Construction coordinates applications and inspections with the local building department. Code-compliant work protects your property and future resale value.',
  },
  {
    title: 'Payment Structure',
    body: 'Contracts outline deposit and milestone payments tied to construction progress. You always know what you are paying for and when — no surprise invoices for work that was never agreed.',
  },
  {
    title: 'Communication',
    body: 'You receive regular updates throughout the build. Questions are answered promptly by phone or text at 916-871-4325 so decisions never stall your project.',
  },
];
