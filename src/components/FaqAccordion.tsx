import { useState } from 'react';
import { ChevronDown } from 'lucide-react';

interface FaqItem {
  question: string;
  answer: string;
}

interface Props {
  items: FaqItem[];
  theme: 'ipsh' | 'labyrinth';
}

export default function FaqAccordion({ items, theme }: Props) {
  const [openIndex, setOpenIndex] = useState<number | null>(0);

  const accent = theme === 'ipsh' ? 'text-[#c9a227]' : 'text-[#f3a641]';
  const borderColor = theme === 'ipsh' ? 'border-[#8b7355]/30' : 'border-white/10';
  const activeBg = theme === 'ipsh' ? 'bg-[#f4ead5]/5' : 'bg-white/5';

  return (
    <div className="space-y-3">
      {items.map((item, index) => (
        <div
          key={index}
          className={`rounded-xl border ${borderColor} overflow-hidden transition-all duration-300 ${openIndex === index ? activeBg : ''}`}
        >
          <button
            onClick={() => setOpenIndex(openIndex === index ? null : index)}
            className="flex items-center justify-between w-full px-6 py-5 text-left"
          >
            <span className="font-semibold text-white pr-4">{item.question}</span>
            <ChevronDown
              className={`w-5 h-5 shrink-0 ${accent} transition-transform duration-300 ${openIndex === index ? 'rotate-180' : ''}`}
            />
          </button>
          <div
            className={`overflow-hidden transition-all duration-300 ${openIndex === index ? 'max-h-[800px] opacity-100' : 'max-h-0 opacity-0'}`}
          >
            <div className="px-6 pb-5 text-gray-400 leading-relaxed whitespace-pre-line text-sm md:text-base">
              {item.answer}
            </div>
          </div>
        </div>
      ))}
    </div>
  );
}
