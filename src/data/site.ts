export const site = {
  name: 'Operation 17:2',
  tagline: 'Protecting the Innocent',
  description:
    'A Christ-centered non-profit organization dedicated to protecting vulnerable children, defending those who cannot speak for themselves, and reflecting the justice, mercy, and truth of Jesus Christ through bold action, compassion, and unwavering biblical conviction.',
  url: 'https://www.op17two.com',
  email: 'op17two@gmail.com',
  location: 'Illinois, United States',
  verse: 'It would be better to be thrown into the sea with a millstone hung around your neck than to cause one of these little ones to fall into sin.',
  verseRef: 'Luke 17:2',
  donations: {
    donorbox: 'https://donorbox.org/operation-17-2',
    venmo: '@Op17two',
    paypal: '@op17two',
    goal: 50000,
    raised: 32450,
  },
  social: {
    facebook: 'https://facebook.com/op17two',
    instagram: 'https://instagram.com/op17two',
    youtube: 'https://youtube.com/@op17two',
    x: 'https://x.com/op17two',
  },
} as const;

export const navigation = [
  { label: 'Home', href: '/' },
  {
    label: 'About Us',
    href: '/about',
    children: [
      { label: 'Mission', href: '/about#mission' },
      { label: 'How It Works', href: '/about#how-it-works' },
      { label: 'Statement of Faith', href: '/about#values' },
      { label: 'Leadership & Team', href: '/about#leadership' },
    ],
  },
  {
    label: 'Get Involved',
    href: '/get-involved',
    children: [
      { label: 'Roles Overview', href: '/get-involved' },
      { label: 'Apply', href: '/get-involved/apply' },
      { label: 'Prayer Team', href: '/get-involved/prayer-team' },
      { label: 'Media Team', href: '/get-involved/media-team' },
      { label: 'Online Decoy Team', href: '/get-involved/online-decoy-team' },
      { label: 'Operations Team', href: '/get-involved/operations-team' },
    ],
  },
  { label: 'Donate', href: '/donate' },
  { label: 'Live Prayer Calls', href: '/live-prayer-calls' },
  { label: 'Shop', href: '/shop' },
  { label: 'Resources', href: '/resources' },
  { label: 'Contact', href: '/contact' },
] as const;

export const leadership = [
  {
    name: 'Founder & Director',
    role: 'Executive Leadership',
    bio: 'Leads Operation 17:2 with a singular focus on protecting children and bringing predators to justice, guided by Luke 17:2.',
  },
  {
    name: 'Operations Lead',
    role: 'Field Operations',
    bio: 'Oversees decoy operations, coordinates field teams, and ensures every mission is conducted with integrity and safety.',
  },
  {
    name: 'Prayer Coordinator',
    role: 'Intercession & Support',
    bio: 'Mobilizes the prayer community to cover operations, team members, and the children we serve.',
  },
  {
    name: 'Media Director',
    role: 'Communications',
    bio: 'Amplifies our mission through content, awareness campaigns, and community engagement across all platforms.',
  },
] as const;

export const prayerSchedule = [
  {
    day: 'Monday',
    time: '7:00 PM CST',
    topic: 'Operation Cover & Protection',
    host: 'Prayer Team Lead',
  },
  {
    day: 'Wednesday',
    time: '12:00 PM CST',
    topic: 'Midweek Intercession',
    host: 'Community Prayer',
  },
  {
    day: 'Friday',
    time: '8:00 PM CST',
    topic: 'Mission Prayer & Testimony',
    host: 'Founder & Prayer Team',
  },
  {
    day: 'Sunday',
    time: '6:00 AM CST',
    topic: 'Sunday Morning Cover',
    host: 'Prayer Warriors',
  },
] as const;

export const resources = [
  {
    title: 'Understanding Child Exploitation',
    category: 'Education',
    description: 'Learn about the scope of online child exploitation and how communities can respond.',
    type: 'Guide',
  },
  {
    title: 'How Decoy Operations Work',
    category: 'Operations',
    description: 'An overview of how Operation 17:2 conducts online decoy operations to protect children.',
    type: 'Article',
  },
  {
    title: 'Prayer Guide for Missions',
    category: 'Spiritual',
    description: 'Scripture-based prayer points for covering our teams and the children we protect.',
    type: 'PDF',
  },
  {
    title: 'Safety Resources for Parents',
    category: 'Family',
    description: 'Practical steps parents can take to protect their children online and offline.',
    type: 'Guide',
  },
  {
    title: 'Volunteer Handbook',
    category: 'Get Involved',
    description: 'Everything you need to know before joining the Operation 17:2 team.',
    type: 'PDF',
  },
  {
    title: 'FAQ',
    category: 'General',
    description: 'Answers to common questions about our mission, apparel, donations, and operations.',
    type: 'Article',
  },
] as const;
