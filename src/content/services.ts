export type Service = {
  slug: string;
  title: string;
  shortTitle: string;
  summary: string;
  description: string;
  details: string[];
  benefits: string[];
  image: string;
  icon: string;
};

export const services: Service[] = [
  {
    slug: 'residential-remodeling',
    title: 'Residential Remodeling',
    shortTitle: 'Remodeling',
    summary:
      'Complete interior renovations — kitchens, bathrooms, living spaces — designed for lasting quality and everyday comfort.',
    description:
      'PDQ Construction delivers full-service residential remodeling for Sacramento-area homeowners who want more than a cosmetic refresh. We open walls when needed, reconfigure layouts, update systems, and finish every surface with the same care we bring to new construction. Whether you are refreshing a single room or transforming the entire home, our Class B general building license means one accountable team from demo through final walkthrough.',
    details: [
      'Whole-home and room-by-room renovations planned around your lifestyle and budget',
      'Structural modifications, framing, drywall, flooring, paint, and finish carpentry',
      'Coordination of plumbing, electrical, HVAC, and specialty trades under one roof',
      'Clear written scopes so you know exactly what is included before work begins',
      'Clean job sites with daily protection of finished living areas',
    ],
    benefits: [
      'Increased home value and everyday functionality',
      'Code-compliant workmanship built for California standards',
      'Single point of contact for the full remodel',
      'Transparent timelines with progress updates',
    ],
    image: '/images/projects/project-29.jpg',
    icon: 'home',
  },
  {
    slug: 'home-additions',
    title: 'Home Additions',
    shortTitle: 'Additions',
    summary:
      'Expand your living space with structurally sound additions built to California code — rooms, second stories, and more.',
    description:
      'When your family outgrows the floor plan, PDQ Construction designs and builds additions that feel like they were always part of the home. From primary suites and family rooms to second-story expansions, we handle engineering coordination, permits, foundations, framing, roofing, and seamless interior finishes so the new space matches the old in quality and character.',
    details: [
      'Room additions, primary suites, and multi-room expansions',
      'Second-story additions with structural engineering support',
      'Foundation work, framing, roofing, windows, and exterior finishes',
      'Interior build-out including insulation, electrical, plumbing, and HVAC tie-ins',
      'Matching exterior materials and trim for a cohesive curb presence',
    ],
    benefits: [
      'More living space without leaving your neighborhood',
      'Proper structural design for long-term performance',
      'Permits and inspections managed for you',
      'Finishes that blend with the existing home',
    ],
    image: '/images/projects/project-01.jpg',
    icon: 'building',
  },
  {
    slug: 'kitchen-bath',
    title: 'Kitchen & Bathroom Remodels',
    shortTitle: 'Kitchen & Bath',
    summary:
      'Custom kitchen and bathroom remodels with premium finishes, precise installation, and layouts that work harder for you.',
    description:
      'Kitchens and baths are where craftsmanship shows. PDQ Construction rebuilds these high-use spaces with durable materials, smart layouts, and finishes that photograph as well as they perform. From quartz counters and custom cabinetry to tile showers and luxury fixtures, we manage every trade so the result is tight, clean, and ready for daily life.',
    details: [
      'Full kitchen gut renovations — cabinets, counters, backsplash, appliances, lighting',
      'Bathroom remodels including showers, tubs, vanity, tile, and waterproofing',
      'Layout changes for better flow, storage, and natural light',
      'Plumbing and electrical upgrades to support modern fixtures and appliances',
      'Punch-list perfection on hardware, caulk lines, and finish details',
    ],
    benefits: [
      'Premium materials installed to manufacturer standards',
      'Waterproofing and prep done right the first time',
      'Design guidance on finishes that hold up in Sacramento living',
      'A kitchen or bath you are proud to show guests',
    ],
    image: '/images/projects/project-29.jpg',
    icon: 'utensils',
  },
  {
    slug: 'new-construction',
    title: 'New Construction',
    shortTitle: 'New Builds',
    summary:
      'Ground-up residential construction managed from planning and permits through final inspection and handover.',
    description:
      'Building from the ground up requires disciplined project management. As a licensed general building contractor, PDQ Construction oversees new residential construction — site prep coordination, foundations, framing, systems, and finishes — with the same “pretty darn quick” accountability our clients expect. You get one team responsible for schedule, quality, and communication from first stake to keys in hand.',
    details: [
      'Custom homes and ground-up residential builds',
      'Coordination with architects, engineers, and inspectors',
      'Foundation, framing, roofing, and weather barrier installation',
      'Full mechanical, electrical, and plumbing rough-in and finish',
      'Interior and exterior finishes through final walkthrough',
    ],
    benefits: [
      'Single general contractor accountability',
      'Schedule-driven construction with clear milestones',
      'Code compliance and inspection readiness',
      'Quality control at every phase of the build',
    ],
    image: '/images/projects/project-27.jpg',
    icon: 'hammer',
  },
  {
    slug: 'commercial-buildouts',
    title: 'Commercial Build-Outs',
    shortTitle: 'Commercial',
    summary:
      'Tenant improvements, office renovations, and commercial spaces executed cleanly with minimal business disruption.',
    description:
      'Commercial projects demand speed, compliance, and respect for operating businesses. PDQ Construction delivers tenant improvements and commercial renovations across the Sacramento Valley — from office suites and retail interiors to light commercial build-outs — with licensed craftsmanship and clear communication for owners, property managers, and tenants.',
    details: [
      'Office and retail tenant improvements',
      'Multi-room commercial renovations and space reconfiguration',
      'ADA-aware planning and code-compliant construction',
      'Phased work plans to reduce downtime for open businesses',
      'Coordination with landlords, architects, and city inspectors',
    ],
    benefits: [
      'Professional results that support your brand',
      'Efficient scheduling around business operations',
      'Licensed general contractor for commercial scopes',
      'Clear documentation and change-order discipline',
    ],
    image: '/images/projects/project-02.jpg',
    icon: 'briefcase',
  },
  {
    slug: 'custom-projects',
    title: 'Custom Projects',
    shortTitle: 'Custom',
    summary:
      'ADUs, garage conversions, outdoor living, and specialty builds tailored to your property and vision.',
    description:
      'Not every project fits a standard category. PDQ Construction handles custom residential work — accessory dwelling units, garage conversions, outdoor structures, and specialty renovations — with the same licensed general contracting approach we use on larger builds. If it needs permits, structure, and finish quality, we are built for it.',
    details: [
      'Accessory dwelling units (ADUs) and junior ADUs',
      'Garage and basement conversions into livable space',
      'Outdoor living areas, covered patios, and specialty structures',
      'Custom carpentry, framing, and finish projects',
      'Problem-solving renovations for unique Sacramento homes',
    ],
    benefits: [
      'Flexible scope for non-standard projects',
      'Permit guidance for ADUs and conversions',
      'Creative solutions without sacrificing quality',
      'A finished space that fits how you actually live',
    ],
    image: '/images/projects/heic-01.jpg',
    icon: 'wrench',
  },
];

export function getServiceBySlug(slug: string) {
  return services.find((s) => s.slug === slug);
}
