import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
  presets: [
    require("./vendor/wireui/wireui/tailwind.config.js"),
    require("./vendor/power-components/livewire-powergrid/tailwind.config.js")
  ],
  content: [
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    './vendor/laravel/jetstream/**/*.blade.php',
    './storage/framework/views/*.php',
    './resources/views/**/*.blade.php',
    './vendor/wireui/wireui/src/*.php',
    './vendor/wireui/wireui/ts/**/*.ts',
    './vendor/wireui/wireui/src/WireUi/**/*.php',
    './vendor/wireui/wireui/src/Components/**/*.php',
    './app/Livewire/**/*Table.php',
    './vendor/power-components/livewire-powergrid/resources/views/**/*.php',
    './vendor/power-components/livewire-powergrid/src/Themes/Tailwind.php'
  ],

  theme: {
    extend: {
      fontFamily: {
        sans: ['Figtree', ...defaultTheme.fontFamily.sans],
      },
    },
  },

  plugins: [forms, typography],
};
