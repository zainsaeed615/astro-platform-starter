export const SPEC_SHEET_URL =
    'https://vestanutra.com/wp-content/uploads/2025/04/HMB-Ca-Vesta-Brochure.pdf';

export const applicationLinks = [
    {
        label: 'Muscle Growth & Recovery',
        href: '/applications/muscle-growth-recovery',
        description:
            'Supports protein synthesis, lean body mass, and post-exercise recovery — the core of sports-nutrition and performance formulations.'
    },
    {
        label: 'Healthy Aging',
        href: '/applications/healthy-aging',
        description:
            'Helps preserve muscle integrity and physical function in aging adults for active-lifestyle and mobility products.'
    },
    {
        label: 'Cognitive Wellness',
        href: '/applications/cognitive-wellness',
        description:
            'Emerging research points to neuronal support, memory, and learning, offering a differentiated angle for cognitive and brain-health formulations.'
    }
] as const;

export const navItems = [
    { label: 'Home', href: '/' },
    { label: 'About / The Science of HMB-Ca', href: '/about' },
    {
        label: 'Applications',
        href: '/applications/muscle-growth-recovery',
        children: applicationLinks.map(({ label, href }) => ({ label, href }))
    },
    { label: 'FAQ', href: '/faq' },
    { label: 'Contact', href: '/contact' }
] as const;

export const portfolioBrands = [
    {
        name: 'DERMALuminese',
        href: 'https://www.dermaluminese.com',
        logo: '/images/portfolio/dermaluminese.png'
    },
    {
        name: 'LipoQuest',
        href: 'https://www.lipoquest.com',
        logo: '/images/portfolio/lipoquest.png'
    },
    {
        name: 'Natto NSP2',
        href: 'https://www.nattonsp2.com',
        logo: '/images/portfolio/natto-nsp2.png'
    },
    {
        name: 'Natto MK-7',
        href: 'https://www.nattomk7.com',
        logo: '/images/portfolio/natto-mk7.png'
    },
    {
        name: 'UltraHMB',
        href: 'https://www.ultrahmb.com',
        logo: '/images/portfolio/ultrahmb.webp'
    },
    {
        name: 'UD2 Collagen',
        href: 'https://www.ud2collagen.com',
        logo: '/images/portfolio/ud2-collagen.png'
    },
    {
        name: 'UltraFucoidan',
        href: 'https://www.ultrafucoidan.com',
        logo: '/images/portfolio/ultrafucoidan.png'
    },
    {
        name: 'UltraPQQ',
        href: 'https://www.ultrapqq.com',
        logo: '/images/portfolio/ultrapqq.png'
    },
    {
        name: 'ImmuneNK',
        href: 'https://www.immunenk.com',
        logo: '/images/portfolio/immunenk.png'
    }
] as const;

export const certs = [
    { name: 'Allergen Free', src: '/images/certs/Cert - Allergen Free.png' },
    { name: 'FDA', src: '/images/certs/Cert - FDA.png' },
    { name: 'Halal', src: '/images/certs/Cert - Halal.png' },
    { name: 'Kosher', src: '/images/certs/Cert - Kosher.png' },
    { name: 'Made in USA', src: '/images/certs/Cert - Made in USA.png' },
    { name: 'Non-GMO', src: '/images/certs/Cert - NonGMO.png' },
    { name: 'NSF cGMP', src: '/images/certs/Cert - NSF cGMP.png' }
] as const;

export const contactInfo = {
    address: '5767 Thunderbird Road, Indianapolis, IN 46236, USA',
    email: 'marketing@vestanutra.com',
    phone: '317-932-5001',
    fax: '317-895-9340',
    hours: 'Mon–Fri 8:00 AM – 5:00 PM',
    phoneAlt: '888-558-3782'
} as const;

export const socialLinks = [
    { name: 'LinkedIn', href: 'https://www.linkedin.com/company/vesta-nutra/', icon: 'linkedin' },
    { name: 'Facebook', href: 'https://www.facebook.com/', icon: 'facebook' },
    { name: 'Instagram', href: 'https://www.instagram.com/', icon: 'instagram' },
    { name: 'YouTube', href: 'https://www.youtube.com/', icon: 'youtube' },
    { name: 'X', href: 'https://x.com/', icon: 'x' }
] as const;

export const fdaDisclaimer =
    '*These statements have not been evaluated by the Food and Drug Administration. This product is not intended to diagnose, treat, cure or prevent any disease.*';

export const developmentalDisclaimer =
    'This information is provided for developmental purposes only. It is not a specification, a guarantee of composition, or a certificate of analysis. The information contained herein is correct to the best of our knowledge. Recommendations and suggestions are made without guarantee or representation as to results; evaluate prior to use.';
