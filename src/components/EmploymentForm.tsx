import { useState } from 'react';
import { Send } from 'lucide-react';
import { employmentFormFields } from '../data/shared';

interface Props {
  theme: 'ipsh' | 'labyrinth';
}

export default function EmploymentForm({ theme }: Props) {
  const [submitted, setSubmitted] = useState(false);

  const accent = theme === 'ipsh' ? 'text-[#c9a227]' : 'text-[#f3a641]';
  const inputClass =
    theme === 'ipsh'
      ? 'w-full px-4 py-3 rounded-lg bg-[#f4ead5]/5 border border-[#8b7355]/40 text-[#f4ead5] placeholder:text-[#f4ead5]/40 focus:outline-none focus:border-[#c9a227] transition-colors'
      : 'w-full px-4 py-3 rounded-lg bg-white/5 border border-white/10 text-white placeholder:text-white/40 focus:outline-none focus:border-[#f3a641] transition-colors';
  const labelClass = 'block text-sm font-medium text-gray-300 mb-2';
  const btnClass = theme === 'ipsh' ? 'btn-primary-ipsh' : 'btn-primary-labyrinth';

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    setSubmitted(true);
  };

  if (submitted) {
    return (
      <div className={`content-card text-center py-12 ${theme === 'ipsh' ? '' : ''}`}>
        <Send className={`w-12 h-12 mx-auto mb-4 ${accent}`} />
        <h3 className="text-xl font-bold text-white mb-2">Application Received!</h3>
        <p className="text-gray-400">Thank you for your interest. We will send a follow-up application shortly.</p>
      </div>
    );
  }

  return (
    <form onSubmit={handleSubmit} className="space-y-6">
      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label className={labelClass}>First Name</label>
          <input type="text" name="firstName" required className={inputClass} />
        </div>
        <div>
          <label className={labelClass}>Last Name</label>
          <input type="text" name="lastName" required className={inputClass} />
        </div>
        <div>
          <label className={labelClass}>Phone Number</label>
          <input type="tel" name="phone" required className={inputClass} />
        </div>
        <div>
          <label className={labelClass}>Email</label>
          <input type="email" name="email" required className={inputClass} />
        </div>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label className={labelClass}>Which concept are you applying for?</label>
          <select name="concept" required className={inputClass}>
            <option value="">Select...</option>
            {employmentFormFields.concepts.map((c) => (
              <option key={c} value={c}>{c}</option>
            ))}
          </select>
        </div>
        <div>
          <label className={labelClass}>What position are you interested in?</label>
          <select name="position" required className={inputClass}>
            <option value="">Select...</option>
            {employmentFormFields.positions.map((p) => (
              <option key={p} value={p}>{p}</option>
            ))}
          </select>
        </div>
      </div>

      <fieldset>
        <legend className={`${labelClass} mb-3`}>Have you ever worked at a haunted house or theme park?</legend>
        <div className="flex gap-4">
          <label className="flex items-center gap-2 text-gray-300 cursor-pointer">
            <input type="radio" name="hauntExperience" value="yes" className="accent-[#f3a641]" /> Yes
          </label>
          <label className="flex items-center gap-2 text-gray-300 cursor-pointer">
            <input type="radio" name="hauntExperience" value="no" defaultChecked className="accent-[#f3a641]" /> No
          </label>
        </div>
      </fieldset>

      <div>
        <label className={labelClass}>If yes, where & how many seasons?</label>
        <input type="text" name="hauntDetails" className={inputClass} />
      </div>

      <fieldset>
        <legend className={`${labelClass} mb-3`}>Are you available all weekends in October?</legend>
        <div className="flex gap-4">
          <label className="flex items-center gap-2 text-gray-300 cursor-pointer">
            <input type="radio" name="octoberWeekends" value="yes" required className="accent-[#f3a641]" /> Yes
          </label>
          <label className="flex items-center gap-2 text-gray-300 cursor-pointer">
            <input type="radio" name="octoberWeekends" value="no" className="accent-[#f3a641]" /> No
          </label>
        </div>
      </fieldset>

      <fieldset>
        <legend className={`${labelClass} mb-3`}>Are you available to work other special events throughout the year?</legend>
        <div className="flex gap-4">
          <label className="flex items-center gap-2 text-gray-300 cursor-pointer">
            <input type="radio" name="specialEvents" value="yes" required className="accent-[#f3a641]" /> Yes
          </label>
          <label className="flex items-center gap-2 text-gray-300 cursor-pointer">
            <input type="radio" name="specialEvents" value="no" className="accent-[#f3a641]" /> No
          </label>
        </div>
      </fieldset>

      <fieldset>
        <legend className={`${labelClass} mb-3`}>Are you over the age of 15?</legend>
        <div className="flex gap-4">
          <label className="flex items-center gap-2 text-gray-300 cursor-pointer">
            <input type="radio" name="over15" value="yes" required className="accent-[#f3a641]" /> Yes
          </label>
          <label className="flex items-center gap-2 text-gray-300 cursor-pointer">
            <input type="radio" name="over15" value="no" className="accent-[#f3a641]" /> No
          </label>
        </div>
      </fieldset>

      <div>
        <label className={labelClass}>
          Share a bit about yourself and let us know why you'd shine on our team. Let us know your special skills.
        </label>
        <textarea name="about" rows={5} required className={`${inputClass} resize-y`} />
      </div>

      <button type="submit" className={btnClass}>
        <Send className="w-4 h-4" /> Apply Now
      </button>
    </form>
  );
}
