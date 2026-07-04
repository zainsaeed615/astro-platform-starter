import { useState } from 'react';
import { ChevronDown, Menu, X } from 'lucide-react';

interface NavLink {
  label: string;
  href: string;
}

interface NavDropdown {
  label: string;
  items: NavLink[];
}

interface Props {
  brand: string;
  brandHref: string;
  links: (NavLink | NavDropdown)[];
  theme: 'ipsh' | 'labyrinth';
  homeHref?: string;
}

function isDropdown(link: NavLink | NavDropdown): link is NavDropdown {
  return 'items' in link;
}

export default function AttractionNav({ brand, brandHref, links, theme, homeHref = '/' }: Props) {
  const [mobileOpen, setMobileOpen] = useState(false);
  const [openDropdown, setOpenDropdown] = useState<string | null>(null);

  const accent = theme === 'ipsh' ? 'text-[#c9a227]' : 'text-[#f3a641]';
  const hoverAccent = theme === 'ipsh' ? 'hover:text-[#c9a227]' : 'hover:text-[#f3a641]';
  const activeBg = theme === 'ipsh' ? 'bg-[#c9a227]/10' : 'bg-[#f3a641]/10';
  const borderColor = theme === 'ipsh' ? 'border-[#8b7355]/30' : 'border-white/10';
  const fontClass = theme === 'ipsh' ? 'font-[Cinzel]' : 'font-[Bebas_Neue] tracking-wider';

  return (
    <header className={`sticky top-0 z-50 backdrop-blur-xl border-b ${borderColor} ${theme === 'ipsh' ? 'bg-[#1a1510]/95' : 'bg-[#0a0a0a]/95'}`}>
      <nav className="max-w-7xl mx-auto px-6 py-4">
        <div className="flex items-center justify-between">
          <a href={brandHref} className={`text-lg md:text-xl font-bold no-underline text-white ${fontClass} ${hoverAccent} transition-colors`}>
            {brand}
          </a>

          <div className="hidden lg:flex items-center gap-1">
            {links.map((link) =>
              isDropdown(link) ? (
                <div key={link.label} className="relative group">
                  <button
                    className={`flex items-center gap-1 px-3 py-2 text-sm font-medium text-gray-300 no-underline ${hoverAccent} transition-colors rounded-lg`}
                  >
                    {link.label}
                    <ChevronDown className="w-4 h-4 opacity-60 group-hover:rotate-180 transition-transform duration-200" />
                  </button>
                  <div className={`absolute top-full left-0 pt-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200`}>
                    <div className={`min-w-[200px] rounded-xl border ${borderColor} ${theme === 'ipsh' ? 'bg-[#1a1510]' : 'bg-[#141414]'} shadow-2xl p-2`}>
                      {link.items.map((item) => (
                        <a
                          key={item.href}
                          href={item.href}
                          className={`block px-4 py-2.5 text-sm text-gray-300 no-underline rounded-lg ${hoverAccent} ${theme === 'ipsh' ? 'hover:bg-[#c9a227]/10' : 'hover:bg-[#f3a641]/10'} transition-colors`}
                        >
                          {item.label}
                        </a>
                      ))}
                    </div>
                  </div>
                </div>
              ) : (
                <a
                  key={link.href}
                  href={link.href}
                  className={`px-3 py-2 text-sm font-medium text-gray-300 no-underline ${hoverAccent} transition-colors rounded-lg`}
                >
                  {link.label}
                </a>
              )
            )}
            <a href={homeHref} className={`ml-4 px-4 py-2 text-xs uppercase tracking-wider ${accent} no-underline border ${borderColor} rounded-lg ${hoverAccent} transition-colors`}>
              ← Main Site
            </a>
          </div>

          <button
            className="lg:hidden p-2 text-white"
            onClick={() => setMobileOpen(!mobileOpen)}
            aria-label="Toggle menu"
          >
            {mobileOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
          </button>
        </div>

        {mobileOpen && (
          <div className={`lg:hidden mt-4 pb-4 border-t ${borderColor} pt-4 space-y-1`}>
            {links.map((link) =>
              isDropdown(link) ? (
                <div key={link.label}>
                  <button
                    onClick={() => setOpenDropdown(openDropdown === link.label ? null : link.label)}
                    className={`flex items-center justify-between w-full px-3 py-3 text-sm font-medium text-gray-300 ${hoverAccent}`}
                  >
                    {link.label}
                    <ChevronDown className={`w-4 h-4 transition-transform ${openDropdown === link.label ? 'rotate-180' : ''}`} />
                  </button>
                  {openDropdown === link.label && (
                    <div className="pl-4 space-y-1">
                      {link.items.map((item) => (
                        <a
                          key={item.href}
                          href={item.href}
                          className={`block px-3 py-2 text-sm text-gray-400 no-underline ${hoverAccent}`}
                          onClick={() => setMobileOpen(false)}
                        >
                          {item.label}
                        </a>
                      ))}
                    </div>
                  )}
                </div>
              ) : (
                <a
                  key={link.href}
                  href={link.href}
                  className={`block px-3 py-3 text-sm font-medium text-gray-300 no-underline ${hoverAccent}`}
                  onClick={() => setMobileOpen(false)}
                >
                  {link.label}
                </a>
              )
            )}
            <a href={homeHref} className={`block px-3 py-3 text-sm ${accent} no-underline`} onClick={() => setMobileOpen(false)}>
              ← Main Site
            </a>
          </div>
        )}
      </nav>
    </header>
  );
}
