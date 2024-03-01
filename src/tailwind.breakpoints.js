import resolveConfig from 'tailwindcss/resolveConfig'
import tailwindConfig from '/tailwind.config.js'

const fullConfig = resolveConfig(tailwindConfig)

/**
 * src : https://ohdoylerules.com/snippets/tailwind-screens-in-js/
 * Find out if a tailwind screen value matches the current window
 *
 * @param {string} screen
 *
 * @return {Object|Boolean}
 */
export default (screen = "") => {
    // "Theme" is an alias to where you keep your tailwind.config.js - most likely your project root
    const screens = fullConfig.theme.screens;

    // create a keyed object of screens that match
    const matches = Object.entries(screens).reduce((results, [name, size]) => {
        const mediaQuery =
            typeof size === "string"
                ? `(min-width: ${size})`
                : `(max-width: ${size.max})`;

        results[name] = window.matchMedia(mediaQuery);

        return results;
    }, {});

    // show all matches when there is no screen choice
    if (screen === "") {
        return matches;
    }

    // invalid screen choice
    if (!screens[screen]) {
        console.error(`No match for "${screen}"`);

        return false;
    }

    return matches[screen];
};
