export const mainNav = [
    { label: 'Home', href: '/' },
    {
        label: 'About Us',
        href: '/about',
        children: [
            { label: 'Mission', href: '/about/mission' },
            { label: 'How It Works', href: '/about/how-it-works' },
            { label: 'Statement of Faith', href: '/about/values' },
            { label: 'Leadership & Team', href: '/about/leadership' }
        ]
    },
    {
        label: 'Get Involved',
        href: '/get-involved',
        children: [
            { label: 'Roles Overview', href: '/get-involved' },
            { label: 'Apply', href: '/get-involved/apply' },
            { label: 'Prayer Team', href: '/get-involved/prayer-team' },
            { label: 'Media Team', href: '/get-involved/media-team' },
            { label: 'Online Decoy Team', href: '/get-involved/decoy-team' },
            { label: 'Operations Team', href: '/get-involved/operations-team' }
        ]
    },
    { label: 'Donate', href: '/donate' },
    { label: 'Live Prayer', href: '/live-prayer' },
    { label: 'Shop', href: '/shop' },
    { label: 'Resources', href: '/resources' },
    { label: 'Contact', href: '/contact' }
];

export const footerNav = {
    organization: [
        { label: 'About Us', href: '/about' },
        { label: 'Mission', href: '/about/mission' },
        { label: 'How It Works', href: '/about/how-it-works' },
        { label: 'Leadership', href: '/about/leadership' }
    ],
    getInvolved: [
        { label: 'Apply Now', href: '/get-involved/apply' },
        { label: 'Prayer Team', href: '/get-involved/prayer-team' },
        { label: 'Operations Team', href: '/get-involved/operations-team' },
        { label: 'Online Decoy Team', href: '/get-involved/decoy-team' }
    ],
    support: [
        { label: 'Donate', href: '/donate' },
        { label: 'Start a Fundraiser', href: '/donate#fundraiser' },
        { label: 'Shop', href: '/shop' },
        { label: 'Live Prayer Calls', href: '/live-prayer' }
    ],
    legal: [
        { label: 'Privacy Policy', href: '/legal/privacy' },
        { label: 'Terms of Service', href: '/legal/terms' },
        { label: 'Code of Conduct', href: '/resources#conduct' }
    ]
};

export const socialLinks = [
    { label: 'Instagram', href: 'https://www.instagram.com/officialgarrettgross', icon: 'instagram' },
    { label: 'Facebook', href: 'https://www.facebook.com/op17two', icon: 'facebook' },
    { label: 'YouTube', href: 'https://www.youtube.com/@op17two', icon: 'youtube' }
];
