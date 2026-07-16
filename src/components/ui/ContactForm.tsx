import { useState, type ChangeEvent, type FormEvent } from 'react';
import { CheckCircle2, Phone, Send } from 'lucide-react';

type ServiceOption = {
  slug: string;
  title: string;
};

type Props = {
  services: ServiceOption[];
};

type FormState = {
  name: string;
  email: string;
  phone: string;
  service: string;
  address: string;
  message: string;
};

const initialState: FormState = {
  name: '',
  email: '',
  phone: '',
  service: '',
  address: '',
  message: '',
};

export default function ContactForm({ services }: Props) {
  const [form, setForm] = useState<FormState>(initialState);
  const [submitted, setSubmitted] = useState(false);

  const onChange = (
    e: ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>,
  ) => {
    const { name, value } = e.target;
    setForm((prev) => ({ ...prev, [name]: value }));
  };

  const onSubmit = (e: FormEvent) => {
    e.preventDefault();
    setSubmitted(true);
  };

  if (submitted) {
    return (
      <div className="border border-pdq-border bg-white p-8 md:p-10 text-center">
        <div className="mx-auto mb-5 flex h-14 w-14 items-center justify-center bg-pdq-navy text-white">
          <CheckCircle2 className="h-7 w-7" aria-hidden />
        </div>
        <h3 className="font-display text-2xl text-pdq-navy">Thank You</h3>
        <p className="mt-3 text-slate-600 leading-relaxed max-w-md mx-auto">
          Your estimate request has been received. A member of the PDQ Construction team will follow
          up shortly.
        </p>
        <a
          href="tel:9168714325"
          className="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-pdq-red no-underline hover:underline"
        >
          <Phone className="h-4 w-4" aria-hidden />
          Or call 916-871-4325
        </a>
      </div>
    );
  }

  const fieldClass =
    'w-full border border-pdq-border bg-white px-4 py-3.5 text-sm text-slate-800 outline-none transition focus:border-pdq-navy';
  const labelClass = 'mb-2 block text-xs font-semibold uppercase tracking-wider text-pdq-navy';

  return (
    <form onSubmit={onSubmit} className="border border-pdq-border bg-white p-6 md:p-8 lg:p-10" noValidate>
      <div className="grid gap-5 md:grid-cols-2">
        <div>
          <label htmlFor="name" className={labelClass}>
            Name
          </label>
          <input
            id="name"
            name="name"
            type="text"
            required
            autoComplete="name"
            value={form.name}
            onChange={onChange}
            className={fieldClass}
            placeholder="Your full name"
          />
        </div>
        <div>
          <label htmlFor="email" className={labelClass}>
            Email
          </label>
          <input
            id="email"
            name="email"
            type="email"
            required
            autoComplete="email"
            value={form.email}
            onChange={onChange}
            className={fieldClass}
            placeholder="you@example.com"
          />
        </div>
        <div>
          <label htmlFor="phone" className={labelClass}>
            Phone
          </label>
          <input
            id="phone"
            name="phone"
            type="tel"
            required
            autoComplete="tel"
            value={form.phone}
            onChange={onChange}
            className={fieldClass}
            placeholder="916-555-0100"
          />
        </div>
        <div>
          <label htmlFor="service" className={labelClass}>
            Service
          </label>
          <select
            id="service"
            name="service"
            required
            value={form.service}
            onChange={onChange}
            className={fieldClass}
          >
            <option value="">Select a service</option>
            {services.map((service) => (
              <option key={service.slug} value={service.slug}>
                {service.title}
              </option>
            ))}
            <option value="other">Other / Not Sure</option>
          </select>
        </div>
        <div className="md:col-span-2">
          <label htmlFor="address" className={labelClass}>
            Project Address
          </label>
          <input
            id="address"
            name="address"
            type="text"
            autoComplete="street-address"
            value={form.address}
            onChange={onChange}
            className={fieldClass}
            placeholder="City or full address"
          />
        </div>
        <div className="md:col-span-2">
          <label htmlFor="message" className={labelClass}>
            Message
          </label>
          <textarea
            id="message"
            name="message"
            required
            rows={5}
            value={form.message}
            onChange={onChange}
            className={`${fieldClass} resize-y min-h-[140px]`}
            placeholder="Tell us about the project — scope, timeline, and any photos you can share later."
          />
        </div>
      </div>

      <button type="submit" className="btn-primary mt-8 w-full md:w-auto">
        <Send className="h-4 w-4" aria-hidden />
        Submit Request
      </button>
    </form>
  );
}
