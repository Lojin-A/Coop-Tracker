// Minimal service worker: caches the app shell (HTML/CSS/JS) so the page
// still loads when offline. It does NOT cache API responses — attendance
// data always comes fresh from the network, since offline check-in/out
// would need a sync queue, which isn't something the course has covered.
const CACHE_NAME = "attendance-shell-v1";
const SHELL_FILES = [
  "./index.html",
  "./css/style.css",
  "./js/app.js",
  "./manifest.json",
  "./icons/icon-192.png",
  "./icons/icon-512.png",
];

self.addEventListener("install", (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => cache.addAll(SHELL_FILES))
  );
});

self.addEventListener("activate", (event) => {
  event.waitUntil(
    caches.keys().then((keys) =>
      Promise.all(
        keys.filter((key) => key !== CACHE_NAME).map((key) => caches.delete(key))
      )
    )
  );
});

self.addEventListener("fetch", (event) => {
  const url = new URL(event.request.url);

  // Never intercept API calls — only the static shell files above.
  if (url.pathname.startsWith("/api")) {
    return;
  }

  // A navigation (typing the URL, reloading) requests "/", not "/index.html",
  // so match it to the cached shell page explicitly instead of by exact URL.
  if (event.request.mode === "navigate") {
    event.respondWith(
      caches.match("./index.html").then((cached) => cached || fetch(event.request))
    );
    return;
  }

  event.respondWith(
    caches.match(event.request).then((cached) => cached || fetch(event.request))
  );
});
