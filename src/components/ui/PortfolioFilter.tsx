import { useMemo, useState } from 'react';
import { MapPin } from 'lucide-react';

export type PortfolioProject = {
  id: string;
  title: string;
  category: string;
  categoryLabel: string;
  location: string;
  description: string;
  image: string;
  featured?: boolean;
};

export type PortfolioFilterOption = {
  id: string;
  label: string;
};

type Props = {
  projects: PortfolioProject[];
  filters: readonly PortfolioFilterOption[] | PortfolioFilterOption[];
};

export default function PortfolioFilter({ projects, filters }: Props) {
  const [active, setActive] = useState('all');

  const filtered = useMemo(() => {
    if (active === 'all') return projects;
    return projects.filter((project) => project.category === active);
  }, [active, projects]);

  return (
    <div>
      <div
        className="flex flex-wrap gap-2 border-b border-pdq-border pb-6"
        role="tablist"
        aria-label="Filter projects by category"
      >
        {filters.map((filter) => {
          const isActive = active === filter.id;
          return (
            <button
              key={filter.id}
              type="button"
              role="tab"
              aria-selected={isActive}
              onClick={() => setActive(filter.id)}
              className={`px-4 py-2.5 text-xs font-semibold uppercase tracking-wider transition ${
                isActive
                  ? 'bg-pdq-navy text-white'
                  : 'border border-pdq-border bg-white text-pdq-navy hover:border-pdq-navy'
              }`}
            >
              {filter.label}
            </button>
          );
        })}
      </div>

      <p className="mt-6 text-sm text-pdq-muted">
        Showing <span className="font-semibold text-pdq-navy">{filtered.length}</span>{' '}
        {filtered.length === 1 ? 'project' : 'projects'}
      </p>

      <div className="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        {filtered.map((project) => (
          <article
            key={project.id}
            className="group overflow-hidden border border-pdq-border/80 bg-white transition hover:shadow-xl hover:shadow-pdq-navy/5"
          >
            <div className="relative aspect-[4/3] overflow-hidden">
              <img
                src={project.image}
                alt={project.title}
                className="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                width={800}
                height={600}
                loading="lazy"
                decoding="async"
              />
              <div className="absolute inset-0 bg-gradient-to-t from-pdq-navy-dark/70 via-transparent to-transparent opacity-80" />
              <span className="absolute bottom-4 left-4 text-xs font-semibold uppercase tracking-wider text-white">
                {project.categoryLabel}
              </span>
            </div>
            <div className="p-6">
              <h3 className="font-display text-xl text-pdq-navy leading-snug">{project.title}</h3>
              <p className="mt-2 flex items-center gap-1.5 text-sm text-pdq-muted">
                <MapPin className="h-3.5 w-3.5 shrink-0" aria-hidden />
                {project.location}
              </p>
              <p className="mt-3 text-sm leading-relaxed text-slate-600 line-clamp-3">
                {project.description}
              </p>
            </div>
          </article>
        ))}
      </div>

      {filtered.length === 0 && (
        <p className="mt-12 text-center text-slate-600">
          No projects in this category yet. Try another filter or{' '}
          <a href="/contact" className="font-semibold text-pdq-red no-underline hover:underline">
            request an estimate
          </a>
          .
        </p>
      )}
    </div>
  );
}
