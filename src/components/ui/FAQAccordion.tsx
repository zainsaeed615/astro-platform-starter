import { useState } from 'react';
import { ChevronDown } from 'lucide-react';

export type FAQAccordionItem = {
  question: string;
  answer: string;
};

type Props = {
  items: FAQAccordionItem[];
};

export default function FAQAccordion({ items }: Props) {
  const [openIndex, setOpenIndex] = useState<number | null>(0);

  const toggle = (index: number) => {
    setOpenIndex((current) => (current === index ? null : index));
  };

  return (
    <div className="divide-y divide-pdq-border/80 border border-pdq-border/80 bg-white shadow-[0_20px_50px_-32px_rgba(15,36,64,0.4)]">
      {items.map((item, index) => {
        const isOpen = openIndex === index;
        const panelId = `faq-panel-${index}`;
        const buttonId = `faq-button-${index}`;

        return (
          <div key={item.question} className={isOpen ? 'bg-pdq-light/40' : ''}>
            <h3>
              <button
                id={buttonId}
                type="button"
                className="flex w-full items-center justify-between gap-4 px-5 py-5 text-left transition hover:bg-pdq-light/70 md:px-7"
                aria-expanded={isOpen}
                aria-controls={panelId}
                onClick={() => toggle(index)}
              >
                <span className="text-sm font-extrabold tracking-tight text-pdq-navy md:text-base normal-case">
                  {item.question}
                </span>
                <span
                  className={`flex h-8 w-8 shrink-0 items-center justify-center bg-pdq-navy text-white transition ${
                    isOpen ? 'bg-pdq-red' : ''
                  }`}
                >
                  <ChevronDown
                    className={`h-4 w-4 transition-transform duration-300 ${isOpen ? 'rotate-180' : ''}`}
                    aria-hidden
                  />
                </span>
              </button>
            </h3>
            <div
              id={panelId}
              role="region"
              aria-labelledby={buttonId}
              className={`grid transition-[grid-template-rows] duration-300 ease-out ${
                isOpen ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]'
              }`}
            >
              <div className="overflow-hidden">
                <p className="px-5 pb-6 text-sm leading-relaxed text-pdq-muted md:px-7 md:text-base font-medium">
                  {item.answer}
                </p>
              </div>
            </div>
          </div>
        );
      })}
    </div>
  );
}
