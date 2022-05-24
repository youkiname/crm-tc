importScripts('workbox-v4.3.0/workbox-sw.js')

// SETTINGS

// Path prefix to load modules locally
workbox.setConfig({
	modulePathPrefix: 'workbox-v4.3.0/'
})

// Turn on logging
workbox.setConfig({
	debug: true
})

// Updating SW lifecycle to update the app after user triggered refresh
workbox.core.skipWaiting()
workbox.core.clientsClaim()

// PRECACHING

// We inject manifest here using "workbox-build" in workbox-build-inject.js
workbox.precaching.precacheAndRoute([
	{
		revision: '0b42ed37d8cc2aabc04ad20aaea0c7b1',
		url: 'icon-192x192.png'
	},
	{
		revision: '4198dc28a486c5a4d77f76786248d6e8',
		url: 'icon-256x256.png'
	},
	{
		revision: 'f52bd0a17db46193206ca4370bd8d1a3',
		url: 'icon-384x384.png'
	},
	{ revision: '085be3719325017156f949771475b1aa', url: 'icon-512x512.png' }
])
