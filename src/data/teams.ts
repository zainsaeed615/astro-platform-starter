export const teamPages = {
  'prayer-team': {
    title: 'Prayer Team',
    label: 'Intercession',
    icon: 'heart',
    description:
      'The Prayer Team is the spiritual backbone of Operation 17:2. Before any operation, during every mission, and after each encounter — our prayer warriors stand in the gap.',
    responsibilities: [
      'Participate in scheduled live prayer calls',
      'Cover specific operations and team members with targeted prayer',
      'Respond to urgent prayer requests from the field',
      'Join the midweek and weekend intercession schedule',
      'Mobilize your local church or community to pray for the mission',
    ],
  },
  'media-team': {
    title: 'Media Team',
    label: 'Communications',
    icon: 'camera',
    description:
      'The Media Team amplifies our mission to the world. Through content creation, social media, and awareness campaigns, you help reach more people with the message of child protection.',
    responsibilities: [
      'Create and manage social media content across platforms',
      'Produce video content for awareness and education',
      'Design graphics for campaigns, apparel, and events',
      'Write blog posts, newsletters, and mission updates',
      'Help manage the website and online presence',
    ],
  },
  'online-decoy-team': {
    title: 'Online Decoy Team',
    label: 'Front Line Operations',
    icon: 'target',
    description:
      'The Online Decoy Team operates on the front lines of child protection. Through controlled online operations, team members help identify and pursue child predators.',
    responsibilities: [
      'Conduct online decoy operations under strict protocols',
      'Document and report findings to law enforcement partners',
      'Maintain operational security and confidentiality at all times',
      'Complete required training and background verification',
      'Participate in debriefing and team coordination meetings',
    ],
  },
  'operations-team': {
    title: 'Operations Team',
    label: 'Field Support',
    icon: 'shield',
    description:
      'The Operations Team ensures every mission runs smoothly. From logistics and travel to equipment and coordination, this team keeps the mission moving.',
    responsibilities: [
      'Coordinate travel, lodging, and operational logistics',
      'Manage equipment inventory and procurement',
      'Support decoy phone operations and technical needs',
      'Assist with law enforcement coordination and documentation',
      'Maintain operational records and security protocols',
    ],
  },
} as const;

export type TeamSlug = keyof typeof teamPages;
