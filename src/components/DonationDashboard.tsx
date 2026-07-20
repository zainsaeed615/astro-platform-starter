interface Props {
    goal: number;
    raised: number;
    donors?: number;
}

const impactItems = [
    { label: 'Decoy Training', amount: 12000, color: '#00c8ff' },
    { label: 'Field Equipment', amount: 8500, color: '#0077cc' },
    { label: 'Team Expansion', amount: 6950, color: '#0055aa' },
    { label: 'Legal & Compliance', amount: 5000, color: '#003388' }
];

export default function DonationDashboard({ goal, raised, donors = 847 }: Props) {
    const percent = Math.min(100, Math.round((raised / goal) * 100));
    const remaining = goal - raised;

    return (
        <div className="relative">
            <div className="absolute -inset-1 rounded-sm bg-gradient-to-br from-brand-blue/30 via-transparent to-brand-blue/10 blur-2xl" />

            <div className="relative overflow-hidden rounded-sm border border-white/10 bg-black/60 backdrop-blur-2xl">
                <div className="border-b border-white/[0.06] bg-brand-blue/[0.04] px-8 py-5">
                    <div className="flex items-center justify-between">
                        <div className="flex items-center gap-3">
                            <span className="relative flex h-2.5 w-2.5">
                                <span className="absolute inline-flex h-full w-full animate-ping rounded-full bg-brand-blue opacity-60" />
                                <span className="relative inline-flex h-2.5 w-2.5 rounded-full bg-brand-blue" />
                            </span>
                            <span className="font-display text-sm uppercase tracking-[0.25em] text-brand-blue">Live Campaign</span>
                        </div>
                        <span className="text-xs uppercase tracking-widest text-white/35">{donors} supporters</span>
                    </div>
                </div>

                <div className="p-8 md:p-10">
                    <div className="flex flex-col gap-8 lg:flex-row lg:items-center">
                        <div className="relative mx-auto flex h-44 w-44 shrink-0 items-center justify-center lg:mx-0">
                            <svg className="absolute inset-0 -rotate-90" viewBox="0 0 100 100">
                                <circle cx="50" cy="50" r="42" fill="none" stroke="rgba(255,255,255,0.06)" strokeWidth="6" />
                                <circle
                                    cx="50"
                                    cy="50"
                                    r="42"
                                    fill="none"
                                    stroke="url(#donateGrad)"
                                    strokeWidth="6"
                                    strokeLinecap="round"
                                    strokeDasharray={`${percent * 2.64} 264`}
                                    style={{ filter: 'drop-shadow(0 0 12px rgba(0,200,255,0.5))' }}
                                />
                                <defs>
                                    <linearGradient id="donateGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                        <stop offset="0%" stopColor="#0077cc" />
                                        <stop offset="100%" stopColor="#00c8ff" />
                                    </linearGradient>
                                </defs>
                            </svg>
                            <div className="text-center">
                                <p className="font-display text-4xl tracking-wide text-white">{percent}%</p>
                                <p className="text-[10px] uppercase tracking-widest text-white/40">Funded</p>
                            </div>
                        </div>

                        <div className="flex-1 text-center lg:text-left">
                            <p className="font-display text-5xl tracking-wide text-brand-blue md:text-6xl">${raised.toLocaleString()}</p>
                            <p className="mt-2 text-white/50">
                                raised toward <span className="text-white/80">${goal.toLocaleString()}</span> goal
                            </p>
                            <p className="mt-1 text-sm text-white/35">${remaining.toLocaleString()} remaining to hit target</p>
                        </div>
                    </div>

                    <div className="mt-10 grid gap-3 sm:grid-cols-2">
                        {impactItems.map((item) => (
                            <div key={item.label} className="rounded-sm border border-white/[0.06] bg-white/[0.02] p-4">
                                <div className="flex items-center justify-between">
                                    <span className="text-sm text-white/60">{item.label}</span>
                                    <span className="font-display text-lg text-brand-blue">${item.amount.toLocaleString()}</span>
                                </div>
                                <div className="mt-3 h-1 overflow-hidden rounded-full bg-white/[0.06]">
                                    <div
                                        className="h-full rounded-full"
                                        style={{
                                            width: `${(item.amount / raised) * 100}%`,
                                            background: `linear-gradient(90deg, ${item.color}, #00c8ff)`
                                        }}
                                    />
                                </div>
                            </div>
                        ))}
                    </div>

                    <div className="mt-8 border-t border-white/[0.06] pt-6">
                        <p className="mb-4 text-xs uppercase tracking-widest text-white/35">Recent Supporters</p>
                        <div className="flex flex-wrap gap-2">
                            {['Michael R.', 'Sarah K.', 'Team Illinois', 'Anonymous', 'David M.'].map((name) => (
                                <span key={name} className="rounded-sm border border-white/[0.08] bg-white/[0.03] px-3 py-1.5 text-xs text-white/50">
                                    {name} donated
                                </span>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
