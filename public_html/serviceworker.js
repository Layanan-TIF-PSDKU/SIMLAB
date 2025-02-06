// /* Start the service worker and cache all of the app's content */
// self.addEventListener('install', function (e) {
//     e.waitUntil(
//         caches.open(cacheName).then(function (cache) {
//             return cache.addAll(filesToCache);
//         })
//     );
// });

// /* Serve cached content when offline */
// self.addEventListener('fetch', function (e) {
//     e.respondWith(
//         caches.match(e.request).then(function (response) {
//             return response || fetch(e.request);
//         })
//     );
// });

// self.addEventListener('install', function(event) {
//     event.waitUntil(
//       caches.open(CACHE_NAME)
//         .then(function(cache) {
//           return cache.addAll(urlsToCache);
//         })
//     );
//   });
  
//   self.addEventListener('fetch', function(event) {
//     event.respondWith(
//       caches.match(event.request)
//         .then(function(response) {
//           if (response) {
//             return response;
//           }
//           return fetch(event.request);
//         })
//     );
//   });
const CACHE_NAME = 'SW-001';
const toCache = [
    '/',
    'manifest.json',
    'register.js',
    'uploads/logo.png',
];

self.addEventListener('install', function(event) {
    event.waitUntil(
        caches.open(CACHE_NAME)
        .then(function(cache) {
            return cache.addAll(toCache)
        })
        .then(self.skipWaiting())
    )
})

self.addEventListener('fetch', function(event) {
    event.respondWith(
        fetch(event.request)
        .catch(() => {
            return caches.open(CACHE_NAME)
            .then((cache) => {
                return cache.match(event.request)
            })
        })
    )
})

self.addEventListener('activate', function(event) {
    event.waitUntil(
        caches.keys()
        .then((keyList) => {
            return Promise.all(keyList.map((key) => {
            if (key !== CACHE_NAME) {
                console.log('[ServiceWorker] Hapus cache lama', key)
                return caches.delete(key)
            }
            }))
        })
        .then(() => self.clients.claim())
    )
})