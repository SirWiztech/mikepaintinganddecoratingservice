<?php
// Mike's Painting & Decorating Services - index.php
// Put the logo at images/logo.png (the file you uploaded). Change $to to change the inbox.
$to = 'mikedodds24@icloud.com';
$status = isset($_GET['sent']) ? 'ok' : '';
// Brand images in images/ are generated from the master logo by assets-make.php
$scheme  = (($_SERVER['HTTPS'] ?? '') === 'on') ? 'https' : 'http';
$baseDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/index.php'));
$abs     = $scheme . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . (in_array($baseDir, ['/', '.', '\\'], true) ? '' : rtrim($baseDir, '/'));
$fb      = 'https://www.facebook.com/profile.php?id=61572347094796';
// Recent work gallery: add, remove or reorder photos here - they are shown in this order.
// The last grid cell is the "ask for a quote" tile, so the photos should be a multiple of 3.
$works = [
    ['img' => 'images/recent-work3.jpg',  'cap' => 'Period lounge',      'meta' => 'Ceiling, cornice, walls and woodwork',        'tag' => 'Interior',      'icon' => 'i-roller',       'alt' => 'Freshly painted period lounge with white cornice, window shutters and soft neutral walls'],
    ['img' => 'images/recent-work2.jpg',  'cap' => 'Green feature wall', 'meta' => 'Period room, white cornice and panelling',    'tag' => 'Interior',      'icon' => 'i-palette',      'alt' => 'Period living room painted in deep green with crisp white cornice, skirting and door'],
    ['img' => 'images/recent-work10.jpg', 'cap' => 'Front door & porch', 'meta' => 'Exterior repaint in a bold green',        'tag' => 'Exterior',      'icon' => 'i-home',         'alt' => 'Front door and porch repainted in green with bright white trim on a red brick house'],
    ['img' => 'images/recent-work4.jpg',  'cap' => 'Master bedroom',     'meta' => 'Walls, dado rail and ceiling refreshed',      'tag' => 'Interior',      'icon' => 'i-roller',       'alt' => 'Bedroom repainted in soft taupe with fresh white ceiling, dado rail and woodwork'],
    ['img' => 'images/recent-work6.jpg',  'cap' => 'Living room',        'meta' => 'Full repaint, fireplace picked out in white', 'tag' => 'Interior',      'icon' => 'i-roller',       'alt' => 'Living room with bay window repainted in cream with white cornice, fireplace and skirting'],
    ['img' => 'images/recent-work8.jpg',  'cap' => 'Kitchen & dining',   'meta' => 'Deep green against exposed brick',          'tag' => 'Interior',      'icon' => 'i-palette',      'alt' => 'Kitchen and dining room painted in deep green with an exposed brick chimney breast'],
    ['img' => 'images/recent-work1.jpg',  'cap' => 'Bathroom',           'meta' => 'Washable finish and crisp white woodwork',    'tag' => 'Interior',      'icon' => 'i-check-circle', 'alt' => 'Bathroom repainted in warm grey with white painted door, woodwork and shelving'],
    ['img' => 'images/recent-work11.jpg', 'cap' => 'On the job',         'meta' => 'Careful prep and clean protection, every time', 'tag' => 'Prep & finish', 'icon' => 'i-check',    'alt' => 'Room prepared for decorating with dust sheets, rollers and freshly painted white walls'],
];
// Reviews shown in the Reviews section. NOTE: these are placeholders - swap them for real
// customer feedback before going live (initials only, so no full names are published).
$reviews = [
    ['q' => 'Mike was polite, tidy and turned up when he said he would. The finish on the walls is spot on and you would hardly know he had been in the house.',
     'name' => 'Sarah H.', 'where' => 'Devizes',     'job' => 'Bedroom & lounge'],
    ['q' => 'Really pleased with the outside of the house and the front door. Everything was properly prepped first and it looks like new again.',
     'name' => 'James T.', 'where' => 'Marlborough', 'job' => 'Exterior & front door'],
    ['q' => 'The colour advice was a huge help - we would never have picked it ourselves and it has completely transformed the kitchen.',
     'name' => 'Helen R.', 'where' => 'Pewsey',      'job' => 'Kitchen & hallway'],
];
$clean = fn($v) => trim(str_replace(["\r", "\n"], ' ', strip_tags((string)$v)));
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['website'])) { $status = 'ok'; }          // honeypot
    else {
        $n = $clean($_POST['n'] ?? ''); $p = $clean($_POST['p'] ?? '');
        $e = filter_var($_POST['e'] ?? '', FILTER_VALIDATE_EMAIL) ?: '';
        $t = $clean($_POST['t'] ?? 'General'); $m = trim(strip_tags($_POST['m'] ?? ''));
        if ($n === '' || ($p === '' && $e === '')) { $status = 'missing'; }
        else {
            $host = preg_replace('/[^a-z0-9.\-]/i', '', $_SERVER['HTTP_HOST'] ?? 'localhost');
            $h = "From: Mikes Painting Website <no-reply@{$host}>\r\n";
            if ($e) $h .= "Reply-To: {$e}\r\n";
            $h .= "Content-Type: text/plain; charset=UTF-8\r\n";
            $b = "Name: {$n}\nPhone: {$p}\nEmail: {$e}\nJob: {$t}\n\n{$m}\n";
            if (mail($to, "Quote enquiry: {$t}", $b, $h)) {
                header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?') . '?sent=1#contact'); exit;
            }
            $status = 'fail';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en-GB">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="theme-color" content="#ffffff">
<title>Mike's Painting &amp; Decorating Services | Painter &amp; Decorator, Devizes &amp; Wiltshire</title>
<meta name="description" content="Trusted painter and decorator based in Devizes, covering Wiltshire for domestic and commercial interior and exterior work. Get in touch for a quote.">
<link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32.png">
<link rel="icon" type="image/png" sizes="512x512" href="images/favicon.png">
<link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Mike's Painting &amp; Decorating Services">
<meta property="og:title" content="Mike's Painting &amp; Decorating Services | Painter &amp; Decorator, Devizes &amp; Wiltshire">
<meta property="og:description" content="Trusted painter and decorator based in Devizes, covering Wiltshire for domestic and commercial interior and exterior work.">
<meta property="og:image" content="<?= $abs ?>/images/og-image.png">
<meta property="og:image:alt" content="Mike's Painting &amp; Decorating Services logo">
<meta property="og:locale" content="en_GB">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:image" content="<?= $abs ?>/images/og-image.png">
<script type="application/ld+json"><?= json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'HomeAndConstructionBusiness',
    'name' => "Mike's Painting & Decorating Services",
    'description' => 'Painter and decorator in Devizes covering Wiltshire for domestic and commercial interior and exterior work.',
    'url' => $abs . '/',
    'logo' => $abs . '/images/main-logo.png',
    'image' => $abs . '/images/og-image.png',
    'telephone' => '+447493041478',
    'email' => 'mikedodds24@icloud.com',
    'address' => ['@type' => 'PostalAddress', 'streetAddress' => '19 Killbrock Mead', 'addressLocality' => 'Devizes', 'addressRegion' => 'Wiltshire', 'postalCode' => 'SN10 2FU', 'addressCountry' => 'GB'],
    'areaServed' => ['Devizes', 'Wiltshire'],
    'sameAs' => [$fb],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;700;800&amp;family=Playball&amp;display=swap" rel="stylesheet">
<style>
:root{--paper:#FBFAF7;--ink:#141414;--mut:#5f5e5a;--line:rgba(20,20,20,.14);--acc:#141414;--on:#fff;box-sizing:border-box;padding-top:env(safe-area-inset-top,0);padding-bottom:env(safe-area-inset-bottom,0)}
*,*::before,*::after{box-sizing:inherit}
html{scroll-behavior:smooth;scroll-padding-top:84px;overflow-x:hidden}
body{margin:0;background:var(--paper);color:var(--ink);font:400 17px/1.65 'Figtree','Helvetica Neue',Arial,sans-serif;overflow-x:hidden;-webkit-font-smoothing:antialiased}
a{color:inherit}
:focus-visible{outline:3px solid var(--acc);outline-offset:3px}
.wrap{max-width:1160px;margin:0 auto;padding:0 24px}
h1,h2,h3{margin:0;font-weight:800;letter-spacing:.01em;line-height:1.05}
.script{font-family:'Playball','Georgia',cursive;font-weight:400;letter-spacing:0}
.caps{text-transform:uppercase;letter-spacing:.06em}
.ic{width:1em;height:1em;flex:none;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;vertical-align:-.14em}
.icf{fill:currentColor;stroke:none}
.rv,.rv-l,.rv-r,.rv-z{opacity:0;transition:opacity .7s ease,transform .75s cubic-bezier(.2,.65,.3,1);transition-delay:var(--d,0s)}
.rv{transform:translateY(26px)}
.rv-l{transform:translateX(-38px)}
.rv-r{transform:translateX(38px)}
.rv-z{transform:scale(.94)}
.rv.in,.rv-l.in,.rv-r.in,.rv-z.in{opacity:1;transform:none}
.prog{position:fixed;inset:0 auto auto 0;z-index:60;width:100%;height:3px;background:var(--acc);transform:scaleX(var(--p,0));transform-origin:0 50%;transition:background .5s;pointer-events:none}

header.top{position:fixed;inset:0 0 auto 0;z-index:50;background:rgba(251,250,247,.9);backdrop-filter:blur(10px);border-bottom:1px solid var(--line);transition:background .35s,box-shadow .35s}
header.top.scrolled{background:rgba(251,250,247,.97);box-shadow:0 14px 34px -26px rgba(0,0,0,.55)}
header.top .wrap{display:flex;align-items:center;justify-content:space-between;gap:16px;height:72px;transition:height .35s}
header.top.scrolled .wrap{height:60px}
.logo{display:block;width:150px;flex:none;transition:width .35s}
header.top.scrolled .logo{width:120px}
.logo img{display:block;width:100%;height:auto}
.links{display:flex;gap:26px;font-weight:700;font-size:15px}
.links a{display:inline-flex;align-items:center;gap:6px;text-decoration:none;position:relative;padding:4px 0}
.links a::after{content:"";position:absolute;left:0;right:0;bottom:-2px;height:3px;background:var(--acc);transform:scaleX(0);transform-origin:left;transition:transform .3s}
.links a:hover::after{transform:scaleX(1)}
.links a.active{color:var(--acc)}
.links a.active::after{transform:scaleX(1)}
.links a .ic{color:var(--mut);transition:color .3s,transform .3s}
.links a:hover .ic,.links a.active .ic{color:var(--acc);transform:translateX(3px)}
.burger{display:inline-flex;width:46px;height:46px;align-items:center;justify-content:center;border:2px solid var(--ink);border-radius:50%;background:transparent;color:var(--ink);cursor:pointer;flex:none;padding:0;transition:background .3s,color .3s,transform .3s}
.burger:hover{transform:rotate(-8deg)}
.burger .ic{width:22px;height:22px}
.burger .i-x{display:none}
.burger[aria-expanded="true"]{background:var(--acc);border-color:var(--acc);color:var(--on)}
.burger[aria-expanded="true"] .i-x{display:block}
.burger[aria-expanded="true"] .i-bars{display:none}
.drawer{position:fixed;inset:0 0 auto 0;z-index:45;background:var(--paper);border-bottom:1px solid var(--line);box-shadow:0 34px 60px -40px rgba(0,0,0,.5);padding:92px 0 26px;transform:translateY(-104%);visibility:hidden;transition:transform .45s cubic-bezier(.3,.85,.2,1),visibility .45s}
.drawer.open{transform:none;visibility:visible}
.drawer a{display:flex;align-items:center;gap:14px;padding:13px 0;border-bottom:1px solid var(--line);font-weight:700;font-size:19px;text-decoration:none}
.drawer a .ic{width:21px;height:21px;color:var(--mut);transition:color .3s,transform .3s}
.drawer a:hover .ic,.drawer a.active .ic{color:var(--acc);transform:translateX(3px)}
.drawer .drawer-cta{display:flex;gap:12px;flex-wrap:wrap;margin-top:22px}
.drawer .drawer-cta .btn{flex:1 1 auto}
.btn{display:inline-flex;align-items:center;justify-content:center;gap:10px;padding:14px 28px;border-radius:99px;font:700 16px 'Figtree',sans-serif;text-decoration:none;border:2px solid var(--ink);color:var(--ink);background:transparent;cursor:pointer;transition:transform .2s,background .3s,color .3s}
.btn:hover{transform:translateY(-2px)}
.btn .ic{transition:transform .3s}
.btn:hover .ic{transform:translateX(3px)}
.btn.fill:hover{box-shadow:0 18px 30px -20px rgba(0,0,0,.65)}
.btn.fill{background:var(--acc);border-color:var(--acc);color:var(--on)}
header .btn{padding:10px 20px;font-size:15px}

.hero{position:relative;overflow:hidden;min-height:100svh;display:flex;align-items:center;padding:110px 0 215px}
.hero .wrap{width:100%;position:relative;z-index:2}
.kick{display:flex;align-items:center;gap:8px;font-weight:700;font-size:13px;letter-spacing:.22em;text-transform:uppercase;color:var(--mut);margin:0 0 6px}
.kick .ic{width:16px;height:16px;color:var(--acc);transition:transform .4s}
.rv.in .kick .ic,.kick.rv.in .ic{transform:rotate(-8deg) scale(1.05)}
.hero h1{display:block}
.hero .script{display:block;font-size:clamp(92px,21vw,270px);line-height:.95;margin-left:-.03em}
.hero .name{display:block;font-size:clamp(20px,3.6vw,46px);margin-top:4px;max-width:20ch}
.hero p.lead{max-width:40ch;font-size:clamp(18px,1.8vw,22px);margin:26px 0 32px}
.btns{display:flex;gap:12px;flex-wrap:wrap;position:relative;z-index:2}
.badges{display:flex;flex-wrap:wrap;gap:10px 20px;margin:32px 0 0;padding:0;list-style:none}
.badges li{display:flex;align-items:center;gap:9px;font-weight:700;font-size:12.5px;letter-spacing:.05em;text-transform:uppercase;color:var(--mut)}
.badges .ic{width:18px;height:18px;color:var(--acc);flex:none;transition:transform .4s}
.badges li:hover .ic{transform:rotate(-10deg) scale(1.1)}
.stroke{position:absolute;left:0;right:0;bottom:0;width:100%;height:clamp(120px,17vh,200px);pointer-events:none;z-index:0}
.stroke .s1{fill:none;stroke:var(--acc);stroke-width:70;stroke-linecap:round;stroke-dasharray:1;stroke-dashoffset:0;animation:draw 1.5s cubic-bezier(.5,.1,.3,1) .3s backwards;transition:stroke .5s}
.stroke .s2{fill:none;stroke:var(--paper);stroke-width:3;stroke-linecap:round;opacity:.35;stroke-dasharray:1;animation:draw 1.5s cubic-bezier(.5,.1,.3,1) .45s backwards}
.stroke .dot{fill:var(--acc);transition:fill .5s;animation:pop .5s ease 1.6s backwards}
@keyframes draw{from{stroke-dashoffset:1}}
@keyframes pop{from{opacity:0;transform:scale(0)}}
.stroke .dot{transform-box:fill-box;transform-origin:center}

section{padding:clamp(70px,10vw,130px) 0}
.lede{position:relative;padding-bottom:.14em;font-size:clamp(32px,5.2vw,68px);max-width:15ch;text-transform:uppercase}
.lede::after{content:"";position:absolute;left:0;bottom:0;width:min(190px,42%);height:6px;background:var(--acc);transform:scaleX(0);transform-origin:0 50%;transition:transform .85s cubic-bezier(.3,.85,.2,1) .3s,background .5s}
.lede.rv.in::after,.lede:not(.rv)::after{transform:scaleX(1)}
.sub{color:var(--mut);max-width:46ch;margin:18px 0 0}
.grid4{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));border-top:2px solid var(--ink);margin-top:56px}
.svc{padding:34px 30px 38px 0;border-bottom:1px solid var(--line);transition:padding .3s}
.svc:nth-child(odd){border-right:1px solid var(--line)}
.svc:nth-child(even){padding-left:30px}
.svc small{display:block;font-weight:700;letter-spacing:.2em;font-size:12px;text-transform:uppercase;color:var(--mut);margin-bottom:12px}
.svc h3{font-size:clamp(26px,3vw,40px);text-transform:uppercase;margin-bottom:12px}
.svc h3 span{display:inline-block;background:linear-gradient(var(--acc),var(--acc)) 0 100%/0 6px no-repeat;transition:background-size .4s,color .3s}
.svc:hover h3 span{background-size:100% 6px}
.svc p{margin:0;color:var(--mut);max-width:38ch}
.svc .ic{width:36px;height:36px;color:var(--acc);margin-bottom:18px;transition:transform .45s cubic-bezier(.2,.7,.3,1),color .4s}
.svc:hover .ic{transform:translateY(-5px) rotate(-7deg) scale(1.07)}

.ticker{border-top:1px solid var(--line);border-bottom:1px solid var(--line);background:var(--paper);overflow:hidden}
.ticker .track{display:flex;width:max-content;animation:slide 38s linear infinite}
.ticker span{display:inline-flex;align-items:center;gap:12px;padding:15px 26px;font-weight:800;font-size:13px;letter-spacing:.14em;text-transform:uppercase;color:var(--mut);white-space:nowrap}
.ticker .ic{width:16px;height:16px;color:var(--acc);flex:none}
.ticker:hover .track{animation-play-state:paused}
@keyframes slide{to{transform:translateX(-50%)}}

.job{background:var(--ink);color:#fff}
.job .cols{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1.2fr);gap:clamp(30px,6vw,90px);align-items:center}
.job .script{font-size:clamp(46px,7vw,92px);line-height:1}
.job blockquote{margin:0;font-size:clamp(21px,2.5vw,32px);line-height:1.35;font-weight:500;border-left:5px solid var(--acc);padding-left:24px;transition:border-color .5s}
.job a.btn{color:#fff;border-color:rgba(255,255,255,.5);margin-top:30px}
.job a.btn:hover{background:#fff;color:var(--ink)}
.job .kick{color:#bdbcb6}
.job .kick .ic{color:currentColor}

.pick .cols{display:grid;grid-template-columns:minmax(0,1.25fr) minmax(0,1fr);gap:clamp(24px,5vw,70px);align-items:center;margin-top:50px}
.chip{border-radius:20px;background:var(--acc);color:var(--on);aspect-ratio:16/10;display:flex;flex-direction:column;justify-content:center;align-items:center;text-align:center;transition:background .5s,color .5s;box-shadow:0 30px 60px -30px rgba(0,0,0,.4);padding:20px}
.chip .mark{width:min(80%,440px);aspect-ratio:335/155;background:var(--on);-webkit-mask:url("images/logo.png") center/contain no-repeat;mask:url("images/logo.png") center/contain no-repeat;transition:background .5s}
.sw{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin:22px 0}
.sw button{aspect-ratio:1;border:0;border-radius:50%;background:var(--c);cursor:pointer;box-shadow:inset 0 0 0 1px rgba(0,0,0,.2);transition:transform .2s}
.sw button:hover{transform:scale(1.1)}
.sw button[aria-pressed="true"]{outline:3px solid var(--ink);outline-offset:4px}
.pname{font-weight:800;font-size:clamp(24px,3vw,36px);text-transform:uppercase;margin:0}

.area{border-top:1px solid var(--line)}
.area .cols{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:clamp(30px,6vw,90px);align-items:end}
.towns{font-size:clamp(28px,4.4vw,58px);font-weight:800;text-transform:uppercase;line-height:1.05}
.towns i{font-style:normal;color:var(--mut);font-weight:500;font-size:.5em;display:block;margin-top:14px;letter-spacing:.06em}

.contact{background:#F0EEE8}
.contact .cols{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:clamp(30px,6vw,90px)}
.big{display:flex;align-items:center;gap:14px;font-weight:800;font-size:clamp(20px,2.8vw,34px);text-decoration:none;margin-top:22px;overflow-wrap:anywhere}
.big .ic{width:46px;height:46px;padding:12px;border-radius:50%;background:var(--acc);color:var(--on);transition:background .5s,color .5s,transform .35s}
.big:hover .ic{transform:rotate(-8deg) scale(1.07)}
.big:hover span{text-decoration:underline;text-underline-offset:6px}
address{display:flex;align-items:center;gap:10px;font-style:normal;color:var(--mut);margin-top:26px}
address .ic{width:18px;height:18px;color:var(--acc);flex:none}
form{display:grid;gap:14px}
label{display:grid;gap:6px;font-weight:700;font-size:14px}
input,select,textarea{font:inherit;padding:13px 14px;border:2px solid var(--ink);background:#fff;border-radius:8px;color:var(--ink);width:100%}
input:focus,select:focus,textarea:focus{outline:none;box-shadow:0 0 0 4px rgba(20,20,20,.15)}
textarea{min-height:110px;resize:vertical}
.note{margin:0;padding:12px 14px;border-radius:8px;font-weight:700}
.note.ok{background:var(--ink);color:#fff}.note.bad{background:#fff;border:2px solid #b3261e;color:#b3261e}
.totop{position:fixed;right:22px;bottom:22px;z-index:55;width:50px;height:50px;display:grid;place-items:center;padding:0;border:0;border-radius:50%;background:var(--acc);color:var(--on);cursor:pointer;box-shadow:0 18px 34px -18px rgba(0,0,0,.65);opacity:0;transform:translateY(18px) scale(.85);pointer-events:none;transition:opacity .35s,transform .35s,background .5s}
.totop.on{opacity:1;transform:none;pointer-events:auto}
.totop:hover{transform:translateY(-3px)}
.totop .ic{width:22px;height:22px}
footer{background:var(--ink);color:#d9d8d3;padding:46px 0 30px;font-size:15px}
footer .cols{display:flex;justify-content:space-between;gap:34px;flex-wrap:wrap;align-items:flex-start}
footer .flogo{width:200px;margin-bottom:20px}
footer .flogo img{display:block;width:100%;height:auto}
footer .fmeta{display:grid;gap:11px}
footer .fmeta a,footer .fmeta span{display:flex;align-items:center;gap:10px;text-decoration:none}
footer .fmeta .ic{width:18px;height:18px;color:#8f8e88;flex:none}
footer .fnav{display:flex;gap:20px;flex-wrap:wrap;font-weight:700}
footer .fnav a{display:inline-flex;align-items:center;gap:7px}
footer .fnav .ic{width:15px;height:15px;color:#8f8e88;transition:color .3s}
footer .fnav a:hover .ic{color:#fff}
footer a{color:#fff}
footer .fine{display:flex;justify-content:space-between;gap:14px;flex-wrap:wrap;margin-top:34px;padding-top:20px;border-top:1px solid rgba(255,255,255,.16);color:#a3a29c;font-size:14px}
footer .fine a{display:inline-flex;align-items:center;gap:9px}
footer .fine .ic{width:17px;height:17px;color:#8f8e88}

.gal{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px;margin-top:52px}
.wk{position:relative;display:block;margin:0;padding:0;border:0;background:#e6e4df;border-radius:16px;overflow:hidden;cursor:pointer;aspect-ratio:4/3;text-align:left;color:#fff;font:inherit;-webkit-tap-highlight-color:transparent;transition:transform .45s cubic-bezier(.2,.7,.3,1),box-shadow .45s}
.wk:hover,.wk:focus-visible{transform:translateY(-6px);box-shadow:0 28px 54px -30px rgba(0,0,0,.6)}
.wk-media{position:absolute;inset:-9% 0;display:block;width:100%;height:118%;transform:translate3d(0,var(--py,0),0);will-change:transform}
.wk img{display:block;width:100%;height:100%;object-fit:cover;transform:scale(1.02);transition:transform .8s cubic-bezier(.2,.7,.3,1)}
.wk:hover img,.wk:focus-visible img{transform:scale(1.09)}
.wk::after{content:"";position:absolute;inset:auto 0 0 0;height:62%;background:linear-gradient(transparent,rgba(10,10,10,.78));pointer-events:none}
.wk .tag{position:absolute;z-index:2;top:12px;left:12px;display:inline-flex;align-items:center;gap:7px;padding:7px 12px;border-radius:99px;background:rgba(251,250,247,.95);color:var(--ink);font-weight:800;font-size:11px;letter-spacing:.12em;text-transform:uppercase}
.wk .tag .ic{width:14px;height:14px;color:var(--acc);transition:transform .45s cubic-bezier(.2,.7,.3,1),color .5s}
.wk:hover .tag .ic,.wk:focus-visible .tag .ic{transform:rotate(-10deg) scale(1.15)}
.wk .zoom{position:absolute;z-index:2;top:12px;right:12px;width:40px;height:40px;padding:9px;border-radius:50%;background:rgba(15,15,15,.55);color:#fff;opacity:0;transform:scale(.75) rotate(-12deg);transition:opacity .35s,transform .45s cubic-bezier(.2,.7,.3,1)}
.wk .zoom .ic{display:block;width:100%;height:100%}
.wk:hover .zoom,.wk:focus-visible .zoom{opacity:1;transform:none}
.wk .cap{position:absolute;z-index:2;inset:auto 16px 15px 16px;display:block;transition:transform .45s cubic-bezier(.2,.7,.3,1)}
.wk:hover .cap,.wk:focus-visible .cap{transform:translateY(-4px)}
.wk .cap strong{display:block;font-size:clamp(17px,1.6vw,21px);font-weight:800;line-height:1.2}
.wk .cap span{display:block;margin-top:5px;font-size:13px;color:rgba(255,255,255,.76)}
.wk-cta{display:flex;flex-direction:column;justify-content:center;align-items:flex-start;gap:14px;padding:clamp(22px,2.4vw,32px);aspect-ratio:4/3;border-radius:16px;background:var(--acc);color:var(--on);text-decoration:none;transition:transform .45s cubic-bezier(.2,.7,.3,1),box-shadow .45s,background .5s,color .5s}
.wk-cta:hover{transform:translateY(-6px);box-shadow:0 28px 54px -30px rgba(0,0,0,.6)}
.wk-cta .big-ic{width:clamp(32px,3vw,44px);height:clamp(32px,3vw,44px);transition:transform .45s cubic-bezier(.2,.7,.3,1)}
.wk-cta:hover .big-ic{transform:rotate(-8deg) scale(1.1)}
.wk-cta strong{font-size:clamp(20px,2.1vw,27px);line-height:1.12;text-transform:uppercase}
.wk-cta p{margin:0;font-size:14.5px;opacity:.78}
.wk-cta .go{display:inline-flex;align-items:center;gap:9px;margin-top:4px;padding-bottom:4px;border-bottom:2px solid currentColor;font-weight:800;font-size:12.5px;letter-spacing:.12em;text-transform:uppercase}
.wk-cta .go .ic{width:16px;height:16px;transition:transform .4s}
.wk-cta:hover .go .ic{transform:translateX(4px)}

.lb{position:fixed;inset:0;z-index:70;display:grid;place-items:center;padding:clamp(16px,4vw,48px);background:rgba(10,10,10,.92);backdrop-filter:blur(7px);opacity:0;visibility:hidden;transition:opacity .35s,visibility .35s}
.lb.on{opacity:1;visibility:visible}
.lb figure{margin:0;display:flex;flex-direction:column;gap:16px;max-width:min(1080px,100%);opacity:0;transform:scale(.95);transition:opacity .4s,transform .5s cubic-bezier(.2,.7,.3,1)}
.lb.on figure{opacity:1;transform:none}
.lb img{display:block;width:auto;height:auto;max-width:100%;max-height:min(72vh,720px);margin:0 auto;border-radius:14px;box-shadow:0 40px 90px -40px #000}
.lb figcaption{color:#fff;text-align:center}
.lb figcaption strong{display:block;font-weight:800;font-size:clamp(17px,2vw,22px)}
.lb figcaption span{display:block;margin-top:5px;font-size:14px;color:#bdbcb6}
.lb button{display:grid;place-items:center;width:50px;height:50px;padding:0;border:2px solid rgba(255,255,255,.45);border-radius:50%;background:rgba(20,20,20,.6);color:#fff;cursor:pointer;transition:background .3s,color .3s,border-color .3s,transform .3s}
.lb button:hover{background:#fff;border-color:#fff;color:#141414}
.lb button .ic{width:22px;height:22px}
.lb .x{position:absolute;top:20px;right:20px}
.lb .nav{position:absolute;top:50%;transform:translateY(-50%)}
.lb .nav:hover{transform:translateY(-50%) scale(1.06)}
.lb .prev{left:clamp(10px,2vw,26px)}
.lb .next{right:clamp(10px,2vw,26px)}

.revs{border-top:1px solid var(--line)}
.revgrid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:14px;margin-top:52px}
.revc{position:relative;display:flex;flex-direction:column;gap:16px;margin:0;padding:34px 30px 30px;background:#fff;border:1px solid var(--line);border-radius:18px;overflow:hidden;transition:transform .45s cubic-bezier(.2,.7,.3,1),box-shadow .45s,border-color .45s}
.revc::before{content:"";position:absolute;inset:0 0 auto 0;height:4px;background:var(--acc);transform:scaleX(0);transform-origin:0 50%;transition:transform .55s cubic-bezier(.3,.85,.2,1),background .5s}
.revc:hover{transform:translateY(-6px);box-shadow:0 28px 54px -36px rgba(0,0,0,.55);border-color:transparent}
.revc:hover::before{transform:scaleX(1)}
.revc .q{position:absolute;top:24px;right:26px;width:46px;height:46px;color:var(--acc);opacity:.12;transform:rotate(180deg);transition:opacity .45s,transform .55s cubic-bezier(.2,.7,.3,1)}
.revc:hover .q{opacity:.2;transform:rotate(180deg) scale(1.08)}
.stars{display:flex;gap:5px}
.stars .ic{width:19px;height:19px;color:var(--acc)}
.revc.in .stars .ic{animation:starpop .55s cubic-bezier(.2,1.5,.4,1) backwards;animation-delay:calc(.3s + var(--i,0)*.09s)}
@keyframes starpop{from{opacity:0;transform:scale(.3) rotate(-30deg)}}
.revc blockquote{margin:0;font-size:clamp(17px,1.55vw,19.5px);line-height:1.5}
.revc figcaption{margin-top:auto;padding-top:16px;border-top:1px solid var(--line);font-size:14px;color:var(--mut)}
.revc figcaption strong{display:block;font-size:15.5px;color:var(--ink)}
.revfoot{display:flex;align-items:center;gap:18px;flex-wrap:wrap;margin-top:36px}
.revfoot p{margin:0;max-width:46ch;color:var(--mut);font-size:14.5px}

@media(min-width:901px){
.burger{display:none}
}
@media(min-width:901px) and (max-width:1150px){
.links{gap:14px;font-size:14px}
.links a{gap:4px}
.links a .ic{width:13px;height:13px}
header .btn{padding:10px 16px}
}
@media(max-width:900px){
.links{display:none}
.job .cols,.pick .cols,.area .cols,.contact .cols{grid-template-columns:minmax(0,1fr)}
.gal{grid-template-columns:repeat(2,minmax(0,1fr))}
.wk-cta{grid-column:span 2;aspect-ratio:auto;min-height:220px}
.revgrid{grid-template-columns:minmax(0,1fr)}
.wk .zoom{opacity:.9;transform:none}
}
@media(max-width:600px){
.wrap{padding:0 18px}
.logo{width:118px}
header.top.scrolled .logo{width:104px}
header .btn{width:46px;height:46px;padding:0;border-radius:50%}
header .btn span{display:none}
.hero{padding-top:100px;padding-bottom:150px;align-items:flex-start}
.btns .btn{flex:1 1 100%}
.btns .btn span{display:inline}
.stroke{height:clamp(80px,13vh,120px)}
.badges{gap:8px 14px}
.grid4{grid-template-columns:minmax(0,1fr)}
.svc,.svc:nth-child(even){padding:28px 0;border-right:0}
.ticker span{padding:13px 18px;font-size:12px}
.gal{grid-template-columns:minmax(0,1fr)}
.wk-cta{grid-column:auto;min-height:0;aspect-ratio:4/3}
.revc{padding:28px 24px 24px}
.lb button{width:44px;height:44px}
.lb img{max-height:58vh}
footer .flogo{width:170px}
}
@media(prefers-reduced-motion:reduce){
html{scroll-behavior:auto}
.stroke .s1,.stroke .s2,.stroke .dot{animation:none}
.rv,.rv-l,.rv-r,.rv-z{opacity:1;transform:none;transition:none}
.ticker .track{animation:none}
.lede::after{transform:scaleX(1);transition:none}
header.top .wrap,.logo,.prog,.totop,.drawer,.svc .ic,.badges .ic,.big .ic,.btn .ic,.kick .ic,.links .ic,.fnav .ic{transition:none}
.wk,.wk img,.wk .zoom,.wk .cap,.wk-media,.wk .tag .ic,.wk-cta,.wk-cta .big-ic,.wk-cta .go .ic,.revc,.revc::before,.revc .q,.lb,.lb figure{transition:none}
.wk:hover,.wk:focus-visible,.wk-cta:hover,.revc:hover{transform:none}
.wk:hover img,.wk:focus-visible img{transform:none}
.revc.in .stars .ic{animation:none}
.revc:hover::before,.lede.rv.in::after{transform:scaleX(1)}
}
</style>
<noscript><style>.rv,.rv-l,.rv-r,.rv-z{opacity:1;transform:none}</style></noscript>
</head>
<body>
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
<filter id="rough" x="-5%" y="-30%" width="110%" height="160%"><feTurbulence type="fractalNoise" baseFrequency=".035 .6" numOctaves="2" seed="4" result="n"/><feDisplacementMap in="SourceGraphic" in2="n" scale="16"/></filter>
<symbol id="i-phone" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.2 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/></symbol>
<symbol id="i-mail" viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></symbol>
<symbol id="i-arrow" viewBox="0 0 24 24"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></symbol>
<symbol id="i-arrow-up" viewBox="0 0 24 24"><path d="M12 19V5"/><path d="m5 12 7-7 7 7"/></symbol>
<symbol id="i-roller" viewBox="0 0 24 24"><rect x="2" y="2" width="16" height="6" rx="2"/><path d="M10 16v-2a2 2 0 0 1 2-2h8a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/><rect x="8" y="16" width="4" height="6" rx="1"/></symbol>
<symbol id="i-home" viewBox="0 0 24 24"><path d="M3 10.5 12 3l9 7.5"/><path d="M5 9.5V21h14V9.5"/><path d="M10 21v-6h4v6"/></symbol>
<symbol id="i-building" viewBox="0 0 24 24"><path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/></symbol>
<symbol id="i-store" viewBox="0 0 24 24"><path d="M3 9h18v11a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1z"/><path d="M3 9 4.5 4h15L21 9"/><path d="M9 21v-6h6v6"/></symbol>
<symbol id="i-palette" viewBox="0 0 24 24"><circle cx="13.5" cy="6.5" r="1"/><circle cx="17.5" cy="10.5" r="1"/><circle cx="8.5" cy="7.5" r="1"/><circle cx="6.5" cy="12.5" r="1"/><path d="M12 2a10 10 0 1 0 0 20 1.6 1.6 0 0 0 1.2-2.6 1.6 1.6 0 0 1 1.2-2.6H16a6 6 0 0 0 6-6c0-5-4.5-9.2-10-9.2z"/></symbol>
<symbol id="i-check" viewBox="0 0 24 24"><path d="m20 6-11 11-5-5"/></symbol>
<symbol id="i-check-circle" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></symbol>
<symbol id="i-pin" viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0z"/><circle cx="12" cy="10" r="3"/></symbol>
<symbol id="i-chat" viewBox="0 0 24 24"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22z"/></symbol>
<symbol id="i-send" viewBox="0 0 24 24"><path d="m22 2-7 20-4-9-9-4z"/><path d="M22 2 11 13"/></symbol>
<symbol id="i-photo" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-4.6-4.6L5 21"/></symbol>
<symbol id="i-menu" viewBox="0 0 24 24"><path d="M4 7h16"/><path d="M4 12h16"/><path d="M4 17h16"/></symbol>
<symbol id="i-close" viewBox="0 0 24 24"><path d="M6 6 18 18"/><path d="M18 6 6 18"/></symbol>
<symbol id="i-facebook" viewBox="0 0 24 24"><path d="M22 12.06C22 6.5 17.52 2 12 2S2 6.5 2 12.06c0 5 3.66 9.15 8.44 9.94v-7.03H7.9v-2.91h2.54V9.85c0-2.51 1.49-3.9 3.77-3.9 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.78-1.63 1.57v1.88h2.78l-.45 2.91h-2.33V22c4.78-.79 8.44-4.94 8.44-9.94z"/></symbol>
<symbol id="i-star" viewBox="0 0 24 24"><path d="M12 2.5l2.9 5.9 6.5.9-4.7 4.6 1.1 6.5-5.8-3.1-5.8 3.1 1.1-6.5-4.7-4.6 6.5-.9z"/></symbol>
<symbol id="i-quote" viewBox="0 0 24 24"><path d="M8.6 18c-1.9 0-3.4-1.5-3.4-3.4 0-3.9 2.4-7 6.3-8.6l1 1.9c-2.2 1-3.6 2.4-4.2 4.1.3-.1.7-.2 1.1-.2 1.7 0 3 1.3 3 3.1S10.5 18 8.6 18zm8.6 0c-1.9 0-3.4-1.5-3.4-3.4 0-3.9 2.4-7 6.3-8.6l1 1.9c-2.2 1-3.6 2.4-4.2 4.1.3-.1.7-.2 1.1-.2 1.7 0 3 1.3 3 3.1S19.1 18 17.2 18z"/></symbol>
<symbol id="i-zoom" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.7-3.7"/><path d="M11 8.4v5.2"/><path d="M8.4 11h5.2"/></symbol>
<symbol id="i-left" viewBox="0 0 24 24"><path d="m14.5 5.5-6.5 6.5 6.5 6.5"/></symbol>
<symbol id="i-right" viewBox="0 0 24 24"><path d="m9.5 5.5 6.5 6.5-6.5 6.5"/></symbol>
</svg>

<div class="prog" aria-hidden="true"></div>
<header class="top">
  <div class="wrap">
    <a class="logo" href="#top" aria-label="Mike's Painting and Decorating Services home"><img src="images/logo.png" alt="Mike's Painting &amp; Decorating Services" width="335" height="155"></a>
    <nav class="links" aria-label="Main"><a href="#services"><svg class="ic"><use href="#i-roller"/></svg>Services</a><a href="#work"><svg class="ic"><use href="#i-photo"/></svg>Recent work</a><a href="#reviews"><svg class="ic icf"><use href="#i-star"/></svg>Reviews</a><a href="#colour"><svg class="ic"><use href="#i-palette"/></svg>Colours</a><a href="#area"><svg class="ic"><use href="#i-pin"/></svg>Area</a><a href="#contact"><svg class="ic"><use href="#i-chat"/></svg>Contact</a></nav>
    <a class="btn fill" href="tel:+447493041478"><svg class="ic"><use href="#i-phone"/></svg><span>Call Mike</span></a>
    <button class="burger" type="button" aria-expanded="false" aria-controls="menu" aria-label="Menu"><svg class="ic i-bars"><use href="#i-menu"/></svg><svg class="ic i-x"><use href="#i-close"/></svg></button>
  </div>
</header>
<nav class="drawer" id="menu" aria-label="Menu">
  <div class="wrap">
    <a href="#services"><svg class="ic"><use href="#i-roller"/></svg>Services</a>
    <a href="#work"><svg class="ic"><use href="#i-photo"/></svg>Recent work</a>
    <a href="#reviews"><svg class="ic icf"><use href="#i-star"/></svg>Reviews</a>
    <a href="#colour"><svg class="ic"><use href="#i-palette"/></svg>Colours</a>
    <a href="#area"><svg class="ic"><use href="#i-pin"/></svg>Area</a>
    <a href="#contact"><svg class="ic"><use href="#i-chat"/></svg>Contact</a>
    <div class="drawer-cta">
      <a class="btn fill" href="tel:+447493041478"><svg class="ic"><use href="#i-phone"/></svg><span>Call Mike</span></a>
      <a class="btn" href="mailto:mikedodds24@icloud.com"><svg class="ic"><use href="#i-mail"/></svg><span>Email</span></a>
    </div>
  </div>
</nav>

<main id="top">
<div class="hero">
  <svg class="stroke" viewBox="0 0 1000 200" preserveAspectRatio="none" aria-hidden="true">
    <g filter="url(#rough)">
      <path class="s1" pathLength="1" d="M30 120 C 220 50, 400 170, 600 100 S 880 70, 960 110"/>
      <path class="s2" pathLength="1" d="M60 112 C 240 55, 410 160, 600 95 S 870 72, 930 104"/>
    </g>
    <circle class="dot" cx="975" cy="128" r="7"/><circle class="dot" cx="990" cy="96" r="4"/><circle class="dot" cx="955" cy="150" r="5"/>
  </svg>
  <div class="wrap">
    <p class="kick rv"><svg class="ic"><use href="#i-pin"/></svg>Devizes &middot; Wiltshire</p>
    <h1 class="rv" style="--d:.06s"><span class="script">Mike's</span><span class="name caps">Painting &amp; Decorating Services</span></h1>
    <p class="lead rv" style="--d:.12s">A trusted painter and decorator covering Wiltshire, for domestic and commercial work, inside and out.</p>
    <div class="btns rv" style="--d:.18s">
      <a class="btn fill" href="#contact"><span>Ask for a quote</span> <svg class="ic"><use href="#i-arrow"/></svg></a>
      <a class="btn" href="tel:+447493041478"><svg class="ic"><use href="#i-phone"/></svg><span>07493 041478</span></a>
    </div>
    <ul class="badges" data-stagger>
      <li class="rv"><svg class="ic"><use href="#i-home"/></svg>Domestic &amp; commercial</li>
      <li class="rv"><svg class="ic"><use href="#i-roller"/></svg>Interior &amp; exterior</li>
      <li class="rv"><svg class="ic"><use href="#i-pin"/></svg>Based in Devizes</li>
      <li class="rv"><svg class="ic"><use href="#i-check-circle"/></svg>Covering Wiltshire</li>
    </ul>
  </div>
</div>

<div class="ticker" aria-hidden="true">
  <div class="track">
<?php for ($i = 0; $i < 2; $i++): ?>
    <span>Painting &amp; decorating <svg class="ic"><use href="#i-roller"/></svg></span>
    <span>Domestic &amp; commercial <svg class="ic"><use href="#i-home"/></svg></span>
    <span>Colour advice <svg class="ic"><use href="#i-palette"/></svg></span>
    <span>Devizes &amp; Wiltshire <svg class="ic"><use href="#i-pin"/></svg></span>
<?php endfor; ?>
  </div>
</div>

<section id="services">
  <div class="wrap">
    <p class="kick rv"><svg class="ic"><use href="#i-roller"/></svg>What Mike does</p>
    <h2 class="lede rv" style="--d:.06s">Domestic. Commercial. Inside. Out.</h2>
    <p class="sub rv" style="--d:.1s">Four kinds of job, one careful approach to every one of them.</p>
    <div class="grid4" data-stagger>
      <div class="svc rv"><svg class="ic"><use href="#i-roller"/></svg><small>Domestic</small><h3><span>Interior</span></h3><p>Living rooms, bedrooms, hallways and more, freshened up with clean, sharp finishes.</p></div>
      <div class="svc rv"><svg class="ic"><use href="#i-home"/></svg><small>Domestic</small><h3><span>Exterior</span></h3><p>Front doors, porches and outside walls given new colour and lasting protection.</p></div>
      <div class="svc rv"><svg class="ic"><use href="#i-building"/></svg><small>Commercial</small><h3><span>Interior</span></h3><p>Offices, shops and public spaces decorated to a professional standard.</p></div>
      <div class="svc rv"><svg class="ic"><use href="#i-store"/></svg><small>Commercial</small><h3><span>Exterior</span></h3><p>Frontages and external surfaces painted to make the right first impression.</p></div>
    </div>
  </div>
</section>

<?php /* Recent work gallery. Photos, captions and tags live in the $works array at the top of this file. */ ?>
<section id="work">
  <div class="wrap">
    <p class="kick rv"><svg class="ic"><use href="#i-photo"/></svg>Recent work</p>
    <h2 class="lede rv" style="--d:.06s">Jobs Mike has finished lately.</h2>
    <p class="sub rv" style="--d:.1s">Real rooms and real houses, prepped and painted properly. Tap any photo to see it bigger.</p>
    <div class="gal" data-stagger>
<?php foreach ($works as $w): ?>
      <button class="wk rv" type="button" data-src="<?= htmlspecialchars($w['img']) ?>" data-cap="<?= htmlspecialchars($w['cap']) ?>" data-meta="<?= htmlspecialchars($w['meta']) ?>" data-alt="<?= htmlspecialchars($w['alt']) ?>" aria-label="View bigger photo: <?= htmlspecialchars($w['cap']) ?>">
        <span class="wk-media"><img src="<?= htmlspecialchars($w['img']) ?>" alt="<?= htmlspecialchars($w['alt']) ?>" loading="lazy" decoding="async"></span>
        <span class="tag"><svg class="ic"><use href="#<?= $w['icon'] ?>"/></svg><?= htmlspecialchars($w['tag']) ?></span>
        <span class="zoom" aria-hidden="true"><svg class="ic"><use href="#i-zoom"/></svg></span>
        <span class="cap"><strong><?= htmlspecialchars($w['cap']) ?></strong><span><?= htmlspecialchars($w['meta']) ?></span></span>
      </button>
<?php endforeach; ?>
      <a class="wk-cta rv" href="#contact">
        <svg class="ic big-ic"><use href="#i-roller"/></svg>
        <strong>Want walls like these?</strong>
        <p>Ask Mike for a quote and get your room on the list.</p>
        <span class="go">Ask for a quote <svg class="ic"><use href="#i-arrow"/></svg></span>
      </a>
    </div>
  </div>
</section>

<section class="job">
  <div class="wrap cols">
    <div class="rv-l"><p class="kick"><svg class="ic"><use href="#i-roller"/></svg>From Mike's latest job</p><p class="script" style="margin:0">Another very happy customer</p></div>
    <div class="rv-r" style="--d:.1s">
      <blockquote>A family had their master bedroom and lounge freshened up throughout, plus a change to the front entrance porch with some new colour.</blockquote>
      <a class="btn" href="<?= $fb ?>" target="_blank" rel="noopener noreferrer"><svg class="ic icf"><use href="#i-facebook"/></svg><span>See more on Facebook</span></a>
    </div>
  </div>
</section>

<?php /* Reviews. Swap these placeholder quotes for real customer feedback in the $reviews array at the top of this file. */ ?>
<section class="revs" id="reviews">
  <div class="wrap">
    <p class="kick rv"><svg class="ic icf"><use href="#i-star"/></svg>Reviews</p>
    <h2 class="lede rv" style="--d:.06s">Customers say it best.</h2>
    <p class="sub rv" style="--d:.1s">A few words from people Mike has painted and decorated for.</p>
    <div class="revgrid" data-stagger>
<?php foreach ($reviews as $r): ?>
      <figure class="revc rv">
        <svg class="ic icf q" aria-hidden="true"><use href="#i-quote"/></svg>
        <div class="stars" role="img" aria-label="Rated 5 out of 5">
<?php for ($s = 0; $s < 5; $s++): ?>
          <svg class="ic icf" style="--i:<?= $s ?>"><use href="#i-star"/></svg>
<?php endfor; ?>
        </div>
        <blockquote><?= htmlspecialchars($r['q']) ?></blockquote>
        <figcaption><strong><?= htmlspecialchars($r['name']) ?></strong><span><?= htmlspecialchars($r['job']) ?> &middot; <?= htmlspecialchars($r['where']) ?></span></figcaption>
      </figure>
<?php endforeach; ?>
    </div>
    <div class="revfoot rv">
      <a class="btn" href="<?= $fb ?>" target="_blank" rel="noopener noreferrer"><svg class="ic icf"><use href="#i-facebook"/></svg><span>Read more on Facebook</span></a>
      <p>More feedback and photos from recent jobs are posted on Mike's Facebook page.</p>
    </div>
  </div>
</section>

<section class="pick" id="colour">
  <div class="wrap">
    <p class="kick rv"><svg class="ic"><use href="#i-palette"/></svg>Colour advice</p>
    <h2 class="lede rv" style="--d:.06s">Pick a colour, and the page follows.</h2>
    <div class="cols">
      <div class="chip rv-z" aria-hidden="true"><span class="mark"></span></div>
      <div class="rv" style="--d:.1s">
        <p class="pname" id="pname" aria-live="polite">Ink</p>
        <div class="sw" id="sw" role="group" aria-label="Colours"></div>
        <p class="sub" style="margin:0">Not sure which shade suits a room? Mike can talk colours through with you when he quotes.</p>
      </div>
    </div>
  </div>
</section>

<section class="area" id="area">
  <div class="wrap">
    <p class="kick rv"><svg class="ic"><use href="#i-pin"/></svg>Where Mike works</p>
    <div class="cols">
      <h2 class="towns rv-l">Based in Devizes.<i>Covering Wiltshire.</i></h2>
      <p class="sub rv-r" style="margin:0;--d:.08s">Local, trusted and easy to reach. Call or message to check Mike covers your area and to book a quote.</p>
    </div>
  </div>
</section>

<section class="contact" id="contact">
  <div class="wrap cols">
    <div class="rv-l">
      <p class="kick"><svg class="ic"><use href="#i-chat"/></svg>Get in touch</p>
      <h2 class="lede rv" style="--d:.05s">Let's talk paint.</h2>
      <a class="big" href="tel:+447493041478"><svg class="ic"><use href="#i-phone"/></svg><span>07493 041478</span></a>
      <a class="big" href="sms:+447493041478"><svg class="ic"><use href="#i-chat"/></svg><span>Text Mike</span></a>
      <a class="big" href="mailto:mikedodds24@icloud.com"><svg class="ic"><use href="#i-mail"/></svg><span>mikedodds24@icloud.com</span></a>
      <address><svg class="ic"><use href="#i-pin"/></svg>19 Killbrock Mead, Devizes, SN10 2FU</address>
    </div>
    <form class="rv-r" method="post" action="#contact" style="--d:.1s">
      <?php if ($status === 'ok'): ?><p class="note ok" role="status">Thanks, your message has been sent. Mike will be in touch soon.</p>
      <?php elseif ($status === 'missing'): ?><p class="note bad" role="alert">Please add your name and a phone number or email.</p>
      <?php elseif ($status === 'fail'): ?><p class="note bad" role="alert">Sorry, that didn't send. Please call 07493 041478 or email mikedodds24@icloud.com.</p><?php endif; ?>
      <input type="text" name="website" tabindex="-1" autocomplete="off" aria-hidden="true" style="position:absolute;left:-9999px">
      <label>Your name<input name="n" required autocomplete="name" value="<?= $status === 'missing' ? htmlspecialchars($clean($_POST['n'] ?? '')) : '' ?>"></label>
      <label>Phone number<input name="p" type="tel" autocomplete="tel"></label>
      <label>Email (optional if you add a phone number)<input name="e" type="email" autocomplete="email"></label>
      <label>Type of job<select name="t"><option>Domestic interior</option><option>Domestic exterior</option><option>Commercial interior</option><option>Commercial exterior</option><option>Something else</option></select></label>
      <label>Details<textarea name="m" placeholder="Which rooms or areas, and roughly when"></textarea></label>
      <button class="btn fill" type="submit"><svg class="ic"><use href="#i-send"/></svg><span>Send enquiry</span></button>
    </form>
  </div>
</section>
</main>

<footer>
  <div class="wrap">
    <div class="cols">
      <div class="rv">
        <div class="flogo"><img src="images/logo-light.png" alt="Mike's Painting &amp; Decorating Services" width="335" height="155" loading="lazy"></div>
        <nav class="fnav" aria-label="Footer">
          <a href="#services"><svg class="ic"><use href="#i-roller"/></svg>Services</a><a href="#work"><svg class="ic"><use href="#i-photo"/></svg>Recent work</a><a href="#reviews"><svg class="ic icf"><use href="#i-star"/></svg>Reviews</a><a href="#colour"><svg class="ic"><use href="#i-palette"/></svg>Colours</a><a href="#area"><svg class="ic"><use href="#i-pin"/></svg>Area</a><a href="#contact"><svg class="ic"><use href="#i-chat"/></svg>Contact</a>
        </nav>
      </div>
      <div class="fmeta rv" style="--d:.08s">
        <a href="tel:+447493041478"><svg class="ic"><use href="#i-phone"/></svg>07493 041478</a>
        <a href="sms:+447493041478"><svg class="ic"><use href="#i-chat"/></svg>Text Mike</a>
        <a href="mailto:mikedodds24@icloud.com"><svg class="ic"><use href="#i-mail"/></svg>mikedodds24@icloud.com</a>
        <span><svg class="ic"><use href="#i-pin"/></svg>19 Killbrock Mead, Devizes, SN10 2FU</span>
      </div>
      <div class="fmeta rv" style="--d:.16s">
        <a href="<?= $fb ?>" target="_blank" rel="noopener noreferrer"><svg class="ic icf"><use href="#i-facebook"/></svg>Follow on Facebook</a>
      </div>
    </div>
    <div class="fine">
      <span>&copy; <?= date('Y') ?> Mike's Painting and Decorating Services. Devizes, Wiltshire.</span>
      <a href="#top">Back to top <svg class="ic"><use href="#i-arrow-up"/></svg></a>
    </div>
  </div>
</footer>
<button class="totop" type="button" aria-label="Back to top"><svg class="ic"><use href="#i-arrow-up"/></svg></button>

<div class="lb" id="lb" role="dialog" aria-modal="true" aria-label="Recent work photo" aria-hidden="true">
  <button class="x" type="button" id="lbx" aria-label="Close photo"><svg class="ic"><use href="#i-close"/></svg></button>
  <button class="nav prev" type="button" id="lbp" aria-label="Previous photo"><svg class="ic"><use href="#i-left"/></svg></button>
  <figure>
    <img id="lbi" src="" alt="">
    <figcaption id="lbc"><strong></strong><span></span></figcaption>
  </figure>
  <button class="nav next" type="button" id="lbn" aria-label="Next photo"><svg class="ic"><use href="#i-right"/></svg></button>
</div>

<script>
const cols=[["Ink","#141414","#fff"],["Brick","#B5473A","#fff"],["Sage","#6F8F72","#fff"],["Navy","#1F3A5F","#fff"],["Ochre","#D9A02B","#141414"],["Plum","#6B3F69","#fff"],["Teal","#2C7A7B","#fff"],["Rose","#E3A1AA","#141414"]];
const sw=document.getElementById('sw'),pname=document.getElementById('pname'),root=document.documentElement;
cols.forEach(([n,c,on],i)=>{const b=document.createElement('button');b.type='button';b.style.setProperty('--c',c);b.setAttribute('aria-label',n);b.setAttribute('aria-pressed',i==0);
b.onclick=()=>{root.style.setProperty('--acc',c);root.style.setProperty('--on',on);pname.textContent=n;sw.querySelectorAll('button').forEach(x=>x.setAttribute('aria-pressed',x===b));};sw.appendChild(b);});
/* recent work gallery: open a photo in the lightbox */
const tiles=[...document.querySelectorAll('.gal .wk')],lb=document.getElementById('lb');
if(tiles.length&&lb){
  const lbi=document.getElementById('lbi'),lbT=document.querySelector('#lbc strong'),lbM=document.querySelector('#lbc span');
  const lbx=document.getElementById('lbx'),lbp=document.getElementById('lbp'),lbn=document.getElementById('lbn');
  const bg=[...document.querySelectorAll('header.top,.drawer,main,footer,.totop')];
  const canInert='inert' in document.createElement('div');
  let at=0,from=null;
  const show=i=>{
    at=(i+tiles.length)%tiles.length;
    const t=tiles[at];
    lbi.src=t.dataset.src;lbi.alt=t.dataset.alt||t.dataset.cap;
    lbT.textContent=t.dataset.cap;lbM.textContent=t.dataset.meta;
  };
  const openLb=(t,i)=>{from=t;show(i);lb.classList.add('on');lb.setAttribute('aria-hidden','false');
    document.body.style.overflow='hidden';if(canInert)bg.forEach(el=>el.setAttribute('inert',''));lbx.focus();};
  const closeLb=()=>{lb.classList.remove('on');lb.setAttribute('aria-hidden','true');
    document.body.style.overflow='';if(canInert)bg.forEach(el=>el.removeAttribute('inert'));
    lbi.src='';if(from)from.focus();};
  tiles.forEach((t,i)=>t.addEventListener('click',()=>openLb(t,i)));
  lbx.addEventListener('click',closeLb);
  lbp.addEventListener('click',()=>show(at-1));
  lbn.addEventListener('click',()=>show(at+1));
  lb.addEventListener('click',e=>{if(e.target===lb)closeLb()});
  addEventListener('keydown',e=>{
    if(!lb.classList.contains('on'))return;
    if(e.key==='Escape')closeLb();
    else if(e.key==='ArrowLeft')show(at-1);
    else if(e.key==='ArrowRight')show(at+1);
  });
}
/* stagger the children of any [data-stagger] container */
document.querySelectorAll('[data-stagger]').forEach(box=>[...box.children].forEach((el,i)=>el.style.setProperty('--d',(i*.08).toFixed(2)+'s')));

/* reveal on scroll */
const rm=window.matchMedia('(prefers-reduced-motion:reduce)').matches;
const rvs=[...document.querySelectorAll('.rv,.rv-l,.rv-r,.rv-z')];
if('IntersectionObserver' in window){
  let fired=false;
  const io=new IntersectionObserver(es=>{fired=true;es.forEach(e=>{if(e.isIntersecting){e.target.classList.add('in');io.unobserve(e.target)}});},{rootMargin:'0px 0px -8% 0px',threshold:.05});
  rvs.forEach(el=>io.observe(el));
  setTimeout(()=>{if(!fired)rvs.forEach(el=>el.classList.add('in'));},2500);
}else rvs.forEach(el=>el.classList.add('in'));

/* scroll progress, shrinking header, back to top, hero parallax and nav highlight */
const hdr=document.querySelector('header.top'),prog=document.querySelector('.prog'),totop=document.querySelector('.totop');
const heroIn=document.querySelector('.hero .wrap'),stroke=document.querySelector('.hero .stroke');
const navA=[...document.querySelectorAll('header .links a[href^="#"]')],menuA=[...document.querySelectorAll('.drawer a[href^="#"]')];
const secs=[...new Set([...navA,...menuA].map(a=>a.getAttribute('href')))].map(h=>document.querySelector(h)).filter(Boolean);
let queued=false;
function frame(){
  const y=window.pageYOffset||0;
  hdr.classList.toggle('scrolled',y>16);
  prog.style.setProperty('--p',(y/Math.max(1,document.documentElement.scrollHeight-window.innerHeight)).toFixed(4));
  totop.classList.toggle('on',y>window.innerHeight*.8);
  if(!rm&&heroIn){
    const o=Math.max(0,1-y/(window.innerHeight*.9));
    heroIn.style.transform='translate3d(0,'+(y*.13).toFixed(1)+'px,0)';
    heroIn.style.opacity=o.toFixed(3);
    if(stroke)stroke.style.transform='translate3d('+(-y*.05).toFixed(1)+'px,0,0)';
  }
  if(!rm&&tiles.length){
    const vh=window.innerHeight;
    for(const t of tiles){
      const r=t.getBoundingClientRect();
      if(r.bottom<-60||r.top>vh+60)continue;
      const d=(r.top+r.height/2-vh/2)*-.05;
      t.style.setProperty('--py',Math.max(-r.height*.08,Math.min(r.height*.08,d)).toFixed(1)+'px');
    }
  }
  let cur=null;
  secs.forEach(s=>{if(s.getBoundingClientRect().top<=window.innerHeight*.42)cur=s.id});
  [...navA,...menuA].forEach(a=>{
    const on=a.getAttribute('href')==='#'+cur;
    a.classList.toggle('active',on);
    if(on)a.setAttribute('aria-current','true');else a.removeAttribute('aria-current');
  });
  queued=false;
}
function onScroll(){if(!queued){queued=true;requestAnimationFrame(frame)}}
addEventListener('scroll',onScroll,{passive:true});
addEventListener('resize',onScroll);
frame();

/* mobile menu */
const burger=document.querySelector('.burger'),drawer=document.querySelector('.drawer');
function setMenu(open){
  burger.setAttribute('aria-expanded',open?'true':'false');
  drawer.classList.toggle('open',open);
}
burger.addEventListener('click',()=>setMenu(burger.getAttribute('aria-expanded')!=='true'));
drawer.querySelectorAll('a').forEach(a=>a.addEventListener('click',()=>setMenu(false)));
addEventListener('keydown',e=>{if(e.key==='Escape')setMenu(false)});
document.addEventListener('click',e=>{if(burger.getAttribute('aria-expanded')==='true'&&!drawer.contains(e.target)&&!burger.contains(e.target))setMenu(false)});
const wide=window.matchMedia('(min-width:901px)'),onWide=e=>{if(e.matches)setMenu(false)};
wide.addEventListener?wide.addEventListener('change',onWide):wide.addListener(onWide);

/* back to top */
totop.addEventListener('click',()=>window.scrollTo({top:0,behavior:rm?'auto':'smooth'}));
</script>
</body>
</html>