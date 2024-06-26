<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Dating site | Admin panel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.9/jquery.inputmask.min.js"></script>
        <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">

        <!-- Styles -->
        @vite('resources/css/app.css')
        @vite('resources/css/tailwind.output.css')

        @vite('resources/js/app.js')
    </head>
    <body>

        @yield('content')

        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>

        <script>
            function data() {
                function getThemeFromLocalStorage() {
                    // if user already changed the theme, use it
                    if (window.localStorage.getItem('dark')) {
                    return JSON.parse(window.localStorage.getItem('dark'))
                    }

                    // else return their preferences
                    return (
                    !!window.matchMedia &&
                    window.matchMedia('(prefers-color-scheme: dark)').matches
                    )
                }

                function setThemeToLocalStorage(value) {
                    window.localStorage.setItem('dark', value)
                }

                return {
                    dark: getThemeFromLocalStorage(),
                    toggleTheme() {
                    this.dark = !this.dark
                    setThemeToLocalStorage(this.dark)
                    },
                    isSideMenuOpen: false,
                    toggleSideMenu() {
                    this.isSideMenuOpen = !this.isSideMenuOpen
                    },
                    closeSideMenu() {
                    this.isSideMenuOpen = false
                    },
                    isNotificationsMenuOpen: false,
                    toggleNotificationsMenu() {
                    this.isNotificationsMenuOpen = !this.isNotificationsMenuOpen
                    },
                    closeNotificationsMenu() {
                    this.isNotificationsMenuOpen = false
                    },
                    isProfileMenuOpen: false,
                    toggleProfileMenu() {
                    this.isProfileMenuOpen = !this.isProfileMenuOpen
                    },
                    closeProfileMenu() {
                    this.isProfileMenuOpen = false
                    },
                    isPagesMenuOpen: false,
                    togglePagesMenu() {
                    this.isPagesMenuOpen = !this.isPagesMenuOpen
                    },
                    // Modal
                    isModalOpen: false,
                    trapCleanup: null,
                    openModal() {
                    this.isModalOpen = true
                    this.trapCleanup = focusTrap(document.querySelector('#modal'))
                    },
                    closeModal() {
                    this.isModalOpen = false
                    this.trapCleanup()
                    },
                }
            }

            /**
             * Limit focus to focusable elements inside `element`
             * @param {HTMLElement} element - DOM element to focus trap inside
             * @return {Function} cleanup function
             */
            function focusTrap(element) {
                const focusableElements = getFocusableElements(element)
                const firstFocusableEl = focusableElements[0]
                const lastFocusableEl = focusableElements[focusableElements.length - 1]

                // Wait for the case the element was not yet rendered
                setTimeout(() => firstFocusableEl.focus(), 50)

                /**
                 * Get all focusable elements inside `element`
                 * @param {HTMLElement} element - DOM element to focus trap inside
                 * @return {HTMLElement[]} List of focusable elements
                 */
                function getFocusableElements(element = document) {
                    return [
                    ...element.querySelectorAll(
                        'a, button, details, input, select, textarea, [tabindex]:not([tabindex="-1"])'
                    ),
                    ].filter((e) => !e.hasAttribute('disabled'))
                }

                function handleKeyDown(e) {
                    const TAB = 9
                    const isTab = e.key.toLowerCase() === 'tab' || e.keyCode === TAB

                    if (!isTab) return

                    if (e.shiftKey) {
                    if (document.activeElement === firstFocusableEl) {
                        lastFocusableEl.focus()
                        e.preventDefault()
                    }
                    } else {
                    if (document.activeElement === lastFocusableEl) {
                        firstFocusableEl.focus()
                        e.preventDefault()
                    }
                    }
                }

                element.addEventListener('keydown', handleKeyDown)

                return function cleanup() {
                    element.removeEventListener('keydown', handleKeyDown)
                }
            }

        </script>
    </body>
</html>