# ARJAM - Just a Modal

Just a simple modal window to display content to a new visitor on their first visit. Includes a title, image and text.

## Description

This plugin is meant to deliver one thing and that's a simple modal that renders whenever a user visits your site for the first time. It has no third-party dependencies, no paid features, nothing.

The minimal JavaScript code is written in vanilla JS without jQuery for a faster and lighter experience. Code is meant to load all modal assets (including the image) only when necessary, to avoid burdening your pages with unneeded requests.

It uses cookies to store a hash that will hide the modal after the first visit. This hash can be invalidated from the admin section to force a re-render of the modal. Useful for when you want to push a new message/information.

## Features

* Set a title, an image and text (all optional fields, so you can mix and match them).
* Modal can be shown after a delay.
* Invalidate browsers cache to re-render the modal.
* Responsive layout.
* No PRO features!

## Installation

### WordPress Admin

1. Go to **Plugins** -> **Add plugin**.
2. Search for "arjam" in the search bar to the right.
3. Click on **Install now**.
4. Once installation is done, the button will change into **Activate**. Click it.
5. Have fun!


### Manual installation

1. Download the plugin from one of the two sources below:
    1. [Official WordPress.org directory](https://wordpress.org/plugins/arjam-just-a-modal/)
    2. [Latest release from GitHub](https://github.com/alessandrorosato/arjam-just-a-modal/releases)
2. Extract the content and copy to the `/wp-content/plugins/` directory of your WordPress installation.
3. From your WordPress dashboard, go to **Plugins** > **Installed Plugins**.
4. Find the "ARJAM - Just a Modal" plugin and activate it.
5. Have fun!

## Style override

You can easily override the plugin's style by using the following IDs in your custom css file:
* `arjam-modal-title` - Title of the modal window.
* `arjam-modal-image`  - Image of the modal window.
* `arjam-modal-richtext` - Text of the modal window.
* `arjam-modal-background` - Dark background behind the modal window.
* `arjam-modal-content` - The modal window itself.
* `arjam-modal-close` - Close button of the modal window.

## Cookies and local storage

This plugin stores on the visitor browser the hash that is meant to check whether the user has seen the current modal or not. This hash is stored in a key in the local storage called `arjam_hash`.

Besides that, no other cookie or local storage entry is created.