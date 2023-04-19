<li class="nav-item dropdown">
    <button class="btn btn-primary dropdown-toggle" id="theme-dropdown" data-bs-toggle="dropdown"></button>
    <ul class="dropdown-menu dropdown-menu dropdown-menu-end text-small shadow theme-icon-active" style="min-width: 1rem;" aria-labelledby="theme-dropdown">
        <li><button class="dropdown-item" data-bs-theme-value="light"><i class="fas fa-sun"></i> Light</button></li>
        <li><button class="dropdown-item" data-bs-theme-value="dark"><i class="fas fa-moon"></i> Dark</button></li>
        <li><button class="dropdown-item" data-bs-theme-value="auto"><i class="fas fa-adjust"></i> Auto</button></li>
    </ul>
</li>

<script type="text/javascript">
    /*!
     * Color mode toggler for Bootstrap's docs (https://getbootstrap.com/)
     * Copyright 2011-2022 The Bootstrap Authors
     * Licensed under the Creative Commons Attribution 3.0 Unported License.
     */

    // function setTheme(theme) {
    //     document.documentElement.setAttribute('data-bs-theme', theme);
    // }


    (() => {
  'use strict'

  const storedTheme = localStorage.getItem('theme')

  const getPreferredTheme = () => {
    if (storedTheme) {
      return storedTheme
    }

    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
  }

  const setTheme = function (theme) {
    if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
      document.documentElement.setAttribute('data-bs-theme', 'dark')
    } else {
      document.documentElement.setAttribute('data-bs-theme', theme)
    }
  }

  setTheme(getPreferredTheme())

  const showActiveTheme = theme => {
    const activeThemeIcon = document.querySelector('.theme-icon-active use')
    const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`)
    // const svgOfActiveBtn = btnToActive.querySelector('svg use').getAttribute('href')

    document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
      element.classList.remove('active')
      // console.log(element);
    })

    btnToActive.classList.add('active')
    // activeThemeIcon.setAttribute('href', svgOfActiveBtn)

    if (btnToActive.innerText.includes('Light')) {
        document.getElementById('theme-dropdown').innerHTML = '<i class="text-light fas fa-sun"></i>';
    }

    if (btnToActive.innerText.includes('Dark')) {
        document.getElementById('theme-dropdown').innerHTML = '<i class="text-light fas fa-moon"></i>';
    }

    if (btnToActive.innerText.includes('Auto')) {
        document.getElementById('theme-dropdown').innerHTML = '<i class="text-light fas fa-adjust"></i>';
    }
  }

  window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
    if (storedTheme !== 'light' || storedTheme !== 'dark') {
      setTheme(getPreferredTheme())
    }
  })

  window.addEventListener('DOMContentLoaded', () => {
    showActiveTheme(getPreferredTheme())

    document.querySelectorAll('[data-bs-theme-value]')
      .forEach(toggle => {
        toggle.addEventListener('click', () => {
          const theme = toggle.getAttribute('data-bs-theme-value')
          localStorage.setItem('theme', theme)
          setTheme(theme)
          showActiveTheme(theme)
        })
      })
  })
})()
</script>