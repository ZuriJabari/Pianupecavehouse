/** @type {import('tailwindcss').Config} */
export default {
  theme: {
    container: {
      center: true,
      padding: { DEFAULT: '1rem', lg: '2.5rem' },
      screens: { lg: '1120px', xl: '1200px' },
    },
    extend: {
      colors: {
        ink: '#15120F',
        'ink-soft': '#2A2420',
        sand: {
          0: '#F9F3EA',
          1: '#F2E6D7',
          2: '#E3D3C0',
        },
        stone: '#8B7664',
        gold: '#C89A4B',
        emerald: '#1FB58F',
        rust: '#C65B3A',
        primary: '#201A16',
        'primary-soft': '#33261D',
        'muted-chip': '#2C2620',
      },
      fontFamily: {
        display: ['"Cormorant Garamond"', 'serif'],
        sans: ['"Instrument Sans"', 'system-ui', 'sans-serif'],
      },
      fontSize: {
        'display-xl': ['3.75rem', { lineHeight: '1.05', letterSpacing: '-0.03em' }],
        'display-lg': ['3rem', { lineHeight: '1.1', letterSpacing: '-0.03em' }],
        'heading-xl': ['2.25rem', { lineHeight: '1.2' }],
        'heading-lg': ['1.875rem', { lineHeight: '1.25' }],
        'heading-md': ['1.5rem', { lineHeight: '1.3' }],
        'heading-sm': ['1.25rem', { lineHeight: '1.35' }],

        body: ['1rem', { lineHeight: '1.7' }],
        'body-lg': ['1.125rem', { lineHeight: '1.7' }],
        'body-sm': ['0.875rem', { lineHeight: '1.65' }],
        'label-xs': ['0.75rem', { lineHeight: '1.5' }],
      },
      borderRadius: {
        xs: '0.25rem',
        md: '0.75rem',
        lg: '1.25rem',
        full: '9999px',
      },
      boxShadow: {
        soft: '0 10px 30px rgba(0,0,0,0.10)',
        elevated: '0 18px 45px rgba(0,0,0,0.18)',
      },
      transitionTimingFunction: {
        'soft-out': 'cubic-bezier(0.22, 1, 0.36, 1)',
        'soft-in-out': 'cubic-bezier(0.65, 0, 0.35, 1)',
      },
      transitionDuration: {
        fast: '160ms',
        med: '280ms',
        slow: '420ms',
      },
    },
  },
  corePlugins: {
    container: true,
  },
};
