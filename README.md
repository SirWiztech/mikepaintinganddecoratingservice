# Mike's Painting & Decorating Services

Marketing site for **Mike's Painting & Decorating Services** - a painter and decorator based in
Devizes, Wiltshire, covering domestic and commercial work, inside and out.

The whole site is one PHP file (`index.php`) with its CSS and JavaScript inline: no build step, no
framework and no database.

## Run it locally

Any PHP 8+ install will do. From this folder:

```bash
php -S 127.0.0.1:8000 -t .
```

Then open <http://127.0.0.1:8000/>. With Laravel Herd you can just use the site URL Herd gives this
folder. The site was built and checked on PHP 8.5.

The form sends with PHP's `mail()`, so it only really works on a host with a mail transport - run
locally it will report the "that didn't send" message instead.

## Files

| Path | Purpose |
| --- | --- |
| `index.php` | The whole site: content arrays, markup, CSS and JavaScript |
| `assets-make.php` | Regenerates the brand images in `images/` from `images/logo.png` |
| `images/` | Logo, favicons, Open Graph image and the recent-work photos |
| `frames/` | Intermediate frames extracted from `video/hero.mp4` - not used by the page |
| `video/` | `hero.mp4` and its poster - not used, the hero animation is an SVG brush stroke |

## Editing the content

Everything likely to change sits at the top of `index.php`, above the markup.

### `$works` - the "Recent work" gallery

Photos are shown in array order, and the final grid cell is the "Want walls like these?"
call-to-action tile. Keep the number of photos to a multiple of 3 so the grid stays complete:
8 photos + 1 CTA = 9 cells, which is three full rows on desktop, two columns on tablet and one on
phones.

| Key | What it does |
| --- | --- |
| `img` | Path to the photo, e.g. `images/recent-work3.jpg` |
| `cap` | Caption on the tile, and the title in the lightbox |
| `meta` | Smaller second line, e.g. what was painted |
| `tag` | Pill in the top-left corner, e.g. `Interior`, `Exterior`, `Prep & finish` |
| `icon` | Sprite id for the pill icon: `i-roller`, `i-home`, `i-palette`, `i-check-circle`, `i-check` |
| `alt` | Alt text for screen readers and the lightbox image |

### `$reviews` - the "Customers say it best" cards

| Key | What it does |
| --- | --- |
| `q` | The quote itself |
| `name` | Shown in bold under the quote - initials only |
| `job` | What was done, e.g. `Bedroom & lounge` |
| `where` | Town, e.g. `Devizes` |

> **Before going live:** the three quotes in this array are placeholders. Replace them with real
> customer feedback, and only publish a review if the customer is happy for you to.

## Contact details and the form

- `$to` - the inbox the quote form is emailed to (currently `mikedodds24@icloud.com`).
- `$fb` - the Facebook page used by the "See more on Facebook" buttons.
- Phone `07493 041478`, the email address and the postal address (`19 Killbrock Mead, Devizes,
  SN10 2FU`) appear in the header, the hero, the contact block, the footer and the structured data -
  search and replace them in `index.php` if any of those change.

The form posts back to the same page. It needs a name plus either a phone number or an email; if the
send fails the visitor is told to call instead. Those states are driven by the `$status` values
`ok`, `missing` and `fail`. A hidden `website` field is included as a simple spam trap - if spam
ever gets through, a captcha is the next step.

## The colour picker

The `cols` array in the script at the bottom of `index.php` lists the swatches as
`[name, colour, contrasting text colour]`. Choosing one sets the page's `--acc` and `--on` CSS
variables, so the kicker icons, stars, buttons and the gallery call-to-action tile all follow the
choice. The first entry (`Ink`) is the default, and the choice is not remembered between visits.

## Accessibility and motion

- The gallery lightbox works by keyboard: `Esc` closes it, `←` / `→` step through the photos, the
  backdrop closes it, and the rest of the page is marked `inert` while it is open.
- Swatches report `aria-pressed`, the star ratings are labelled "Rated 5 out of 5", and the chosen
  colour name is announced with `aria-live`.
- `prefers-reduced-motion: reduce` disables the reveal animations, the ticker, the hero parallax and
  every hover transform.
- A `<noscript>` block reveals the scroll-animated sections when JavaScript is unavailable.

## SEO

`index.php` sets the title, description, Open Graph and Twitter tags, plus
`HomeAndConstructionBusiness` structured data (name, phone, email, address, area served, Facebook).
The share image and absolute URLs are derived from `images/og-image.png` and the request host, so
nothing needs editing after deploying to the real domain.

## Regenerating the brand images

`assets-make.php` trims the master `images/logo.png` and writes the header and footer logos, the
favicons, `og-image.png` and `main-logo.png` from it. It needs the GD extension:

```bash
php assets-make.php
```

It is safe to re-run, but keep a copy of the original uploaded logo first - the trimmed artwork is
written back over `images/logo.png`.

## Deploying

Upload `index.php`, `assets-make.php` and the `images/` folder to any PHP 8+ host; `frames/` and
`video/` are not used by the page and can be left out. There is no database and no writable folder,
so the only host requirement is that it can send mail from the quote form.


