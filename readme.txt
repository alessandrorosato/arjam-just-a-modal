=== ARJAM - Just a Modal ===
Contributors: alessandrorosato
Tags: modal, popup
Tested up to: 7.1
Stable tag: 1.0.3
Requires PHP: 7.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Just a simple modal window to display content to a new visitor on their first visit. Includes a title, image and text.

== Description ==

This plugin is meant to deliver one thing and that's a simple modal that renders whenever a user visits your site for the first time. It has no third-party dependencies, no paid features, nothing.

The minimal JavaScript code is written in vanilla JS without jQuery for a faster and lighter experience. Code is meant to load all modal assets (including the image) only when necessary, to avoid burdening your pages with unneeded requests.

It uses the browser's local storage to store a hash that will hide the modal after the first visit. This hash can be invalidated from the admin section to force a re-render of the modal. Useful for when you want to push a new message/information.

== Features ==

* Set a title, an image and text (all optional fields, so you can mix and match them).
* Modal can be shown after a delay.
* Invalidate browsers cache to re-render the modal.
* Responsive layout.
* No PRO features!

== Installation ==

= WordPress Admin =

1. Go to **Plugins** -> **Add plugin**.
2. Search for "arjam" in the search bar to the right.
3. Click on **Install now**.
4. Once installation is done, the button will change into **Activate**. Click it.
5. Have fun!

= Manual installation =

1. Download the plugin from one of the two sources below:
    1. [Official WordPress.org directory](https://wordpress.org/plugins/arjam-just-a-modal/)
    2. [Latest release from GitHub](https://github.com/alessandrorosato/arjam-just-a-modal/releases)
2. Extract the content and copy to the `/wp-content/plugins/` directory of your WordPress installation.
3. From your WordPress dashboard, go to **Plugins** > **Installed Plugins**.
4. Find the "ARJAM - Just a Modal" plugin and activate it.
5. Have fun!

== Style override ==

You can easily override the plugin's style by using the following IDs in your custom css file:
* `arjam-modal-title` - Title of the modal window.
* `arjam-modal-image`  - Image of the modal window.
* `arjam-modal-richtext` - Text of the modal window.
* `arjam-modal-background` - Dark background behind the modal window.
* `arjam-modal-content` - The modal window itself.
* `arjam-modal-close` - Close button of the modal window.

== Cookies and local storage ==

This plugin stores on the visitor browser the hash that is meant to check whether the user has seen the current modal or not. This hash is stored in a key in the local storage called `arjam_hash`.

Besides that, no other cookie or local storage entry is created.

== Frequently Asked Questions ==

= Why should I use this plugin instead of X =

That's the neat part, you don't! It's just a very simple and straight-forward plugin to add one simple modal to a WordPress website.

= If there are other plugins addressing the same feature, why making a new one? =

I just had the second-hand experience of a modal plugin deleting all modals already set and running because of an update. The plugin was also relying on a third-party platform (which was apparently responsible for making settings outdated and for deleting modals). I want to offer a *simple* solution.

= The modal is ugly, can I change its appearance? =

Yes you can! If you haven't seen it, scroll up to the "Style override" section. There's a list of IDs that you can use to set your own CSS rules.

== Screenshots ==

1. Backend settings
2. Frontend - Mobile
3. Frontend - Desktop

== Changelog ==

= 1.0.3 =
* Bugfix: image field sanification.
* Bugfix: delay field sanification.
* Maintenance: load assets only if modal is active.
* Maintenance: expanded browser support on CSS media query.
* Maintenance: improved accessibility.

= 1.0.2 =
* Bugfix: textarea will retain HTML tags.
* Bugfix: fixed a bug locking the page scroll when clicking outside the modal.
* Maintenance: admin scripts are now loaded only on plugin's page.
* Tested for WP 7.1.

= 1.0.1 =
* Tested for WP 7.0.

= 1.0.0 =
* First release, the plugin is fully operational!