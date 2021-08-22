const colors = require('tailwindcss/colors')

let SpacingObject = {};
let Spacing = 5;
for (i = 0; i < 100; i++) {
    SpacingObject[(Spacing * i) + 'px'] = (Spacing * i) + 'px';
    SpacingObject[(Spacing * i) + '%'] = (Spacing * i) + '%';
}

let FontSizeObject = {};
let Size = 2;
for (i = 0; i < 200; i++) {
    FontSizeObject[(Size * i) + 'px'] = (Size * i) + 'px';
}

let FilterSizeObject = {};
let Filter = 1;
for (i = 0; i < 200; i++) {
    FilterSizeObject[(Filter * i) + 'px'] = (Filter * i) + 'px';
}

pokemonColorObject = {
    50: "#327dc1",
    100: "#2873b7",
    200: "#1e69ad",
    300: "#145fa3",
    400: "#0a5599",
    DEFAULT: "#004b8f",
    500: "#004b8f",
    600: "#004185",
    700: "#00377b",
    800: "#002d71",
    900: "#002367"
};

module.exports = {
    purge: false,
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            appearance: ['hover', 'focus'],
        },
        colors: {
            pokemon: pokemonColorObject,
            transparent: 'transparent',
            current: 'currentColor',
            black: '#22292f',
            white: colors.white,
            gray: colors.blueGray,
            grey: colors.blueGray,
            primary: pokemonColorObject,
            secondary: colors.red,
            tertiary: colors.blueGray,
            pri: pokemonColorObject,
            sec: colors.red,
            ter: colors.blueGray,
            p: pokemonColorObject,
            s: colors.red,
            t: colors.blueGray,
            success: colors.green,
            error: colors.red,
            warning: colors.yellow,
        },
        spacing: SpacingObject,
        fontSize: FontSizeObject,
        blur: FilterSizeObject,
    },
    variants: {
        extend: {
            display: ["group-hover"],
        },
    },
    plugins: [],
}
