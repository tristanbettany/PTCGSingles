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

module.exports = {
    purge: false,
    darkMode: false, // or 'media' or 'class'
    theme: {
        extend: {
            appearance: ['hover', 'focus'],
        },
        colors: {
            transparent: 'transparent',
            current: 'currentColor',
            black: '#22292f',
            white: colors.white,
            gray: colors.blueGray,
            grey: colors.blueGray,
            primary: colors.blue,
            secondary: colors.green,
            tertiary: colors.blueGray,
            pri: colors.teal,
            sec: colors.emerald,
            ter: colors.blueGray,
            p: colors.teal,
            s: colors.emerald,
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
