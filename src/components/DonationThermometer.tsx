interface Props {
    goal: number;
    raised: number;
    donors?: number;
}

export default function DonationThermometer({ goal, raised, donors }: Props) {
    const percent = Math.min(100, Math.round((raised / goal) * 100));

    return (
        <div className="card-premium p-10">
            <div className="mb-6 flex items-end justify-between">
                <div>
                    <p className="font-display text-sm uppercase tracking-[0.3em] text-brand-blue">Live Goal</p>
                    <p className="mt-2 font-display text-5xl tracking-wide text-brand-blue">${raised.toLocaleString()}</p>
                    <p className="mt-1 text-sm text-white/45">raised of ${goal.toLocaleString()}</p>
                </div>
                <div className="text-right">
                    <p className="font-display text-6xl tracking-wide">{percent}%</p>
                    {donors && <p className="text-xs uppercase tracking-widest text-white/35">{donors} donors</p>}
                </div>
            </div>

            <div className="relative h-2 overflow-hidden rounded-sm bg-white/[0.06]">
                <div
                    className="absolute inset-y-0 left-0 rounded-sm transition-all duration-1000"
                    style={{
                        width: `${percent}%`,
                        background: 'linear-gradient(90deg, #0077cc, #00c8ff)',
                        boxShadow: '0 0 24px rgba(0,200,255,0.6)'
                    }}
                />
            </div>
        </div>
    );
}
