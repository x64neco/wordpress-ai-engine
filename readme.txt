=== Sakura AI Connector ===
Contributors:      x64neco
Tags:              ai, sakura, openai, connector, ai-engine
Requires at least: 6.7
Tested up to:      6.8
Stable tag:        1.0.0
Requires PHP:      7.0
License:           GPL-2.0-or-later
License URI:       https://spdx.org/licenses/GPL-2.0-or-later.html

Connect WordPress to Sakura Internet AI Engine via the OpenAI-compatible API.

== Description ==

Sakura AI Connector integrates WordPress with the [Sakura Internet AI Engine](https://cloud.sakura.ad.jp/), enabling AI-powered text generation through an OpenAI-compatible API.

**Features**

* Registers the Sakura AI Engine as a provider via the WordPress Connectors API.
* Provides an AI Client SDK provider for seamless text generation.
* Supports the GPT OSS 120B model running on Sakura Internet's domestic data centers.
* OpenAI-compatible API — fast and secure.

**Requirements**

* WordPress 6.7 or later.
* The WordPress Connectors API must be available.
* A valid Sakura Internet AI Engine API key.

**Third-Party Service**

This plugin connects to the **Sakura Internet AI Engine API**, an external third-party service operated by SAKURA internet Inc.

* **Service URL:** [https://cloud.sakura.ad.jp/](https://cloud.sakura.ad.jp/)
* **API Endpoint:** `https://api.ai.sakura.ad.jp/v1`
* **Terms of Service:** [https://www.sakura.ad.jp/agreement/](https://www.sakura.ad.jp/agreement/)
* **Privacy Policy:** [https://www.sakura.ad.jp/privacy/](https://www.sakura.ad.jp/privacy/)

Data is sent to this service when AI text generation is requested. The data sent includes your prompt text and any associated options (e.g., temperature, max tokens). Please review the service's terms and privacy policy before use.

== Installation ==

1. Upload the `ai-engine-wordpress` folder to the `/wp-content/plugins/` directory, or install directly through the WordPress plugin screen.
2. Activate the plugin through the "Plugins" screen in WordPress.
3. Go to the Connectors settings and approve the Sakura AI connector.
4. Enter your Sakura Internet AI Engine API key.

== Frequently Asked Questions ==

= Where can I get an API key? =

You can obtain an API key from the [Sakura Internet Cloud Console](https://cloud.sakura.ad.jp/).

= Which AI models are supported? =

Currently, the GPT OSS 120B model is supported.

= Does this plugin store any user data? =

This plugin does not collect or store any user data on its own. Data is only sent to the Sakura Internet AI Engine API when a text generation request is made.

== Changelog ==

= 1.0.0 =
* Initial release.
* Connectors API integration for Sakura AI Engine.
* AI Client SDK provider registration.
* Full internationalization (i18n) support.
