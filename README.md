# informatic-solutions
SEO Page + Price comparator + Produts monitoring through Amzn API & CRON Job

https://www.informatic-solutions.it/videocitofoni/comparatore-prezzi 

<a href="https://www.informatic-solutions.it/videocitofoni" rel="follow">Videocitofoni</a>

### TODO:

- [x] dev env: dockerization to 4 containers: web, app, db, cronjob (process in separate container)
- [x] antispam filter for user register form
- [x] antispam filter for cms comments forms
- [x] facory/seeds for stores table
- [x] update amzn API v5
- [x] logs in admin backend
- [x] override logs package blade template
- [x] datatable to all tables (with js pagination & controls)
- [x] user profile modifiers
- [ ] bug: comparator --> 'elimina dalla lista' button (Undefined variable: watched_item)
- [ ] comparator: add canonical meta tag (for seo/pagination);
- [ ] comparator: rewrite filters Api
- [ ] admin: users page --> "oggetti in osservazione"
- [ ] admin: user edit --> "prodotti monitorati"
- [ ] cms: add links to comparator
- [ ] to complete unit tests
- [ ] amzn reviews crawler
- [ ] cms: bind articles to db
- [ ] cms: improve article editor
- [ ] frontend: convert to sass/npm with webpack (mostly for cms side)
- [ ] seo: optimization performance for articles pages







### Long-term deadline

- [ ] continuos refactoring
- [ ] add more stores
- [ ] separate distinctly front/backend (Laravel --> API - Vue.js/nuxt.js --> front page)
