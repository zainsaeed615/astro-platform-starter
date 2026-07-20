interface Props {
    goal: number;
    raised: number;
    donors?: number;
}

export default function DonationThermometer({ goal, raised, donors }: Props) {
    const percent = Math.min(100, Math.round((raised / goal) * 100));

    return (
        <div className="card-surface p-8">
            <div className="mb-2 flex items-end justify-between">
                <div>
                    <p className="tagline mb-1">Live Fundraising Goal</p>
                    <p className="font-display text-3xl font-bold text-brand-blue">${raised.toLocaleString()}</p>
                    <p className="text-sm text-white/50">raised of ${goal.toLocaleString()} goal</p>
                </div>
                <div className="text-right">
                    <p className="font-display text-4xl font-bold">{percent}%</p>
                    {donors && <p className="text-xs text-white/40">{donors} donors</p>}
                </div>
            </div>

            <div className="relative mt-6 h-4 overflow-hidden rounded-full bg-white/5">
                <div
                    className="absolute inset-y-0 left-0 rounded-full transition-all duration-1000"
                    style={{
                        width: `${percent}%`,
                        background: 'linear-gradient(90deg, #0066cc, #00a3ff)',
                        boxShadow: '0 0 20px rgba(0,163,255,0.5)'
                    }}
                />
            </div>

            <p className="mt-4 text-xs text-white/40">Givebutter live goal widget — updates in real time at launch.</p>
        </div>
    );
}
