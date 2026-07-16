export type ProjectCategory =
  | 'remodeling'
  | 'additions'
  | 'kitchen-bath'
  | 'commercial'
  | 'custom';

export type Project = {
  id: string;
  title: string;
  category: ProjectCategory;
  categoryLabel: string;
  location: string;
  description: string;
  image: string;
  featured?: boolean;
};

export const portfolioFilters = [
  { id: 'all', label: 'All' },
  { id: 'remodeling', label: 'Remodeling' },
  { id: 'additions', label: 'Additions' },
  { id: 'kitchen-bath', label: 'Kitchen & Bath' },
  { id: 'commercial', label: 'Commercial' },
  { id: 'custom', label: 'Custom' },
] as const;

export const projects: Project[] = [
  {
    id: 'p01',
    title: 'Full Interior Structural Remodel',
    category: 'remodeling',
    categoryLabel: 'Remodeling',
    location: 'Sacramento County, CA',
    description:
      'Exposed framing and systems upgrade during a deep residential remodel — structure, mechanicals, and layout rebuilt for modern living.',
    image: '/images/projects/heic-01.jpg',
    featured: true,
  },
  {
    id: 'p02',
    title: 'Luxury Kitchen Renovation',
    category: 'kitchen-bath',
    categoryLabel: 'Kitchen & Bath',
    location: 'Sacramento, CA',
    description:
      'Quartz counters, stainless appliances, and custom cabinetry installed as part of a premium kitchen remodel.',
    image: '/images/projects/project-29.jpg',
    featured: true,
  },
  {
    id: 'p03',
    title: 'Rio Linda Property Build-Out',
    category: 'custom',
    categoryLabel: 'Custom',
    location: 'Rio Linda, CA',
    description:
      'On-site construction progress at a Rio Linda property, showcasing framing, exterior work, and site coordination.',
    image: '/images/projects/project-30.jpg',
    featured: true,
  },
  {
    id: 'p04',
    title: 'Residential Framing Package',
    category: 'additions',
    categoryLabel: 'Additions',
    location: 'Citrus Heights, CA',
    description:
      'Precision framing for expanded living space with clean lines and inspection-ready structure.',
    image: '/images/projects/project-01.jpg',
    featured: true,
  },
  {
    id: 'p05',
    title: 'Modern Living Space Conversion',
    category: 'custom',
    categoryLabel: 'Custom',
    location: 'Sacramento Valley, CA',
    description:
      'Garage and interior conversion work transforming underused square footage into functional living space.',
    image: '/images/projects/project-02.jpg',
    featured: true,
  },
  {
    id: 'p06',
    title: 'Whole-Home Systems Upgrade',
    category: 'remodeling',
    categoryLabel: 'Remodeling',
    location: 'Fair Oaks, CA',
    description:
      'Plumbing, electrical, and structural updates coordinated during a comprehensive residential renovation.',
    image: '/images/projects/project-03.jpg',
    featured: true,
  },
  {
    id: 'p07',
    title: 'Primary Suite Addition Progress',
    category: 'additions',
    categoryLabel: 'Additions',
    location: 'Roseville, CA',
    description:
      'New addition framed and weather-ready, expanding the home with a primary living wing.',
    image: '/images/projects/project-04.jpg',
  },
  {
    id: 'p08',
    title: 'Finish Carpentry & Interior Detail',
    category: 'remodeling',
    categoryLabel: 'Remodeling',
    location: 'Carmichael, CA',
    description:
      'Fine interior finish work — trim, doors, and surfaces — executed with premium attention to detail.',
    image: '/images/projects/project-05.jpg',
  },
  {
    id: 'p09',
    title: 'Bathroom Rough-In & Remodel',
    category: 'kitchen-bath',
    categoryLabel: 'Kitchen & Bath',
    location: 'Orangevale, CA',
    description:
      'Waterproofing, plumbing rough-in, and layout prep for a high-end bathroom renovation.',
    image: '/images/projects/project-06.jpg',
  },
  {
    id: 'p10',
    title: 'Exterior Construction Phase',
    category: 'custom',
    categoryLabel: 'Custom',
    location: 'Elk Grove, CA',
    description:
      'Exterior shell and site work progressing on a residential construction project.',
    image: '/images/projects/project-07.jpg',
  },
  {
    id: 'p11',
    title: 'Commercial Interior Build-Out',
    category: 'commercial',
    categoryLabel: 'Commercial',
    location: 'Sacramento, CA',
    description:
      'Tenant improvement framing and interior construction for a commercial space.',
    image: '/images/projects/project-08.jpg',
  },
  {
    id: 'p12',
    title: 'Kitchen Layout Transformation',
    category: 'kitchen-bath',
    categoryLabel: 'Kitchen & Bath',
    location: 'Folsom, CA',
    description:
      'Open kitchen layout remodel with premium counters and integrated appliance zones.',
    image: '/images/projects/project-09.jpg',
  },
  {
    id: 'p13',
    title: 'Structural Framing Detail',
    category: 'additions',
    categoryLabel: 'Additions',
    location: 'Rocklin, CA',
    description:
      'Engineered framing connections and load-bearing updates for a residential addition.',
    image: '/images/projects/project-10.jpg',
  },
  {
    id: 'p14',
    title: 'Full Remodel Mid-Phase',
    category: 'remodeling',
    categoryLabel: 'Remodeling',
    location: 'Antelope, CA',
    description:
      'Active remodel documenting drywall, systems, and finish sequencing across multiple rooms.',
    image: '/images/projects/project-11.jpg',
  },
  {
    id: 'p15',
    title: 'Custom Interior Build',
    category: 'custom',
    categoryLabel: 'Custom',
    location: 'Rancho Cordova, CA',
    description:
      'Specialty interior construction tailored to a unique floor plan and client brief.',
    image: '/images/projects/project-12.jpg',
  },
  {
    id: 'p16',
    title: 'Residential Site Progress',
    category: 'remodeling',
    categoryLabel: 'Remodeling',
    location: 'North Highlands, CA',
    description:
      'On-site progress photography from an active PDQ Construction residential project.',
    image: '/images/projects/project-13.jpg',
  },
  {
    id: 'p17',
    title: 'Addition Envelope & Roof',
    category: 'additions',
    categoryLabel: 'Additions',
    location: 'Lincoln, CA',
    description:
      'Roof and envelope work tying a new addition into the existing home structure.',
    image: '/images/projects/project-14.jpg',
  },
  {
    id: 'p18',
    title: 'Premium Finish Installation',
    category: 'kitchen-bath',
    categoryLabel: 'Kitchen & Bath',
    location: 'Auburn, CA',
    description:
      'Final-stage finish installation for a high-end residential interior package.',
    image: '/images/projects/project-15.jpg',
  },
];

export const featuredProjects = projects.filter((p) => p.featured).slice(0, 6);
