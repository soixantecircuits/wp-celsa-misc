<?php
/*
Plugin Name: FV Simpler SEO
Plugin URI: http://foliovision.com/seo-tools/wordpress/plugins/fv-all-in-one-seo-pack
Description: Simple and effective SEO. Non-invasive, elegant. Ideal for client facing projects. | <a href="options-general.php?page=fv-all-in-one-seo-pack/fv-all-in-one-seo-pack.php">Options configuration panel</a>
Version: 1.6.15
Author: Foliovision
Author URI: http://foliovision.com
*/

$UTF8_TABLES['strtolower'] = array(
	"Ôº∫" => "ÔΩö",	"Ôºπ" => "ÔΩô",	"Ôº∏" => "ÔΩò",
	"Ôº∑" => "ÔΩó",	"Ôº∂" => "ÔΩñ",	"Ôºµ" => "ÔΩï",
	"Ôº¥" => "ÔΩî",	"Ôº≥" => "ÔΩì",	"Ôº≤" => "ÔΩí",
	"Ôº±" => "ÔΩë",	"Ôº∞" => "ÔΩê",	"ÔºØ" => "ÔΩè",
	"ÔºÆ" => "ÔΩé",	"Ôº≠" => "ÔΩç",	"Ôº¨" => "ÔΩå",
	"Ôº´" => "ÔΩã",	"Ôº™" => "ÔΩä",	"Ôº©" => "ÔΩâ",
	"Ôº®" => "ÔΩà",	"Ôºß" => "ÔΩá",	"Ôº¶" => "ÔΩÜ",
	"Ôº•" => "ÔΩÖ",	"Ôº§" => "ÔΩÑ",	"Ôº£" => "ÔΩÉ",
	"Ôº¢" => "ÔΩÇ",	"Ôº°" => "ÔΩÅ",	"‚Ñ´" => "√•",
	"‚Ñ™" => "k",	"‚Ñ¶" => "œâ",	"·øª" => "·ΩΩ",
	"·ø∫" => "·Ωº",	"·øπ" => "·Ωπ",	"·ø∏" => "·Ω∏",
	"·ø¨" => "·ø•",	"·ø´" => "·Ωª",	"·ø™" => "·Ω∫",
	"·ø©" => "·ø°",	"·ø®" => "·ø ",	"·øõ" => "·Ω∑",
	"·øö" => "·Ω∂",	"·øô" => "·øë",	"·øò" => "·øê",
	"·øã" => "·Ωµ",	"·øä" => "·Ω¥",	"·øâ" => "·Ω≥",
	"·øà" => "·Ω≤",	"·æª" => "·Ω±",	"·æ∫" => "·Ω∞",
	"·æπ" => "·æ±",	"·æ∏" => "·æ∞",	"·ΩØ" => "·Ωß",
	"·ΩÆ" => "·Ω¶",	"·Ω≠" => "·Ω•",	"·Ω¨" => "·Ω§",
	"·Ω´" => "·Ω£",	"·Ω™" => "·Ω¢",	"·Ω©" => "·Ω°",
	"·Ω®" => "·Ω ",	"·Ωü" => "·Ωó",	"·Ωù" => "·Ωï",
	"·Ωõ" => "·Ωì",	"·Ωô" => "·Ωë",	"·Ωç" => "·ΩÖ",
	"·Ωå" => "·ΩÑ",	"·Ωã" => "·ΩÉ",	"·Ωä" => "·ΩÇ",
	"·Ωâ" => "·ΩÅ",	"·Ωà" => "·ΩÄ",	"·ºø" => "·º∑",
	"·ºæ" => "·º∂",	"·ºΩ" => "·ºµ",	"·ºº" => "·º¥",
	"·ºª" => "·º≥",	"·º∫" => "·º≤",	"·ºπ" => "·º±",
	"·º∏" => "·º∞",	"·ºØ" => "·ºß",	"·ºÆ" => "·º¶",
	"·º≠" => "·º•",	"·º¨" => "·º§",	"·º´" => "·º£",
	"·º™" => "·º¢",	"·º©" => "·º°",	"·º®" => "·º ",
	"·ºù" => "·ºï",	"·ºú" => "·ºî",	"·ºõ" => "·ºì",
	"·ºö" => "·ºí",	"·ºô" => "·ºë",	"·ºò" => "·ºê",
	"·ºè" => "·ºá",	"·ºé" => "·ºÜ",	"·ºç" => "·ºÖ",
	"·ºå" => "·ºÑ",	"·ºã" => "·ºÉ",	"·ºä" => "·ºÇ",
	"·ºâ" => "·ºÅ",	"·ºà" => "·ºÄ",	"·ª∏" => "·ªπ",
	"·ª∂" => "·ª∑",	"·ª¥" => "·ªµ",	"·ª≤" => "·ª≥",
	"·ª∞" => "·ª±",	"·ªÆ" => "·ªØ",	"·ª¨" => "·ª≠",
	"·ª™" => "·ª´",	"·ª®" => "·ª©",	"·ª¶" => "·ªß",
	"·ª§" => "·ª•",	"·ª¢" => "·ª£",	"·ª " => "·ª°",
	"·ªû" => "·ªü",	"·ªú" => "·ªù",	"·ªö" => "·ªõ",
	"·ªò" => "·ªô",	"·ªñ" => "·ªó",	"·ªî" => "·ªï",
	"·ªí" => "·ªì",	"·ªê" => "·ªë",	"·ªé" => "·ªè",
	"·ªå" => "·ªç",	"·ªä" => "·ªã",	"·ªà" => "·ªâ",
	"·ªÜ" => "·ªá",	"·ªÑ" => "·ªÖ",	"·ªÇ" => "·ªÉ",
	"·ªÄ" => "·ªÅ",	"·∫æ" => "·∫ø",	"·∫º" => "·∫Ω",
	"·∫∫" => "·∫ª",	"·∫∏" => "·∫π",	"·∫∂" => "·∫∑",
	"·∫¥" => "·∫µ",	"·∫≤" => "·∫≥",	"·∫∞" => "·∫±",
	"·∫Æ" => "·∫Ø",	"·∫¨" => "·∫≠",	"·∫™" => "·∫´",
	"·∫®" => "·∫©",	"·∫¶" => "·∫ß",	"·∫§" => "·∫•",
	"·∫¢" => "·∫£",	"·∫ " => "·∫°",	"·∫î" => "·∫ï",
	"·∫í" => "·∫ì",	"·∫ê" => "·∫ë",	"·∫é" => "·∫è",
	"·∫å" => "·∫ç",	"·∫ä" => "·∫ã",	"·∫à" => "·∫â",
	"·∫Ü" => "·∫á",	"·∫Ñ" => "·∫Ö",	"·∫Ç" => "·∫É",
	"·∫Ä" => "·∫Å",	"·πæ" => "·πø",	"·πº" => "·πΩ",
	"·π∫" => "·πª",	"·π∏" => "·ππ",	"·π∂" => "·π∑",
	"·π¥" => "·πµ",	"·π≤" => "·π≥",	"·π∞" => "·π±",
	"·πÆ" => "·πØ",	"·π¨" => "·π≠",	"·π™" => "·π´",
	"·π®" => "·π©",	"·π¶" => "·πß",	"·π§" => "·π•",
	"·π¢" => "·π£",	"·π " => "·π°",	"·πû" => "·πü",
	"·πú" => "·πù",	"·πö" => "·πõ",	"·πò" => "·πô",
	"·πñ" => "·πó",	"·πî" => "·πï",	"·πí" => "·πì",
	"·πê" => "·πë",	"·πé" => "·πè",	"·πå" => "·πç",
	"·πä" => "·πã",	"·πà" => "·πâ",	"·πÜ" => "·πá",
	"·πÑ" => "·πÖ",	"·πÇ" => "·πÉ",	"·πÄ" => "·πÅ",
	"·∏æ" => "·∏ø",	"·∏º" => "·∏Ω",	"·∏∫" => "·∏ª",
	"·∏∏" => "·∏π",	"·∏∂" => "·∏∑",	"·∏¥" => "·∏µ",
	"·∏≤" => "·∏≥",	"·∏∞" => "·∏±",	"·∏Æ" => "·∏Ø",
	"·∏¨" => "·∏≠",	"·∏™" => "·∏´",	"·∏®" => "·∏©",
	"·∏¶" => "·∏ß",	"·∏§" => "·∏•",	"·∏¢" => "·∏£",
	"·∏ " => "·∏°",	"·∏û" => "·∏ü",	"·∏ú" => "·∏ù",
	"·∏ö" => "·∏õ",	"·∏ò" => "·∏ô",	"·∏ñ" => "·∏ó",
	"·∏î" => "·∏ï",	"·∏í" => "·∏ì",	"·∏ê" => "·∏ë",
	"·∏é" => "·∏è",	"·∏å" => "·∏ç",	"·∏ä" => "·∏ã",
	"·∏à" => "·∏â",	"·∏Ü" => "·∏á",	"·∏Ñ" => "·∏Ö",
	"·∏Ç" => "·∏É",	"·∏Ä" => "·∏Å",	"’ñ" => "÷Ü",
	"’ï" => "÷Ö",	"’î" => "÷Ñ",	"’ì" => "÷É",
	"’í" => "÷Ç",	"’ë" => "÷Å",	"’ê" => "÷Ä",
	"’è" => "’ø",	"’é" => "’æ",	"’ç" => "’Ω",
	"’å" => "’º",	"’ã" => "’ª",	"’ä" => "’∫",
	"’â" => "’π",	"’à" => "’∏",	"’á" => "’∑",
	"’Ü" => "’∂",	"’Ö" => "’µ",	"’Ñ" => "’¥",
	"’É" => "’≥",	"’Ç" => "’≤",	"’Å" => "’±",
	"’Ä" => "’∞",	"‘ø" => "’Ø",	"‘æ" => "’Æ",
	"‘Ω" => "’≠",	"‘º" => "’¨",	"‘ª" => "’´",
	"‘∫" => "’™",	"‘π" => "’©",	"‘∏" => "’®",
	"‘∑" => "’ß",	"‘∂" => "’¶",	"‘µ" => "’•",
	"‘¥" => "’§",	"‘≥" => "’£",	"‘≤" => "’¢",
	"‘±" => "’°",	"‘é" => "‘è",	"‘å" => "‘ç",
	"‘ä" => "‘ã",	"‘à" => "‘â",	"‘Ü" => "‘á",
	"‘Ñ" => "‘Ö",	"‘Ç" => "‘É",	"‘Ä" => "‘Å",
	"”∏" => "”π",	"”¥" => "”µ",	"”≤" => "”≥",
	"”∞" => "”±",	"”Æ" => "”Ø",	"”¨" => "”≠",
	"”™" => "”´",	"”®" => "”©",	"”¶" => "”ß",
	"”§" => "”•",	"”¢" => "”£",	"” " => "”°",
	"”û" => "”ü",	"”ú" => "”ù",	"”ö" => "”õ",
	"”ò" => "”ô",	"”ñ" => "”ó",	"”î" => "”ï",
	"”í" => "”ì",	"”ê" => "”ë",	"”ç" => "”é",
	"”ã" => "”å",	"”â" => "”ä",	"”á" => "”à",
	"”Ö" => "”Ü",	"”É" => "”Ñ",	"”Å" => "”Ç",
	"“æ" => "“ø",	"“º" => "“Ω",	"“∫" => "“ª",
	"“∏" => "“π",	"“∂" => "“∑",	"“¥" => "“µ",
	"“≤" => "“≥",	"“∞" => "“±",	"“Æ" => "“Ø",
	"“¨" => "“≠",	"“™" => "“´",	"“®" => "“©",
	"“¶" => "“ß",	"“§" => "“•",	"“¢" => "“£",
	"“ " => "“°",	"“û" => "“ü",	"“ú" => "“ù",
	"“ö" => "“õ",	"“ò" => "“ô",	"“ñ" => "“ó",
	"“î" => "“ï",	"“í" => "“ì",	"“ê" => "“ë",
	"“é" => "“è",	"“å" => "“ç",	"“ä" => "“ã",
	"“Ä" => "“Å",	"—æ" => "—ø",	"—º" => "—Ω",
	"—∫" => "—ª",	"—∏" => "—π",	"—∂" => "—∑",
	"—¥" => "—µ",	"—≤" => "—≥",	"—∞" => "—±",
	"—Æ" => "—Ø",	"—¨" => "—≠",	"—™" => "—´",
	"—®" => "—©",	"—¶" => "—ß",	"—§" => "—•",
	"—¢" => "—£",	"— " => "—°",	"–Ø" => "—è",
	"–Æ" => "—é",	"–≠" => "—ç",	"–¨" => "—å",
	"–´" => "—ã",	"–™" => "—ä",	"–©" => "—â",
	"–®" => "—à",	"–ß" => "—á",	"–¶" => "—Ü",
	"–•" => "—Ö",	"–§" => "—Ñ",	"–£" => "—É",
	"–¢" => "—Ç",	"–°" => "—Å",	"– " => "—Ä",
	"–ü" => "–ø",	"–û" => "–æ",	"–ù" => "–Ω",
	"–ú" => "–º",	"–õ" => "–ª",	"–ö" => "–∫",
	"–ô" => "–π",	"–ò" => "–∏",	"–ó" => "–∑",
	"–ñ" => "–∂",	"–ï" => "–µ",	"–î" => "–¥",
	"–ì" => "–≥",	"–í" => "–≤",	"–ë" => "–±",
	"–ê" => "–∞",	"–è" => "—ü",	"–é" => "—û",
	"–ç" => "—ù",	"–å" => "—ú",	"–ã" => "—õ",
	"–ä" => "—ö",	"–â" => "—ô",	"–à" => "—ò",
	"–á" => "—ó",	"–Ü" => "—ñ",	"–Ö" => "—ï",
	"–Ñ" => "—î",	"–É" => "—ì",	"–Ç" => "—í",
	"–Å" => "—ë",	"–Ä" => "—ê",	"œ¥" => "Œ∏",
	"œÆ" => "œØ",	"œ¨" => "œ≠",	"œ™" => "œ´",
	"œ®" => "œ©",	"œ¶" => "œß",	"œ§" => "œ•",
	"œ¢" => "œ£",	"œ " => "œ°",	"œû" => "œü",
	"œú" => "œù",	"œö" => "œõ",	"œò" => "œô",
	"Œ´" => "œã",	"Œ™" => "œä",	"Œ©" => "œâ",
	"Œ®" => "œà",	"Œß" => "œá",	"Œ¶" => "œÜ",
	"Œ•" => "œÖ",	"Œ§" => "œÑ",	"Œ£" => "œÉ",
	"Œ°" => "œÅ",	"Œ " => "œÄ",	"Œü" => "Œø",
	"Œû" => "Œæ",	"Œù" => "ŒΩ",	"Œú" => "Œº",
	"Œõ" => "Œª",	"Œö" => "Œ∫",	"Œô" => "Œπ",
	"Œò" => "Œ∏",	"Œó" => "Œ∑",	"Œñ" => "Œ∂",
	"Œï" => "Œµ",	"Œî" => "Œ¥",	"Œì" => "Œ≥",
	"Œí" => "Œ≤",	"Œë" => "Œ±",	"Œè" => "œé",
	"Œé" => "œç",	"Œå" => "œå",	"Œä" => "ŒØ",
	"Œâ" => "ŒÆ",	"Œà" => "Œ≠",	"ŒÜ" => "Œ¨",
	"»≤" => "»≥",	"»∞" => "»±",	"»Æ" => "»Ø",
	"»¨" => "»≠",	"»™" => "»´",	"»®" => "»©",
	"»¶" => "»ß",	"»§" => "»•",	"»¢" => "»£",
	"» " => "∆û",	"»û" => "»ü",	"»ú" => "»ù",
	"»ö" => "»õ",	"»ò" => "»ô",	"»ñ" => "»ó",
	"»î" => "»ï",	"»í" => "»ì",	"»ê" => "»ë",
	"»é" => "»è",	"»å" => "»ç",	"»ä" => "»ã",
	"»à" => "»â",	"»Ü" => "»á",	"»Ñ" => "»Ö",
	"»Ç" => "»É",	"»Ä" => "»Å",	"«æ" => "«ø",
	"«º" => "«Ω",	"«∫" => "«ª",	"«∏" => "«π",
	"«∑" => "∆ø",	"«∂" => "∆ï",	"«¥" => "«µ",
	"«±" => "«≥",	"«Æ" => "«Ø",	"«¨" => "«≠",
	"«™" => "«´",	"«®" => "«©",	"«¶" => "«ß",
	"«§" => "«•",	"«¢" => "«£",	"« " => "«°",
	"«û" => "«ü",	"«õ" => "«ú",	"«ô" => "«ö",
	"«ó" => "«ò",	"«ï" => "«ñ",	"«ì" => "«î",
	"«ë" => "«í",	"«è" => "«ê",	"«ç" => "«é",
	"«ä" => "«å",	"«á" => "«â",	"«Ñ" => "«Ü",
	"∆º" => "∆Ω",	"∆∏" => "∆π",	"∆∑" => " í",
	"∆µ" => "∆∂",	"∆≥" => "∆¥",	"∆≤" => " ã",
	"∆±" => " ä",	"∆Ø" => "∆∞",	"∆Æ" => " à",
	"∆¨" => "∆≠",	"∆©" => " É",	"∆ß" => "∆®",
	"∆¶" => " Ä",	"∆§" => "∆•",	"∆¢" => "∆£",
	"∆ " => "∆°",	"∆ü" => "…µ",	"∆ù" => "…≤",
	"∆ú" => "…Ø",	"∆ò" => "∆ô",	"∆ó" => "…®",
	"∆ñ" => "…©",	"∆î" => "…£",	"∆ì" => "… ",
	"∆ë" => "∆í",	"∆ê" => "…õ",	"∆è" => "…ô",
	"∆é" => "«ù",	"∆ã" => "∆å",	"∆ä" => "…ó",
	"∆â" => "…ñ",	"∆á" => "∆à",	"∆Ü" => "…î",
	"∆Ñ" => "∆Ö",	"∆Ç" => "∆É",	"∆Å" => "…ì",
	"≈Ω" => "≈æ",	"≈ª" => "≈º",	"≈π" => "≈∫",
	"≈∏" => "√ø",	"≈∂" => "≈∑",	"≈¥" => "≈µ",
	"≈≤" => "≈≥",	"≈∞" => "≈±",	"≈Æ" => "≈Ø",
	"≈¨" => "≈≠",	"≈™" => "≈´",	"≈®" => "≈©",
	"≈¶" => "≈ß",	"≈§" => "≈•",	"≈¢" => "≈£",
	"≈ " => "≈°",	"≈û" => "≈ü",	"≈ú" => "≈ù",
	"≈ö" => "≈õ",	"≈ò" => "≈ô",	"≈ñ" => "≈ó",
	"≈î" => "≈ï",	"≈í" => "≈ì",	"≈ê" => "≈ë",
	"≈é" => "≈è",	"≈å" => "≈ç",	"≈ä" => "≈ã",
	"≈á" => "≈à",	"≈Ö" => "≈Ü",	"≈É" => "≈Ñ",
	"≈Å" => "≈Ç",	"ƒø" => "≈Ä",	"ƒΩ" => "ƒæ",
	"ƒª" => "ƒº",	"ƒπ" => "ƒ∫",	"ƒ∂" => "ƒ∑",
	"ƒ¥" => "ƒµ",	"ƒ≤" => "ƒ≥",	"ƒ∞" => "i",
	"ƒÆ" => "ƒØ",	"ƒ¨" => "ƒ≠",	"ƒ™" => "ƒ´",
	"ƒ®" => "ƒ©",	"ƒ¶" => "ƒß",	"ƒ§" => "ƒ•",
	"ƒ¢" => "ƒ£",	"ƒ " => "ƒ°",	"ƒû" => "ƒü",
	"ƒú" => "ƒù",	"ƒö" => "ƒõ",	"ƒò" => "ƒô",
	"ƒñ" => "ƒó",	"ƒî" => "ƒï",	"ƒí" => "ƒì",
	"ƒê" => "ƒë",	"ƒé" => "ƒè",	"ƒå" => "ƒç",
	"ƒä" => "ƒã",	"ƒà" => "ƒâ",	"ƒÜ" => "ƒá",
	"ƒÑ" => "ƒÖ",	"ƒÇ" => "ƒÉ",	"ƒÄ" => "ƒÅ",
	"√û" => "√æ",	"√ù" => "√Ω",	"√ú" => "√º",
	"√õ" => "√ª",	"√ö" => "√∫",	"√ô" => "√π",
	"√ò" => "√∏",	"√ñ" => "√∂",	"√ï" => "√µ",
	"√î" => "√¥",	"√ì" => "√≥",	"√í" => "√≤",
	"√ë" => "√±",	"√ê" => "√∞",	"√è" => "√Ø",
	"√é" => "√Æ",	"√ç" => "√≠",	"√å" => "√¨",
	"√ã" => "√´",	"√ä" => "√™",	"√â" => "√©",
	"√à" => "√®",	"√á" => "√ß",	"√Ü" => "√¶",
	"√Ö" => "√•",	"√Ñ" => "√§",	"√É" => "√£",
	"√Ç" => "√¢",	"√Å" => "√°",	"√Ä" => "√ ",
	"Z" => "z",		"Y" => "y",		"X" => "x",
	"W" => "w",		"V" => "v",		"U" => "u",
	"T" => "t",		"S" => "s",		"R" => "r",
	"Q" => "q",		"P" => "p",		"O" => "o",
	"N" => "n",		"M" => "m",		"L" => "l",
	"K" => "k",		"J" => "j",		"I" => "i",
	"H" => "h",		"G" => "g",		"F" => "f",
	"E" => "e",		"D" => "d",		"C" => "c",
	"B" => "b",		"A" => "a",
);


$UTF8_TABLES['strtoupper'] = array(
	"ÔΩö" => "Ôº∫",	"ÔΩô" => "Ôºπ",	"ÔΩò" => "Ôº∏",
	"ÔΩó" => "Ôº∑",	"ÔΩñ" => "Ôº∂",	"ÔΩï" => "Ôºµ",
	"ÔΩî" => "Ôº¥",	"ÔΩì" => "Ôº≥",	"ÔΩí" => "Ôº≤",
	"ÔΩë" => "Ôº±",	"ÔΩê" => "Ôº∞",	"ÔΩè" => "ÔºØ",
	"ÔΩé" => "ÔºÆ",	"ÔΩç" => "Ôº≠",	"ÔΩå" => "Ôº¨",
	"ÔΩã" => "Ôº´",	"ÔΩä" => "Ôº™",	"ÔΩâ" => "Ôº©",
	"ÔΩà" => "Ôº®",	"ÔΩá" => "Ôºß",	"ÔΩÜ" => "Ôº¶",
	"ÔΩÖ" => "Ôº•",	"ÔΩÑ" => "Ôº§",	"ÔΩÉ" => "Ôº£",
	"ÔΩÇ" => "Ôº¢",	"ÔΩÅ" => "Ôº°",	"·ø≥" => "·øº",
	"·ø•" => "·ø¨",	"·ø°" => "·ø©",	"·ø " => "·ø®",
	"·øë" => "·øô",	"·øê" => "·øò",	"·øÉ" => "·øå",
	"·ææ" => "Œô",	"·æ≥" => "·æº",	"·æ±" => "·æπ",
	"·æ∞" => "·æ∏",	"·æß" => "·æØ",	"·æ¶" => "·æÆ",
	"·æ•" => "·æ≠",	"·æ§" => "·æ¨",	"·æ£" => "·æ´",
	"·æ¢" => "·æ™",	"·æ°" => "·æ©",	"·æ " => "·æ®",
	"·æó" => "·æü",	"·æñ" => "·æû",	"·æï" => "·æù",
	"·æî" => "·æú",	"·æì" => "·æõ",	"·æí" => "·æö",
	"·æë" => "·æô",	"·æê" => "·æò",	"·æá" => "·æè",
	"·æÜ" => "·æé",	"·æÖ" => "·æç",	"·æÑ" => "·æå",
	"·æÉ" => "·æã",	"·æÇ" => "·æä",	"·æÅ" => "·æâ",
	"·æÄ" => "·æà",	"·ΩΩ" => "·øª",	"·Ωº" => "·ø∫",
	"·Ωª" => "·ø´",	"·Ω∫" => "·ø™",	"·Ωπ" => "·øπ",
	"·Ω∏" => "·ø∏",	"·Ω∑" => "·øõ",	"·Ω∂" => "·øö",
	"·Ωµ" => "·øã",	"·Ω¥" => "·øä",	"·Ω≥" => "·øâ",
	"·Ω≤" => "·øà",	"·Ω±" => "·æª",	"·Ω∞" => "·æ∫",
	"·Ωß" => "·ΩØ",	"·Ω¶" => "·ΩÆ",	"·Ω•" => "·Ω≠",
	"·Ω§" => "·Ω¨",	"·Ω£" => "·Ω´",	"·Ω¢" => "·Ω™",
	"·Ω°" => "·Ω©",	"·Ω " => "·Ω®",	"·Ωó" => "·Ωü",
	"·Ωï" => "·Ωù",	"·Ωì" => "·Ωõ",	"·Ωë" => "·Ωô",
	"·ΩÖ" => "·Ωç",	"·ΩÑ" => "·Ωå",	"·ΩÉ" => "·Ωã",
	"·ΩÇ" => "·Ωä",	"·ΩÅ" => "·Ωâ",	"·ΩÄ" => "·Ωà",
	"·º∑" => "·ºø",	"·º∂" => "·ºæ",	"·ºµ" => "·ºΩ",
	"·º¥" => "·ºº",	"·º≥" => "·ºª",	"·º≤" => "·º∫",
	"·º±" => "·ºπ",	"·º∞" => "·º∏",	"·ºß" => "·ºØ",
	"·º¶" => "·ºÆ",	"·º•" => "·º≠",	"·º§" => "·º¨",
	"·º£" => "·º´",	"·º¢" => "·º™",	"·º°" => "·º©",
	"·º " => "·º®",	"·ºï" => "·ºù",	"·ºî" => "·ºú",
	"·ºì" => "·ºõ",	"·ºí" => "·ºö",	"·ºë" => "·ºô",
	"·ºê" => "·ºò",	"·ºá" => "·ºè",	"·ºÜ" => "·ºé",
	"·ºÖ" => "·ºç",	"·ºÑ" => "·ºå",	"·ºÉ" => "·ºã",
	"·ºÇ" => "·ºä",	"·ºÅ" => "·ºâ",	"·ºÄ" => "·ºà",
	"·ªπ" => "·ª∏",	"·ª∑" => "·ª∂",	"·ªµ" => "·ª¥",
	"·ª≥" => "·ª≤",	"·ª±" => "·ª∞",	"·ªØ" => "·ªÆ",
	"·ª≠" => "·ª¨",	"·ª´" => "·ª™",	"·ª©" => "·ª®",
	"·ªß" => "·ª¶",	"·ª•" => "·ª§",	"·ª£" => "·ª¢",
	"·ª°" => "·ª ",	"·ªü" => "·ªû",	"·ªù" => "·ªú",
	"·ªõ" => "·ªö",	"·ªô" => "·ªò",	"·ªó" => "·ªñ",
	"·ªï" => "·ªî",	"·ªì" => "·ªí",	"·ªë" => "·ªê",
	"·ªè" => "·ªé",	"·ªç" => "·ªå",	"·ªã" => "·ªä",
	"·ªâ" => "·ªà",	"·ªá" => "·ªÜ",	"·ªÖ" => "·ªÑ",
	"·ªÉ" => "·ªÇ",	"·ªÅ" => "·ªÄ",	"·∫ø" => "·∫æ",
	"·∫Ω" => "·∫º",	"·∫ª" => "·∫∫",	"·∫π" => "·∫∏",
	"·∫∑" => "·∫∂",	"·∫µ" => "·∫¥",	"·∫≥" => "·∫≤",
	"·∫±" => "·∫∞",	"·∫Ø" => "·∫Æ",	"·∫≠" => "·∫¨",
	"·∫´" => "·∫™",	"·∫©" => "·∫®",	"·∫ß" => "·∫¶",
	"·∫•" => "·∫§",	"·∫£" => "·∫¢",	"·∫°" => "·∫ ",
	"·∫õ" => "·π ",	"·∫ï" => "·∫î",	"·∫ì" => "·∫í",
	"·∫ë" => "·∫ê",	"·∫è" => "·∫é",	"·∫ç" => "·∫å",
	"·∫ã" => "·∫ä",	"·∫â" => "·∫à",	"·∫á" => "·∫Ü",
	"·∫Ö" => "·∫Ñ",	"·∫É" => "·∫Ç",	"·∫Å" => "·∫Ä",
	"·πø" => "·πæ",	"·πΩ" => "·πº",	"·πª" => "·π∫",
	"·ππ" => "·π∏",	"·π∑" => "·π∂",	"·πµ" => "·π¥",
	"·π≥" => "·π≤",	"·π±" => "·π∞",	"·πØ" => "·πÆ",
	"·π≠" => "·π¨",	"·π´" => "·π™",	"·π©" => "·π®",
	"·πß" => "·π¶",	"·π•" => "·π§",	"·π£" => "·π¢",
	"·π°" => "·π ",	"·πü" => "·πû",	"·πù" => "·πú",
	"·πõ" => "·πö",	"·πô" => "·πò",	"·πó" => "·πñ",
	"·πï" => "·πî",	"·πì" => "·πí",	"·πë" => "·πê",
	"·πè" => "·πé",	"·πç" => "·πå",	"·πã" => "·πä",
	"·πâ" => "·πà",	"·πá" => "·πÜ",	"·πÖ" => "·πÑ",
	"·πÉ" => "·πÇ",	"·πÅ" => "·πÄ",	"·∏ø" => "·∏æ",
	"·∏Ω" => "·∏º",	"·∏ª" => "·∏∫",	"·∏π" => "·∏∏",
	"·∏∑" => "·∏∂",	"·∏µ" => "·∏¥",	"·∏≥" => "·∏≤",
	"·∏±" => "·∏∞",	"·∏Ø" => "·∏Æ",	"·∏≠" => "·∏¨",
	"·∏´" => "·∏™",	"·∏©" => "·∏®",	"·∏ß" => "·∏¶",
	"·∏•" => "·∏§",	"·∏£" => "·∏¢",	"·∏°" => "·∏ ",
	"·∏ü" => "·∏û",	"·∏ù" => "·∏ú",	"·∏õ" => "·∏ö",
	"·∏ô" => "·∏ò",	"·∏ó" => "·∏ñ",	"·∏ï" => "·∏î",
	"·∏ì" => "·∏í",	"·∏ë" => "·∏ê",	"·∏è" => "·∏é",
	"·∏ç" => "·∏å",	"·∏ã" => "·∏ä",	"·∏â" => "·∏à",
	"·∏á" => "·∏Ü",	"·∏Ö" => "·∏Ñ",	"·∏É" => "·∏Ç",
	"·∏Å" => "·∏Ä",	"÷Ü" => "’ñ",	"÷Ö" => "’ï",
	"÷Ñ" => "’î",	"÷É" => "’ì",	"÷Ç" => "’í",
	"÷Å" => "’ë",	"÷Ä" => "’ê",	"’ø" => "’è",
	"’æ" => "’é",	"’Ω" => "’ç",	"’º" => "’å",
	"’ª" => "’ã",	"’∫" => "’ä",	"’π" => "’â",
	"’∏" => "’à",	"’∑" => "’á",	"’∂" => "’Ü",
	"’µ" => "’Ö",	"’¥" => "’Ñ",	"’≥" => "’É",
	"’≤" => "’Ç",	"’±" => "’Å",	"’∞" => "’Ä",
	"’Ø" => "‘ø",	"’Æ" => "‘æ",	"’≠" => "‘Ω",
	"’¨" => "‘º",	"’´" => "‘ª",	"’™" => "‘∫",
	"’©" => "‘π",	"’®" => "‘∏",	"’ß" => "‘∑",
	"’¶" => "‘∂",	"’•" => "‘µ",	"’§" => "‘¥",
	"’£" => "‘≥",	"’¢" => "‘≤",	"’°" => "‘±",
	"‘è" => "‘é",	"‘ç" => "‘å",	"‘ã" => "‘ä",
	"‘â" => "‘à",	"‘á" => "‘Ü",	"‘Ö" => "‘Ñ",
	"‘É" => "‘Ç",	"‘Å" => "‘Ä",	"”π" => "”∏",
	"”µ" => "”¥",	"”≥" => "”≤",	"”±" => "”∞",
	"”Ø" => "”Æ",	"”≠" => "”¨",	"”´" => "”™",
	"”©" => "”®",	"”ß" => "”¶",	"”•" => "”§",
	"”£" => "”¢",	"”°" => "” ",	"”ü" => "”û",
	"”ù" => "”ú",	"”õ" => "”ö",	"”ô" => "”ò",
	"”ó" => "”ñ",	"”ï" => "”î",	"”ì" => "”í",
	"”ë" => "”ê",	"”é" => "”ç",	"”å" => "”ã",
	"”ä" => "”â",	"”à" => "”á",	"”Ü" => "”Ö",
	"”Ñ" => "”É",	"”Ç" => "”Å",	"“ø" => "“æ",
	"“Ω" => "“º",	"“ª" => "“∫",	"“π" => "“∏",
	"“∑" => "“∂",	"“µ" => "“¥",	"“≥" => "“≤",
	"“±" => "“∞",	"“Ø" => "“Æ",	"“≠" => "“¨",
	"“´" => "“™",	"“©" => "“®",	"“ß" => "“¶",
	"“•" => "“§",	"“£" => "“¢",	"“°" => "“ ",
	"“ü" => "“û",	"“ù" => "“ú",	"“õ" => "“ö",
	"“ô" => "“ò",	"“ó" => "“ñ",	"“ï" => "“î",
	"“ì" => "“í",	"“ë" => "“ê",	"“è" => "“é",
	"“ç" => "“å",	"“ã" => "“ä",	"“Å" => "“Ä",
	"—ø" => "—æ",	"—Ω" => "—º",	"—ª" => "—∫",
	"—π" => "—∏",	"—∑" => "—∂",	"—µ" => "—¥",
	"—≥" => "—≤",	"—±" => "—∞",	"—Ø" => "—Æ",
	"—≠" => "—¨",	"—´" => "—™",	"—©" => "—®",
	"—ß" => "—¶",	"—•" => "—§",	"—£" => "—¢",
	"—°" => "— ",	"—ü" => "–è",	"—û" => "–é",
	"—ù" => "–ç",	"—ú" => "–å",	"—õ" => "–ã",
	"—ö" => "–ä",	"—ô" => "–â",	"—ò" => "–à",
	"—ó" => "–á",	"—ñ" => "–Ü",	"—ï" => "–Ö",
	"—î" => "–Ñ",	"—ì" => "–É",	"—í" => "–Ç",
	"—ë" => "–Å",	"—ê" => "–Ä",	"—è" => "–Ø",
	"—é" => "–Æ",	"—ç" => "–≠",	"—å" => "–¨",
	"—ã" => "–´",	"—ä" => "–™",	"—â" => "–©",
	"—à" => "–®",	"—á" => "–ß",	"—Ü" => "–¶",
	"—Ö" => "–•",	"—Ñ" => "–§",	"—É" => "–£",
	"—Ç" => "–¢",	"—Å" => "–°",	"—Ä" => "– ",
	"–ø" => "–ü",	"–æ" => "–û",	"–Ω" => "–ù",
	"–º" => "–ú",	"–ª" => "–õ",	"–∫" => "–ö",
	"–π" => "–ô",	"–∏" => "–ò",	"–∑" => "–ó",
	"–∂" => "–ñ",	"–µ" => "–ï",	"–¥" => "–î",
	"–≥" => "–ì",	"–≤" => "–í",	"–±" => "–ë",
	"–∞" => "–ê",	"œµ" => "Œï",	"œ≤" => "Œ£",
	"œ±" => "Œ°",	"œ∞" => "Œö",	"œØ" => "œÆ",
	"œ≠" => "œ¨",	"œ´" => "œ™",	"œ©" => "œ®",
	"œß" => "œ¶",	"œ•" => "œ§",	"œ£" => "œ¢",
	"œ°" => "œ ",	"œü" => "œû",	"œù" => "œú",
	"œõ" => "œö",	"œô" => "œò",	"œñ" => "Œ ",
	"œï" => "Œ¶",	"œë" => "Œò",	"œê" => "Œí",
	"œé" => "Œè",	"œç" => "Œé",	"œå" => "Œå",
	"œã" => "Œ´",	"œä" => "Œ™",	"œâ" => "Œ©",
	"œà" => "Œ®",	"œá" => "Œß",	"œÜ" => "Œ¶",
	"œÖ" => "Œ•",	"œÑ" => "Œ§",	"œÉ" => "Œ£",
	"œÇ" => "Œ£",	"œÅ" => "Œ°",	"œÄ" => "Œ ",
	"Œø" => "Œü",	"Œæ" => "Œû",	"ŒΩ" => "Œù",
	"Œº" => "Œú",	"Œª" => "Œõ",	"Œ∫" => "Œö",
	"Œπ" => "Œô",	"Œ∏" => "Œò",	"Œ∑" => "Œó",
	"Œ∂" => "Œñ",	"Œµ" => "Œï",	"Œ¥" => "Œî",
	"Œ≥" => "Œì",	"Œ≤" => "Œí",	"Œ±" => "Œë",
	"ŒØ" => "Œä",	"ŒÆ" => "Œâ",	"Œ≠" => "Œà",
	"Œ¨" => "ŒÜ",	" í" => "∆∑",	" ã" => "∆≤",
	" ä" => "∆±",	" à" => "∆Æ",	" É" => "∆©",
	" Ä" => "∆¶",	"…µ" => "∆ü",	"…≤" => "∆ù",
	"…Ø" => "∆ú",	"…©" => "∆ñ",	"…®" => "∆ó",
	"…£" => "∆î",	"… " => "∆ì",	"…õ" => "∆ê",
	"…ô" => "∆è",	"…ó" => "∆ä",	"…ñ" => "∆â",
	"…î" => "∆Ü",	"…ì" => "∆Å",	"»≥" => "»≤",
	"»±" => "»∞",	"»Ø" => "»Æ",	"»≠" => "»¨",
	"»´" => "»™",	"»©" => "»®",	"»ß" => "»¶",
	"»•" => "»§",	"»£" => "»¢",	"»ü" => "»û",
	"»ù" => "»ú",	"»õ" => "»ö",	"»ô" => "»ò",
	"»ó" => "»ñ",	"»ï" => "»î",	"»ì" => "»í",
	"»ë" => "»ê",	"»è" => "»é",	"»ç" => "»å",
	"»ã" => "»ä",	"»â" => "»à",	"»á" => "»Ü",
	"»Ö" => "»Ñ",	"»É" => "»Ç",	"»Å" => "»Ä",
	"«ø" => "«æ",	"«Ω" => "«º",	"«ª" => "«∫",
	"«π" => "«∏",	"«µ" => "«¥",	"«≥" => "«≤",
	"«Ø" => "«Æ",	"«≠" => "«¨",	"«´" => "«™",
	"«©" => "«®",	"«ß" => "«¶",	"«•" => "«§",
	"«£" => "«¢",	"«°" => "« ",	"«ü" => "«û",
	"«ù" => "∆é",	"«ú" => "«õ",	"«ö" => "«ô",
	"«ò" => "«ó",	"«ñ" => "«ï",	"«î" => "«ì",
	"«í" => "«ë",	"«ê" => "«è",	"«é" => "«ç",
	"«å" => "«ã",	"«â" => "«à",	"«Ü" => "«Ö",
	"∆ø" => "«∑",	"∆Ω" => "∆º",	"∆π" => "∆∏",
	"∆∂" => "∆µ",	"∆¥" => "∆≥",	"∆∞" => "∆Ø",
	"∆≠" => "∆¨",	"∆®" => "∆ß",	"∆•" => "∆§",
	"∆£" => "∆¢",	"∆°" => "∆ ",	"∆û" => "» ",
	"∆ô" => "∆ò",	"∆ï" => "«∂",	"∆í" => "∆ë",
	"∆å" => "∆ã",	"∆à" => "∆á",	"∆Ö" => "∆Ñ",
	"∆É" => "∆Ç",	"≈ø" => "S",	"≈æ" => "≈Ω",
	"≈º" => "≈ª",	"≈∫" => "≈π",	"≈∑" => "≈∂",
	"≈µ" => "≈¥",	"≈≥" => "≈≤",	"≈±" => "≈∞",
	"≈Ø" => "≈Æ",	"≈≠" => "≈¨",	"≈´" => "≈™",
	"≈©" => "≈®",	"≈ß" => "≈¶",	"≈•" => "≈§",
	"≈£" => "≈¢",	"≈°" => "≈ ",	"≈ü" => "≈û",
	"≈ù" => "≈ú",	"≈õ" => "≈ö",	"≈ô" => "≈ò",
	"≈ó" => "≈ñ",	"≈ï" => "≈î",	"≈ì" => "≈í",
	"≈ë" => "≈ê",	"≈è" => "≈é",	"≈ç" => "≈å",
	"≈ã" => "≈ä",	"≈à" => "≈á",	"≈Ü" => "≈Ö",
	"≈Ñ" => "≈É",	"≈Ç" => "≈Å",	"≈Ä" => "ƒø",
	"ƒæ" => "ƒΩ",	"ƒº" => "ƒª",	"ƒ∫" => "ƒπ",
	"ƒ∑" => "ƒ∂",	"ƒµ" => "ƒ¥",	"ƒ≥" => "ƒ≤",
	"ƒ±" => "I",	"ƒØ" => "ƒÆ",	"ƒ≠" => "ƒ¨",
	"ƒ´" => "ƒ™",	"ƒ©" => "ƒ®",	"ƒß" => "ƒ¶",
	"ƒ•" => "ƒ§",	"ƒ£" => "ƒ¢",	"ƒ°" => "ƒ ",
	"ƒü" => "ƒû",	"ƒù" => "ƒú",	"ƒõ" => "ƒö",
	"ƒô" => "ƒò",	"ƒó" => "ƒñ",	"ƒï" => "ƒî",
	"ƒì" => "ƒí",	"ƒë" => "ƒê",	"ƒè" => "ƒé",
	"ƒç" => "ƒå",	"ƒã" => "ƒä",	"ƒâ" => "ƒà",
	"ƒá" => "ƒÜ",	"ƒÖ" => "ƒÑ",	"ƒÉ" => "ƒÇ",
	"ƒÅ" => "ƒÄ",	"√ø" => "≈∏",	"√æ" => "√û",
	"√Ω" => "√ù",	"√º" => "√ú",	"√ª" => "√õ",
	"√∫" => "√ö",	"√π" => "√ô",	"√∏" => "√ò",
	"√∂" => "√ñ",	"√µ" => "√ï",	"√¥" => "√î",
	"√≥" => "√ì",	"√≤" => "√í",	"√±" => "√ë",
	"√∞" => "√ê",	"√Ø" => "√è",	"√Æ" => "√é",
	"√≠" => "√ç",	"√¨" => "√å",	"√´" => "√ã",
	"√™" => "√ä",	"√©" => "√â",	"√®" => "√à",
	"√ß" => "√á",	"√¶" => "√Ü",	"√•" => "√Ö",
	"√§" => "√Ñ",	"√£" => "√É",	"√¢" => "√Ç",
	"√°" => "√Å",	"√ " => "√Ä",	"¬µ" => "Œú",
	"z" => "Z",		"y" => "Y",		"x" => "X",
	"w" => "W",		"v" => "V",		"u" => "U",
	"t" => "T",		"s" => "S",		"r" => "R",
	"q" => "Q",		"p" => "P",		"o" => "O",
	"n" => "N",		"m" => "M",		"l" => "L",
	"k" => "K",		"j" => "J",		"i" => "I",
	"h" => "H",		"g" => "G",		"f" => "F",
	"e" => "E",		"d" => "D",		"c" => "C",
	"b" => "B",		"a" => "A",
);


class FV_Simpler_SEO_Pack
{
	//-------------------------------
	// FIELDS
	//-------------------------------

	/** Max numbers of chars in auto-generated description */
	//var $maximum_description_length = 160;
	var $maximum_description_length = 145;
	
	var $maximum_description_length_yellow = 134;
	//var $maximum_title_length = 61;
	var $maximum_title_length = 56;
 	
	/** Minimum number of chars an excerpt should be so that it can be used
	 * as description. Touch only if you know what you're doing
	 */
	var $minimum_description_length = 1;

	//-------------------------------
	// CONSTRUCTORSaioseop_
	//-------------------------------

	/**
	 * Constructor.
	 */
	function FV_Simpler_SEO_Pack()
	{
		global $fvseop_options;
	}
	
	//-------------------------------
	// UTILS
	//-------------------------------

	/**      
	 * Convert a string to lower case.
	 * Originally, this function relied their functionality in a global UTF-8 character table.
	 * I will take my chances with a standard function.
	 * 
	 * Update March 11, 2010: Well, the standard function is not working on some hosts. There's a check for it before this code is used.
	 */
	function strtolower($str)
	{
		global $UTF8_TABLES;
    return strtr($str, $UTF8_TABLES['strtolower']);
		///return mb_strtolower($str, 'UTF-8');
	}

	/**      
	 * Convert a string to upper case.
	 * Originally, this function relied their functionality in a global UTF-8 character table.
	 * I will take my chances with a standard function.
	 *
	 * Update March 11, 2010: Well, the standard function is not working on some hosts. There's a check for it before this code is used.
	 */
	function strtoupper($str)
	{
		global $UTF8_TABLES;
    return strtr($str, $UTF8_TABLES['strtoupper']);
		///return mb_strtoupper($str, 'UTF-8');
	}

	/**
	 * Make a string's first character uppercase.
	 */
	function capitalize($s)
	{
		$s = trim($s);
    $tokens = explode(' ', $s);
    while (list($key, $val) = each($tokens)) {
            $tokens[$key] = trim($tokens[$key]);
            $tokens[$key] = strtoupper(substr($tokens[$key], 0, 1)) . substr($tokens[$key], 1);
    }
    $s = implode(' ', $tokens);
    return $s;
		///return mb_convert_case($s, MB_CASE_TITLE, 'UTF-8');
	}
	
	function is_static_front_page()
	{
		global $wp_query;
		
		$post = $wp_query->get_queried_object();
		
		return get_option('show_on_front') == 'page' && is_page() && $post->ID == get_option('page_on_front');
	}
	
	function is_static_posts_page()
	{
		global $wp_query;
		
		$post = $wp_query->get_queried_object();
		
		return get_option('show_on_front') == 'page' && is_home() && $post->ID == get_option('page_for_posts');
	}

	/**
	 * This function detects if a given request contains the name of an excluded page.
	 */
	function fvseop_mrt_exclude_this_page()
	{
		global $fvseop_options;

		$currenturl = trim(esc_url($_SERVER['REQUEST_URI'], '/'));

    if( isset($fvseop_options['aiosp_ex_pages']) ) {
  		$excludedstuff = explode(',', $fvseop_options['aiosp_ex_pages']);
  		foreach ($excludedstuff as $exedd)
  		{
  			$exedd = trim($exedd);
  
  			if ($exedd)
  			{
  				if (stristr($currenturl, $exedd))
  				{
  					return true;
  				}
  			}
  		}
    }

		return false;
	}
	
	function output_callback_for_title($content)
	{
		return $this->rewrite_title($content);
	}

	/**
	 * TODO: This function seems to translate the text to the current language.
	 * Actually I don't have any insight that this is really effective.
	 */
	function internationalize($in)
	{
		if (function_exists('langswitch_filter_langs_with_message'))
		{
			$in = langswitch_filter_langs_with_message($in);
		}

		if (function_exists('polyglot_filter'))
		{
			$in = polyglot_filter($in);
		}

		if (function_exists('qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage'))
		{
			$in = qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage($in);
		}

		$in = apply_filters('localization', $in);

		return $in;
	}

	//-------------------------------
	// ACTIONS
	//-------------------------------

	/**
	 * Runs after WordPress admin has finished loading but before any headers are sent.
	 * Useful for intercepting $_GET or $_POST triggers. 
	 */
	function init()
	{
		// Loads the plugin's translated strings. 
		load_plugin_textdomain('fv_seo', false, dirname(plugin_basename(__FILE__)));
	}
	
	function remove_canonical() {
	  if (is_single() || is_page() || $this->is_static_posts_page()) {
	    global $wp_query, $fvseop_options;
		  $post = $wp_query->get_queried_object();
		
  	  $custom_canonical = trim( get_post_meta($post->ID, "_aioseop_custom_canonical", true) );
  		if( $custom_canonical && $fvseop_options['aiosp_show_custom_canonical'] ) {
  		  remove_action('wp_head', 'rel_canonical');
  		}
	  }
	}

	/**
	 * Runs before the determination of the template file to be used to display the requested page,
	 * so that a plugin can override the template file choice.
	 *
	 * Used in this case for title rewrite.
	 */
	function template_redirect()
	{
		global $wp_query;
		global $fvseop_options;

		$post = $wp_query->get_queried_object();

		if ($this->fvseop_mrt_exclude_this_page())
		{
			return;
		}

		if (is_feed())
		{
			return;
		}

		if (is_single() || is_page())
		{
			$fvseo_disable = htmlspecialchars(stripcslashes(get_post_meta($post->ID, '_aioseop_disable', true)));
			
			if ($fvseo_disable)
			{
				return;
			}
		}

		///	Let's do this also if longer title is specified or if it's homepage
		if ($fvseop_options['aiosp_rewrite_titles']     || ( is_object( $post ) && get_post_meta($post->ID, "_aioseop_title", true) ) || is_home() )
		{
			ob_start(array($this, 'output_callback_for_title')); // this ob_start is matched with ob_end_flush in wp_head
		}
	}

	/**
	 * Triggered within the <head></head> section of the user's template.
	 *
	 * This hook is theme-dependent which means that it is up to the author of each WordPress theme
	 * to include it. It may not be available on all themes, so you should take this into account
	 * when using it.
	 *
	 * Although this is theme-dependent, it is one of the most essential theme hooks, so it is
	 * fairly widely supported. 
	 */
	function wp_head()
	{
		if (is_feed()) // ignore logic if it's a feed
		{
			return;
		}

		global $wp_query;
		global $fvseop_options;

		$post = $wp_query->get_queried_object();

		$meta_string = null;

		if ($this->is_static_posts_page())
		{
			// TODO: strip_tags return a string with all HTML and PHP tags stripped from a given str. Since
			// it uses a tag stripping state machine, probably it's better to remove this function if you
			// never use weird post titles.
			//
			// The apply_filters on 'single_post_title' ensure any previous plugin is applied.
			//
			// I would like to change this line to
			//
			// $title = $post->post_title;
			//
			// and save a lot of CPU cycles.
			$title = strip_tags(apply_filters('single_post_title', $post->post_title));
		}

		if (is_single() || is_page())
		{
			$fvseo_disable = htmlspecialchars(stripcslashes(get_post_meta($post->ID, '_aioseop_disable', true)));

			if ($fvseo_disable)
			{
				return;
			}
		}

		if ($this->fvseop_mrt_exclude_this_page())
		{
			return;
		}

                /// Modification - always enabled
		if ($fvseop_options['aiosp_rewrite_titles']     || 1>0)
		{
			// make the title rewrite as short as possible
			if (function_exists('ob_list_handlers'))
			{
				$active_handlers = ob_list_handlers();
			}
			else
			{
				$active_handlers = array();
			}
			
			if ((sizeof($active_handlers) > 0) &&
				(strtolower($active_handlers[sizeof($active_handlers) - 1]) ==
				strtolower('FV_Simpler_SEO_Pack::output_callback_for_title')))
			{
				ob_end_flush(); // this ob_end_flush is matched with ob_start in template_redirect
			}
			else
			{
				// TODO:
				// if we get here there *could* be trouble with another plugin :(
				// decide what to do
			}
		}

		if ((is_home() && stripcslashes( $this->internationalize( $fvseop_options['aiosp_home_keywords'] ) ) &&
			!$this->is_static_posts_page()) || $this->is_static_front_page())
		{
			$keywords = trim( stripcslashes( $this->internationalize($fvseop_options['aiosp_home_keywords']) ) );
		}
		elseif ($this->is_static_posts_page() && !$fvseop_options['aiosp_dynamic_postspage_keywords']) // and if option = use page set keywords instead of keywords from recent posts
		{
			$keywords = stripcslashes($this->internationalize(get_post_meta($post->ID, "_aioseop_keywords", true)));
		}
		else
		{
			$keywords = $this->get_all_keywords();
		}

		if (is_single() || is_page() || $this->is_static_posts_page())
		{
			if ($this->is_static_front_page())
			{
				$description = trim(stripcslashes($this->internationalize($fvseop_options['aiosp_home_description'])));
			}
			else
			{
				$description = $this->get_post_description($post);
				$description = apply_filters('fvseop_description', $description);
			}
		}
		elseif (is_home())
		{
			$description = trim(stripcslashes($this->internationalize($fvseop_options['aiosp_home_description'])));
		}
		elseif (is_category())
		{
			$description = $this->internationalize(category_description());
		}

		if (isset($description) && (strlen($description) > $this->minimum_description_length) &&
			!(is_home() && is_paged()))
		{
			$description = trim(strip_tags($description));
			$description = str_replace('"', '', $description);
			
			// replace newlines on mac / windows?
			$description = str_replace("\r\n", ' ', $description);
			
			// maybe linux uses this alone
			$description = str_replace("\n", ' ', $description);

			if (!isset($meta_string))
			{
				$meta_string = '';
			}

			// description format
			$description_format = stripslashes( $fvseop_options['aiosp_description_format'] );

			if (!isset($description_format) || empty($description_format))
			{
				$description_format = "%description%";
			}
			
			$description = str_replace('%description%', $description, $description_format);
			$description = str_replace('%blog_title%', get_bloginfo('name'), $description);
			$description = str_replace('%blog_description%', get_bloginfo('description'), $description);
			$description = str_replace('%wp_title%', $this->get_original_title(), $description);
			$description = trim( str_replace('%page%', $this->paged_description(), $description) );
			$description = __( $description );

			if ($fvseop_options['aiosp_can'] && is_attachment())
			{
				$url = $this->fvseo_mrt_get_url($wp_query);
                
				if ($url)
				{
					preg_match_all('/(\d+)/', $url, $matches);

					if (is_array($matches))
					{
						$uniqueDesc = join('', $matches[0]);
					}
				}
				
				$description .= ' ' . $uniqueDesc;
			}
			
			$meta_string .= '<meta name="description" content="' . esc_attr($description) . '" />';
		}
		
		$keywords = apply_filters('fvseop_keywords', $keywords);
		
		if (isset($keywords) && !empty($keywords) && !(is_home() && is_paged()))
		{
			if (isset($meta_string))
			{
				$meta_string .= "\n";
			}
			
			$meta_string .= '<meta name="keywords" content="' . esc_attr($keywords) . '" />';
		}

		if (function_exists('is_tag'))
		{
			$is_tag = is_tag();
		}
		
                /// Added noindex for search
		if ((is_category() && $fvseop_options['aiosp_category_noindex']) ||
			(!is_category() && is_archive() &&!$is_tag && $fvseop_options['aiosp_archive_noindex']) ||
			($fvseop_options['aiosp_tags_noindex'] && $is_tag) ||
                        (is_search() && $fvseop_options['aiosp_search_noindex'])
                        )
		{
			if (isset($meta_string))
			{
				$meta_string .= "\n";
			}
			
			$meta_string .= '<meta name="robots" content="noindex,follow" />';
		}
		
		$page_meta = stripcslashes($fvseop_options['aiosp_page_meta_tags']);
		$post_meta = stripcslashes($fvseop_options['aiosp_post_meta_tags']);
		$home_meta = stripcslashes($fvseop_options['aiosp_home_meta_tags']);
		
		if (is_page() && isset($page_meta) && !empty($page_meta) || $this->is_static_posts_page())
		{
			if (isset($meta_string))
			{
				$meta_string .= "\n";
			}
			
			$meta_string .= $page_meta;
		}
		
		if (is_single() && isset($post_meta) && !empty($post_meta))
		{
			if (isset($meta_string))
			{
				$meta_string .= "\n";
			}

			$meta_string .= $post_meta;
		}

		if (is_home() && !empty($home_meta))
		{
			if (isset($meta_string))
			{
				$meta_string .= "\n";
			}

			$meta_string .= $home_meta;
		}

		// add google site verification meta tag for webmasters tools
		$home_google_site_verification_meta_tag = isset( $fvseop_options['aiosp_home_google_site_verification_meta_tag'] ) ? stripcslashes($fvseop_options['aiosp_home_google_site_verification_meta_tag']) : NULL;
		$home_yahoo_site_verification_meta_tag = isset( $fvseop_options['aiosp_home_yahoo_site_verification_meta_tag'] ) ? stripcslashes($fvseop_options['aiosp_home_yahoo_site_verification_meta_tag']) : NULL;
		$home_bing_site_verification_meta_tag = isset( $fvseop_options['aiosp_home_bing_site_verification_meta_tag'] ) ? stripcslashes($fvseop_options['aiosp_home_bing_site_verification_meta_tag']) : NULL;

		if (is_home() && !empty($home_google_site_verification_meta_tag))
		{
			if (isset($meta_string))
			{
				$meta_string .= "\n";
			}

			$meta_string .= wp_kses($home_google_site_verification_meta_tag, array('meta' => array('name' => array(), 'content' => array())));
		}
		
		if (is_home() && !empty($home_yahoo_site_verification_meta_tag))
		{
			if (isset($meta_string))
			{
				$meta_string .= "\n";
			}

			$meta_string .= wp_kses($home_yahoo_site_verification_meta_tag, array('meta' => array('name' => array(), 'content' => array())));
		}
		
		if (is_home() && !empty($home_bing_site_verification_meta_tag))
		{
			if (isset($meta_string))
			{
				$meta_string .= "\n";
			}

			$meta_string .= wp_kses($home_bing_site_verification_meta_tag, array('meta' => array('name' => array(), 'content' => array())));
		}

		if ($meta_string != null)
		{
			echo wp_kses($meta_string, array('meta' => array('name' => array(), 'content' => array()))) . "\n";
		}

    /// Modification  2010/11/30, adding custom_canonical url
    
    /// check if meta is present
    if (is_single() || is_page() || $this->is_static_posts_page()) {
		  $custom_canonical = trim( get_post_meta($post->ID, "_aioseop_custom_canonical", true) );
    }
		///
		
		//if ($fvseop_options['aiosp_can'])
		if ($fvseop_options['aiosp_can'] || ( isset( $custom_canonical ) && $fvseop_options['aiosp_show_custom_canonical']  ) )
		/// End of modification
		{
		  if( $custom_canonical && $fvseop_options['aiosp_show_custom_canonical'] ) {
		    $url = $custom_canonical;
		  } else {
			  $url = $this->fvseo_mrt_get_url($wp_query);
		  }

			if ($url)
			{
				$url = apply_filters('fvseop_canonical_url', $url);

				echo '<link rel="canonical" href="' . esc_url($url) . '" />' . "\n";
			}
		}
	}
	
	function fvseo_mrt_get_url($query)
	{
		global $fvseop_options;

		if ($query->is_404 || $query->is_search)
		{
			return false;
		}

		$haspost = count($query->posts) > 0;
		$has_ut = function_exists('user_trailingslashit');

		if (get_query_var('m'))
		{
			$m = preg_replace('/[^0-9]/', '', get_query_var('m'));
			
			switch (strlen($m))
			{
			case 4:
				$link = get_year_link($m);
				break;
			case 6:
				$link = get_month_link(substr($m, 0, 4), substr($m, 4, 2));
				break;
			case 8:
				$link = get_day_link(substr($m, 0, 4), substr($m, 4, 2), substr($m, 6, 2));
				break;
			default:
				return false;
			}
		}
		elseif (($query->is_single || $query->is_page) && $haspost)
		{
			$post = $query->posts[0];
			$link = get_permalink($post->ID);
			$link = $this->yoast_get_paged($link); 
		}
		elseif ($query->is_author && $haspost)
		{
			$author = get_userdata(get_query_var('author'));

			if ($author === false)
				return false;

			$link = get_author_link(false, $author->ID, $author->user_nicename);
		}
		elseif ($query->is_category && $haspost)
		{
			$link = get_category_link(get_query_var('cat'));
			$link = $this->yoast_get_paged($link);
		}
		elseif ($query->is_tag  && $haspost)
		{
			$tag = get_term_by('slug', get_query_var('tag'), 'post_tag');
			
			if (!empty($tag->term_id))
			{
				$link = get_tag_link($tag->term_id);
			}
			
			$link = $this->yoast_get_paged($link);			
		}
		elseif ($query->is_day && $haspost)
		{
			$link = get_day_link(get_query_var('year'), get_query_var('monthnum'), get_query_var('day'));
		}
		elseif ($query->is_month && $haspost)
		{
			$link = get_month_link(get_query_var('year'), get_query_var('monthnum'));
		}
		elseif ($query->is_year && $haspost)
		{
			$link = get_year_link(get_query_var('year'));
		}
		elseif ($query->is_home)
		{
			if ((get_option('show_on_front') == 'page') && ($pageid = get_option('page_for_posts')))
			{
				$link = get_permalink($pageid);
				$link = $this->yoast_get_paged($link);
				$link = trailingslashit($link);
			}
			else
			{
				$link = get_option('home');
				$link = $this->yoast_get_paged($link);
				$link = trailingslashit($link);
			}
		}
		else
		{
			return false;
		}
		
		return $link;
	}
	
	function yoast_get_paged($link)
	{
		$page = get_query_var('paged');

		if ($page && $page > 1)
		{
			$link = trailingslashit($link) ."page/". "$page";

			if ($has_ut)
			{
				$link = user_trailingslashit($link, 'paged');
			}
			else
			{
				$link .= '/';
			}
		}

		return $link;
	}
	
	
  function paged_description($description = NULL)
 	{
 		// the page number if paged
 		global $paged;
 		global $fvseop_options;
 		// simple tagging support
 		global $STagging;
 
 		if( is_paged() )
 		{
 			$part = $this->internationalize( $fvseop_options['aiosp_paged_format'] );
 
 			if( isset($part) || !empty($part) )
 			{
 				$part = trim($part);
 				$part = str_replace('%page%', $paged, $part);
 				$description .= $part;
 			}
 		}
 
 		return $description;
 	}	
 		

	function get_post_description($post)
	{
		global $fvseop_options;

		$description = trim(stripcslashes($this->internationalize(get_post_meta($post->ID, "_aioseop_description", true))));

		if (!$description)
		{
			///	Addition - condition added
			if(!$fvseop_options['aiosp_dont_use_excerpt']) {
				$description = $this->trim_excerpt_without_filters_full_length($this->internationalize($post->post_excerpt));
			}
			///	End of addition

			if (!$description && $fvseop_options["aiosp_generate_descriptions"])
			{
				$description = $this->trim_excerpt_without_filters($this->internationalize($post->post_content));
			}				
		}

		// "internal whitespace trim"
		$description = preg_replace("/\s\s+/", " ", $description);

		return $description;
	}

	/**
	 * Replace the title using regular expressions. If the regular expression fails
	 * (probably a backtrack limit error) you need to fix your environment.
	 */
	function replace_title($content, $title)
	{
		return preg_replace('/<title>(.*?)<\/title>/ms', '<title>' . esc_html($title) . '</title>', $content, 1);
	}
	
	/** @return The original title as delivered by WP (well, in most cases) */
	function get_original_title()
	{
		global $wp_query;
		global $fvseop_options;
		
		if (!$wp_query)
		{
			return null;	
		}
		
		$post = $wp_query->get_queried_object();
		
		// the_search_query() is not suitable, it cannot just return
		global $s;

		$title = null;
		
		if (is_home())
		{
			$title = get_option('blogname');
		}
		elseif (is_single())
		{
			$title = $this->internationalize( /*wp_title('', false)*/ get_the_title($post->ID) );
		}
		elseif (is_search() && isset($s) && !empty($s))
		{
			if (function_exists('attribute_escape'))
			{
				$search = attribute_escape(stripcslashes($s));
			}
			else
			{
				$search = wp_specialchars(stripcslashes($s), true);
			}
			
			$search = $this->capitalize($search);
			$title = $search;
		}
		elseif (is_category() && !is_feed())
		{
			$category_description = $this->internationalize(category_description());
			$category_name = ucwords($this->internationalize(single_cat_title('', false)));
			$title = $category_name;
		}
		elseif (is_page())
		{
			$title = $this->internationalize( /*wp_title('', false)*/ get_the_title() );
		}
		elseif (function_exists('is_tag') && is_tag())
		{
			$tag = $this->internationalize(wp_title('', false));

			if ($tag)
			{
				$title = $tag;
			}
		}
		else if (is_archive())
		{
			$title = $this->internationalize(wp_title('', false));
		}
		else if (is_404())
		{
			$title_format = stripslashes( $fvseop_options['aiosp_404_title_format'] );

			$new_title = str_replace('%blog_title%', $this->internationalize(get_bloginfo('name')), $title_format);
			$new_title = str_replace('%blog_description%', $this->internationalize(get_bloginfo('description')), $new_title);
			$new_title = str_replace('%request_url%', esc_url($_SERVER['REQUEST_URI']), $new_title);
			$new_title = str_replace('%request_words%', $this->request_as_words(esc_url($_SERVER['REQUEST_URI'])), $new_title);
			
			$title = $new_title;
		}

		return trim($title);
	}
	
	function paged_title($title)
	{
		// the page number if paged
		global $paged;
		global $fvseop_options;
		// simple tagging support
		global $STagging;

		if (is_paged() || (isset($STagging) && $STagging->is_tag_view() && $paged))
		{
 			$part = stripslashes( $this->internationalize($fvseop_options['aiosp_paged_format']) );

			if (isset($part) || !empty($part))
			{
				$part = " " . trim($part);
				$part = str_replace('%page%', $paged, $part);
				$title .= $part;
			}
		}

		return $title;
	}

	function rewrite_title($header)
	{
		global $fvseop_options;
		global $wp_query;
		
		if (!$wp_query)
		{
			return $header;	
		}
		
		$post = $wp_query->get_queried_object();
		
		// the_search_query() is not suitable, it cannot just return
		global $s;
		
		global $STagging;

    //  change homepage title only if there is some in configuration. 
		if (is_home() && !$this->is_static_posts_page() && stripcslashes( $this->internationalize($fvseop_options['aiosp_home_title']) ) != '' /*&& $fvseop_options['aiosp_rewrite_titles']*/)
		{
			$title = stripcslashes( $this->internationalize( $fvseop_options['aiosp_home_title'] ) );
			
			if (empty($title))
			{
				$title = $this->internationalize(get_option('blogname'));
			}

			$title = $this->paged_title($title);
			$header = $this->replace_title($header, $title);
		}
		else if (is_attachment()        && $fvseop_options['aiosp_rewrite_titles'])
		{
			$title = get_the_title($post->post_parent).' '.$post->post_title.' – '.get_option('blogname');
			$header = $this->replace_title($header,$title);
		}
		else if (is_single())
		{
			// we're not in the loop :(
			$authordata = get_userdata($post->post_author);
			$categories = get_the_category();
			$category = '';
			
			if (count($categories) > 0)
			{
				$category = $categories[0]->cat_name;
			}

			$title = $this->internationalize(get_post_meta($post->ID, "_aioseop_title", true));
			
			if (!$title)
			{
				$title = $this->internationalize(get_post_meta($post->ID, "title_tag", true));
				
				if (!$title)
				{
					$title = $this->internationalize( /*wp_title('', false)*/ get_the_title() );
				}
			}

                        if( $fvseop_options['aiosp_rewrite_titles'] ) {
                            $title_format = stripslashes( $fvseop_options['aiosp_post_title_format'] );
    
                            $new_title = str_replace('%blog_title%', $this->internationalize(get_bloginfo('name')), $title_format);
                            $new_title = str_replace('%blog_description%', $this->internationalize(get_bloginfo('description')), $new_title);
                            $new_title = str_replace('%post_title%', $title, $new_title);
                            $new_title = str_replace('%category%', $category, $new_title);
                            $new_title = str_replace('%category_title%', $category, $new_title);
                            $new_title = str_replace('%post_author_login%', $authordata->user_login, $new_title);
                            $new_title = str_replace('%post_author_nicename%', $authordata->user_nicename, $new_title);
                            $new_title = str_replace('%post_author_firstname%', ucwords($authordata->first_name), $new_title);
                            $new_title = str_replace('%post_author_lastname%', ucwords($authordata->last_name), $new_title);
                        }
                        /// Addition
                        else
                            $new_title = $title;

			$title = $new_title;
			$title = trim($title);
			$title = apply_filters('fvseo_title_single',$title);

			$header = $this->replace_title($header, $title);
		}
		elseif (is_search() && isset($s) && !empty($s)      && $fvseop_options['aiosp_rewrite_titles'])
		{
			if (function_exists('attribute_escape'))
			{
				$search = attribute_escape(stripcslashes($s));
			}
			else
			{
				$search = wp_specialchars(stripcslashes($s), true);
			}

			$search = $this->capitalize($search);
			$title_format = stripslashes( $fvseop_options['aiosp_search_title_format'] );

			$title = str_replace('%blog_title%', $this->internationalize(get_bloginfo('name')), $title_format);
			$title = str_replace('%blog_description%', $this->internationalize(get_bloginfo('description')), $title);
			$title = str_replace('%search%', $search, $title);
			
			$header = $this->replace_title($header, $title);
		}
		elseif (is_category() && !is_feed()     && $fvseop_options['aiosp_rewrite_titles'])
		{
			$category_description = $this->internationalize(category_description());

			if($fvseop_options['aiosp_cap_cats'])
			{
				$category_name = ucwords($this->internationalize(single_cat_title('', false)));
			}
			else
			{
				$category_name = $this->internationalize(single_cat_title('', false));
			}			

			$title_format = stripslashes( $fvseop_options['aiosp_category_title_format'] );

			$title = str_replace('%category_title%', $category_name, $title_format);
			$title = str_replace('%category_description%', $category_description, $title);
			$title = str_replace('%blog_title%', $this->internationalize(get_bloginfo('name')), $title);
			$title = str_replace('%blog_description%', $this->internationalize(get_bloginfo('description')), $title);
			$title = $this->paged_title($title);
			
			$header = $this->replace_title($header, $title);
		}
		/// Modification  2011/01/26  - possibly a bugfix
		elseif (is_page() || $this->is_static_front_page())
		//elseif (is_page() || $this->is_static_posts_page())
		/// End of modification
		{
			// we're not in the loop :(
			$authordata = get_userdata($post->post_author);

			if ($this->is_static_front_page())
			{
				if ( stripcslashes( $this->internationalize($fvseop_options['aiosp_home_title']) ) )
				{
					//home title filter
					$home_title = stripcslashes( $this->internationalize( $fvseop_options['aiosp_home_title'] ) );
					$home_title = apply_filters('fvseop_home_page_title',$home_title);
					
					$header = $this->replace_title($header, $home_title);
				}
			}
			else
			{
				$title = $this->internationalize(get_post_meta($post->ID, "_aioseop_title", true));
				
				if (!$title)
				{
					$title = $this->internationalize( /*wp_title('', false)*/ get_the_title($post->ID) );
				}
                                
                                if( $fvseop_options['aiosp_rewrite_titles'] ) {

                                    $title_format = stripslashes( $fvseop_options['aiosp_page_title_format'] );
    
                                    $new_title = str_replace('%blog_title%', $this->internationalize(get_bloginfo('name')), $title_format);
                                    $new_title = str_replace('%blog_description%', $this->internationalize(get_bloginfo('description')), $new_title);
                                    $new_title = str_replace('%page_title%', $title, $new_title);
                                    $new_title = str_replace('%page_author_login%', $authordata->user_login, $new_title);
                                    $new_title = str_replace('%page_author_nicename%', $authordata->user_nicename, $new_title);
                                    $new_title = str_replace('%page_author_firstname%', ucwords($authordata->first_name), $new_title);
                                    $new_title = str_replace('%page_author_lastname%', ucwords($authordata->last_name), $new_title);
                                
                                }
                                /// Addition
                                else
                                    $new_title = $title;

				$title = trim($new_title);
				$title = apply_filters('fvseop_title_page', $title);

				$header = $this->replace_title($header, $title);
			}
		}
		elseif (function_exists('is_tag') && is_tag()       && $fvseop_options['aiosp_rewrite_titles'])
		{
			$tag = $this->internationalize(wp_title('', false));

			if ($tag)
			{
				$tag = $this->capitalize($tag);
				$title_format = stripslashes( $fvseop_options['aiosp_tag_title_format'] );
	            
				$title = str_replace('%blog_title%', $this->internationalize(get_bloginfo('name')), $title_format);
				$title = str_replace('%blog_description%', $this->internationalize(get_bloginfo('description')), $title);
				$title = str_replace('%tag%', $tag, $title);
				$title = $this->paged_title($title);
				
				$header = $this->replace_title($header, $title);
			}
		}
		elseif (isset($STagging) && $STagging->is_tag_view()        && $fvseop_options['aiosp_rewrite_titles']) // simple tagging support
		{
			$tag = $STagging->search_tag;
			
			if ($tag)
			{
				$tag = $this->capitalize($tag);
				$title_format = stripslashes( $fvseop_options['aiosp_tag_title_format'] );

				$title = str_replace('%blog_title%', $this->internationalize(get_bloginfo('name')), $title_format);
				$title = str_replace('%blog_description%', $this->internationalize(get_bloginfo('description')), $title);
				$title = str_replace('%tag%', $tag, $title);
				$title = $this->paged_title($title);

				$header = $this->replace_title($header, $title);
			}
		}
		else if (is_archive()       && $fvseop_options['aiosp_rewrite_titles'])
		{
			$date = $this->internationalize(wp_title('', false));
			$title_format = stripslashes( $fvseop_options['aiosp_archive_title_format'] );

			$new_title = str_replace('%blog_title%', $this->internationalize(get_bloginfo('name')), $title_format);
			$new_title = str_replace('%blog_description%', $this->internationalize(get_bloginfo('description')), $new_title);
			$new_title = str_replace('%date%', $date, $new_title);

			$title = trim($new_title);
			$title = $this->paged_title($title);

			$header = $this->replace_title($header, $title);
		}
		else if (is_404()       && $fvseop_options['aiosp_rewrite_titles'])
		{
			$title_format = stripslashes( $fvseop_options['aiosp_404_title_format'] );

			$new_title = str_replace('%blog_title%', $this->internationalize(get_bloginfo('name')), $title_format);
			$new_title = str_replace('%blog_description%', $this->internationalize(get_bloginfo('description')), $new_title);
			$new_title = str_replace('%request_url%', esc_url($_SERVER['REQUEST_URI']), $new_title);
			$new_title = str_replace('%request_words%', $this->request_as_words(esc_url($_SERVER['REQUEST_URI'])), $new_title);
			$new_title = str_replace('%404_title%', $this->internationalize(wp_title('', false)), $new_title);

			$header = $this->replace_title($header, $new_title);
		}
		
		return $header;
	}
	
	/**
	 * @return User-readable nice words for a given request.
	 */
	function request_as_words($request)
	{
		$request = htmlspecialchars($request);
		$request = str_replace('.html', ' ', $request);
		$request = str_replace('.htm', ' ', $request);
		$request = str_replace('.', ' ', $request);
		$request = str_replace('/', ' ', $request);

		$request_a = explode(' ', $request);
		$request_new = array();

		foreach ($request_a as $token)
		{
			$request_new[] = ucwords(trim($token));
		}

		$request = implode(' ', $request_new);

		return $request;
	}
	
	function trim_excerpt_without_filters($text)
	{
		$text = str_replace(']]>', ']]&gt;', $text);
		$text = preg_replace( '|\[(.+?)\](.+?\[/\\1\])?|s', '', $text);
		$text = strip_tags($text);

		$max = $this->maximum_description_length;

		if ($max < strlen($text))
		{
			while ($text[$max] != ' ' && $max > $this->minimum_description_length)
			{
				$max--;
			}
		}

		$text = substr($text, 0, $max);

		return trim(stripcslashes($text));
	}
	
	function trim_excerpt_without_filters_full_length($text)
	{
		$text = str_replace(']]>', ']]&gt;', $text);
		$text = preg_replace( '|\[(.+?)\](.+?\[/\\1\])?|s', '', $text);
		$text = strip_tags($text);

		return trim(stripcslashes($text));
	}
	
	/**
	 * @return comma-separated list of unique keywords
	 */
	function get_all_keywords()
	{
		global $posts;
		global $fvseop_options;

		if (is_404())
		{
			return null;
		}
		
		// if we are on synthetic pages
		if (!is_home() && !is_page() && !is_single() &&!$this->is_static_front_page() && !$this->is_static_posts_page()) 
		{
			return null;
		}

		$keywords = array();
		
		if (is_array($posts))
		{
         /// optimalization HACKs by peter
         /// Pre-cache post meta and tags and categories if needed and if WP version permits it
         $aIDs = array();
         foreach( $posts as $objPost ) $aIDs[] = $objPost->ID;

         if( function_exists( 'update_meta_cache' ) ) update_meta_cache( 'post', $aIDs );
         if( ( $fvseop_options['aiosp_use_tags_as_keywords'] || ( $fvseop_options['aiosp_use_categories'] && !is_page() ) )
               && function_exists( 'wp_get_object_terms' )
               && function_exists( 'wp_cache_add' ) )
         {
            $aTax = array();
            if( $fvseop_options['aiosp_use_tags_as_keywords'] ) $aTax[] = 'post_tag';
            if( $fvseop_options['aiosp_use_categories'] && !is_page() ) $aTax[] = 'category';

            $aRawTerms = array();
            if( 0 < count( $aIDs ) && 0 < count( $aTax ) )
               $aRawTerms = wp_get_object_terms( $aIDs, $aTax, array( 'orderby' => 'count', 'order' => 'DESC', 'fields' => 'all_with_object_id' ) );
            $aTags = array();
            $aCats = array();


            foreach( $aRawTerms as $objTerm ){
               if( !isset( $aTags[$objTerm->object_id] ) ) $aTags[$objTerm->object_id] = array();
               if( !isset( $aCats[$objTerm->object_id] ) ) $aCats[$objTerm->object_id] = array();

               if( 'category' == $objTerm->taxonomy ) $aCats[$objTerm->object_id][] = $objTerm;
               if( 'post_tag' == $objTerm->taxonomy ) $aTags[$objTerm->object_id][] = $objTerm;
            }

            if( $fvseop_options['aiosp_use_categories'] && !is_page() )
               foreach( $aCats as $id => $aPostCats )
                  wp_cache_add( $id, $aPostCats, 'category_relationships');
            if( $fvseop_options['aiosp_use_tags_as_keywords'] )
               foreach( $aTags as $id => $aPostTags )
                  wp_cache_add( $id, $aPostTags, 'post_tag_relationships');
         }


			foreach ($posts as $post)
			{
				if ($post)
				{
					// custom field keywords
					$keywords_a = $keywords_i = null;
					$description_a = $description_i = null;

					$id = is_attachment() ? $post->post_parent : $post->ID; // if attachment then use parent post id

					$keywords_i = stripcslashes($this->internationalize(get_post_meta($id, "_aioseop_keywords", true)));
					$keywords_i = str_replace('"', '', $keywords_i);
	                
					if (isset($keywords_i) && !empty($keywords_i))
					{
						$traverse = explode(',', $keywords_i);
	                	
						foreach ($traverse as $keyword) 
						{
							$keywords[] = $keyword;
						}
					}
	                
					if ($fvseop_options['aiosp_use_tags_as_keywords'])
					{
						if (function_exists('get_the_tags'))
						{
							$tags = get_the_tags($id);

							if ($tags && is_array($tags))
							{
								foreach ($tags as $tag)
								{
									$keywords[] = $this->internationalize($tag->name);
								}
							}
						}
					}

					// autometa
					$autometa = stripcslashes(get_post_meta($id, 'autometa', true));

					if (isset($autometa) && !empty($autometa))
					{
						$autometa_array = explode(' ', $autometa);
						
						foreach ($autometa_array as $e) 
						{
							$keywords[] = $e;
						}
					}

					if ($fvseop_options['aiosp_use_categories'] && !is_page())
					{
						$categories = get_the_category($id); 

						foreach ($categories as $category)
						{
							$keywords[] = $this->internationalize($category->cat_name);
						}
					}
				}
			}
		}

		return $this->get_unique_keywords($keywords);
	}

	function get_unique_keywords($keywords)
	{
		$small_keywords = array();
		
		foreach ($keywords as $word)
		{
			if (function_exists('mb_strtolower'))			
				$small_keywords[] = mb_strtolower($word, get_bloginfo('charset'));
			else 
				$small_keywords[] = $this->strtolower($word);
		}
		
		$keywords_ar = array_unique($small_keywords);
		
		return implode(',', $keywords_ar);
	}

	/** crude approximization of whether current user is an admin */
	function is_admin()
	{
		return current_user_can('level_8');
	}

	function post_meta_tags($id)
	{
	  if( isset( $_POST['fvseo_edit'] ) ) {
		  $awmp_edit = $_POST['fvseo_edit'];
	  }
	  if( isset( $_POST['nonce-fvseopedit'] ) ) {
		  $nonce = $_POST['nonce-fvseopedit'];
	  }

		if (isset($awmp_edit) && !empty($awmp_edit) && wp_verify_nonce($nonce, 'edit-fvseopnonce'))
		{
			$keywords = isset( $_POST["fvseo_keywords"] ) ? $_POST["fvseo_keywords"] : NULL;
			if (function_exists('qtrans_getSortedLanguages')) {        
        $languages = qtrans_getSortedLanguages();          
        $title = '';
        foreach($languages as $language) {
          if ($_POST['fvseo_title_' . $language] != '') {
            $title .= '<!--:' . $language . '-->' . $_POST['fvseo_title_' . $language] . '<!--:-->';
          }
        }                                                  
        $description = '';
        foreach($languages as $language) {
          if ($_POST['fvseo_description_' . $language] != '')  {
            $description .= '<!--:' . $language . '-->' . $_POST['fvseo_description_' . $language] . '<!--:-->';
          }
        }                    
      }
      else {        
        $description = isset( $_POST["fvseo_description"] ) ? $_POST["fvseo_description"] : NULL;
        $title = isset( $_POST["fvseo_title"] ) ? $_POST["fvseo_title"] : NULL;
      }
			$fvseo_meta = isset( $_POST["fvseo_meta"] ) ? $_POST["fvseo_meta"] : NULL;
			$fvseo_disable = isset( $_POST["fvseo_disable"] ) ? $_POST["fvseo_disable"] : NULL;
			$fvseo_titleatr = isset( $_POST["fvseo_titleatr"] ) ? $_POST["fvseo_titleatr"] : NULL;
			$fvseo_menulabel = isset( $_POST["fvseo_menulabel"] ) ? $_POST["fvseo_menulabel"] : NULL;
			$custom_canonical = isset( $_POST["fvseo_custom_canonical"] ) ? $_POST["fvseo_custom_canonical"] : NULL;		
				
			delete_post_meta($id, '_aioseop_keywords');
			delete_post_meta($id, '_aioseop_description');
			delete_post_meta($id, '_aioseop_title');
			delete_post_meta($id, '_aioseop_titleatr');
			delete_post_meta($id, '_aioseop_menulabel');
			delete_post_meta($id, '_aioseop_custom_canonical');			
		
			if ($this->is_admin())
			{
				delete_post_meta($id, '_aioseop_disable');
			}

			if (isset($keywords) && !empty($keywords))
			{
				add_post_meta($id, '_aioseop_keywords', $keywords);
			}

			if (isset($description) && !empty($description))
			{
				add_post_meta($id, '_aioseop_description', $description);
			}

			if (isset($title) && !empty($title) && $title != get_the_title( $id ) )
			{
				add_post_meta($id, '_aioseop_title', $title);
			}
		    
			if (isset($fvseo_titleatr) && !empty($fvseo_titleatr))
			{
				add_post_meta($id, '_aioseop_titleatr', $fvseo_titleatr);
			}

			if (isset($fvseo_menulabel) && !empty($fvseo_menulabel))
			{
				add_post_meta($id, '_aioseop_menulabel', $fvseo_menulabel);
			}				

			if (isset($fvseo_disable) && !empty($fvseo_disable) && $this->is_admin())
			{
				add_post_meta($id, '_aioseop_disable', $fvseo_disable);
			}

			if (isset($custom_canonical) && !empty($custom_canonical))
			{
				add_post_meta($id, '_aioseop_custom_canonical', str_replace(" ","%20", $custom_canonical ) );
			}			
		}
	}

	/**
	 * Defines the sub-menu admin page using the add_submenu_page function.
	 */
	function admin_menu()
	{
		add_submenu_page('options-general.php', __('FV Simpler SEO', 'fvseo'), __('FV Simpler SEO', 'fvseo'), 'manage_options', __FILE__, array($this, 'options_panel'));
	}

	function options_panel()
	{
		$message = null;

		global $fvseop_options;		
		
		if (!$fvseop_options['aiosp_cap_cats'])
		{
			$fvseop_options['aiosp_cap_cats'] = '1';
		}
		
		if( isset($_POST['action']) && $_POST['action'] == 'fvseo_update' && isset( $_POST['Submit_Default'] ) && $_POST['Submit_Default'] != '')
		{
			$nonce = $_POST['nonce-fvseop'];
			
			if (!wp_verify_nonce($nonce, 'fvseopnonce'))
				die ( 'Security Check - If you receive this in error, log out and back in to WordPress');
			
			$message = __("FV All in One SEO Pack Options Reset.", 'fvseo');

			delete_option('aioseop_options');

			$res_fvseop_options = array(
				"aiosp_can"=>0,
				"aiosp_home_title"=>null,
				"aiosp_home_description"=>'',
				"aiosp_home_keywords"=>null,
				"aiosp_max_words_excerpt"=>'something',
				"aiosp_rewrite_titles"=>0,
				"aiosp_post_title_format"=>'%post_title% | %blog_title%',
				"aiosp_page_title_format"=>'%page_title% | %blog_title%',
				"aiosp_category_title_format"=>'%category_title% | %blog_title%',
				"aiosp_archive_title_format"=>'%date% | %blog_title%',
				"aiosp_tag_title_format"=>'%tag% | %blog_title%',
				"aiosp_search_title_format"=>'%search% | %blog_title%',
				"aiosp_description_format"=>'%description%',
				"aiosp_404_title_format"=>'Nothing found for %request_words%',
				"aiosp_paged_format"=>' - Part %page%',
				"aiosp_use_categories"=>1,
				"aiosp_dynamic_postspage_keywords"=>1,
				"aiosp_category_noindex"=>0,
				"aiosp_archive_noindex"=>0,
				"aiosp_tags_noindex"=>0,
				"aiosp_cap_cats"=>0,
				"aiosp_generate_descriptions"=>0,
				"aiosp_debug_info"=>null,
				"aiosp_post_meta_tags"=>'',
				"aiosp_page_meta_tags"=>'',
				"aiosp_home_meta_tags"=>'',
				'home_google_site_verification_meta_tag' => '',
				'aiosp_use_tags_as_keywords' => 1,
				///	Addition
        'aiosp_search_noindex'=>1,
				'aiosp_dont_use_excerpt'=>0,
				'aiosp_show_keywords'=>0,				
				'aiosp_show_titleattribute'=>0,
				'aiosp_show_disable'=>0,
				'aiosp_show_custom_canonical'=>0				
				);
				///	End of addition
				
			update_option('aioseop_options', $res_fvseop_options);
		}
		
		// update options
		if( isset($_POST['action']) && $_POST['action'] == 'fvseo_update' && isset( $_POST['Submit'] ) && $_POST['Submit'] != '')
		{
			$nonce = $_POST['nonce-fvseop'];
		
			if (!wp_verify_nonce($nonce, 'fvseopnonce'))
				die ( 'Security Check - If you receive this in error, log out and back in to WordPress');
				
			$message = __("FV All in One SEO Pack Options Updated.", 'fvseo');
			
			$fvseop_options['aiosp_can'] = isset( $_POST['fvseo_can'] ) ? $_POST['fvseo_can'] : NULL;
			$fvseop_options['aiosp_home_title'] = isset( $_POST['fvseo_home_title'] ) ? $_POST['fvseo_home_title'] : NULL;
			$fvseop_options['aiosp_home_description'] = isset( $_POST['fvseo_home_description'] ) ? $_POST['fvseo_home_description'] : NULL;
			$fvseop_options['aiosp_home_keywords'] = isset( $_POST['fvseo_home_keywords'] ) ? $_POST['fvseo_home_keywords'] : NULL;
			$fvseop_options['aiosp_max_words_excerpt'] = isset( $_POST['fvseo_max_words_excerpt'] ) ? $_POST['fvseo_max_words_excerpt'] : NULL;
			$fvseop_options['aiosp_rewrite_titles'] = isset( $_POST['fvseo_rewrite_titles'] ) ? $_POST['fvseo_rewrite_titles'] : NULL;
			$fvseop_options['aiosp_post_title_format'] = isset( $_POST['fvseo_post_title_format'] ) ? $_POST['fvseo_post_title_format'] : NULL;
			$fvseop_options['aiosp_page_title_format'] = isset( $_POST['fvseo_page_title_format'] ) ? $_POST['fvseo_page_title_format'] : NULL;
			$fvseop_options['aiosp_category_title_format'] = isset( $_POST['fvseo_category_title_format'] ) ? $_POST['fvseo_category_title_format'] : NULL;
			$fvseop_options['aiosp_archive_title_format'] = isset( $_POST['fvseo_archive_title_format'] ) ? $_POST['fvseo_archive_title_format'] : NULL;
			$fvseop_options['aiosp_tag_title_format'] = isset( $_POST['fvseo_tag_title_format'] ) ? $_POST['fvseo_tag_title_format'] : NULL;
			$fvseop_options['aiosp_search_title_format'] = isset( $_POST['fvseo_search_title_format'] ) ? $_POST['fvseo_search_title_format'] : NULL;
			$fvseop_options['aiosp_description_format'] = isset( $_POST['fvseo_description_format'] ) ? $_POST['fvseo_description_format'] : NULL;
			$fvseop_options['aiosp_404_title_format'] = isset( $_POST['fvseo_404_title_format'] ) ? $_POST['fvseo_404_title_format'] : NULL;
			$fvseop_options['aiosp_paged_format'] = isset( $_POST['fvseo_paged_format'] ) ? $_POST['fvseo_paged_format'] : NULL;
			$fvseop_options['aiosp_use_categories'] = isset( $_POST['fvseo_category_noindex'] ) ? $_POST['fvseo_category_noindex'] : NULL;
			$fvseop_options['aiosp_dynamic_postspage_keywords'] = $_POST['fvseo_dynamic_postspage_keywords'];
			$fvseop_options['aiosp_category_noindex'] = isset( $_POST['fvseo_category_noindex'] ) ? $_POST['fvseo_category_noindex'] : NULL;
			$fvseop_options['aiosp_archive_noindex'] = isset( $_POST['fvseo_archive_noindex'] ) ? $_POST['fvseo_archive_noindex'] : NULL;
			$fvseop_options['aiosp_tags_noindex'] = isset( $_POST['fvseo_tags_noindex'] ) ? $_POST['fvseo_tags_noindex'] : NULL;
			$fvseop_options['aiosp_generate_descriptions'] = isset( $_POST['fvseo_generate_descriptions'] ) ? $_POST['fvseo_generate_descriptions'] : NULL;
			$fvseop_options['aiosp_cap_cats'] = isset( $_POST['fvseo_cap_cats'] ) ? $_POST['fvseo_cap_cats'] : NULL;
			$fvseop_options['aiosp_debug_info'] = isset( $_POST['fvseo_debug_info'] ) ? $_POST['fvseo_debug_info'] : NULL;
			$fvseop_options['aiosp_post_meta_tags'] = isset( $_POST['fvseo_post_meta_tags'] ) ? $_POST['fvseo_post_meta_tags'] : NULL;
			$fvseop_options['aiosp_page_meta_tags'] = isset( $_POST['fvseo_page_meta_tags'] ) ? $_POST['fvseo_page_meta_tags'] : NULL;
			$fvseop_options['aiosp_home_meta_tags'] = isset( $_POST['fvseo_home_meta_tags'] ) ? $_POST['fvseo_home_meta_tags'] : NULL;
			$fvseop_options['aiosp_home_google_site_verification_meta_tag'] = isset( $_POST['fvseo_home_google_site_verification_meta_tag'] ) ? $_POST['fvseo_home_google_site_verification_meta_tag'] : NULL;
			$fvseop_options['aiosp_home_bing_site_verification_meta_tag'] = isset( $_POST['fvseo_home_bing_site_verification_meta_tag'] ) ? $_POST['fvseo_home_bing_site_verification_meta_tag'] : NULL;
			$fvseop_options['aiosp_home_yahoo_site_verification_meta_tag'] = isset( $_POST['fvseo_home_yahoo_site_verification_meta_tag'] ) ? $_POST['fvseo_home_yahoo_site_verification_meta_tag'] : NULL;						
			$fvseop_options['aiosp_ex_pages'] = isset( $_POST['fvseo_ex_pages'] ) ? $_POST['fvseo_ex_pages'] : NULL;
			$fvseop_options['aiosp_use_tags_as_keywords'] = isset( $_POST['fvseo_use_tags_as_keywords'] ) ? $_POST['fvseo_use_tags_as_keywords'] : NULL;
			///	Addition
      $fvseop_options['aiosp_search_noindex'] = isset( $_POST['fvseo_search_noindex'] ) ? $_POST['fvseo_search_noindex'] : NUUL;
			$fvseop_options['aiosp_dont_use_excerpt'] = isset( $_POST['fvseo_dont_use_excerpt'] ) ? $_POST['fvseo_dont_use_excerpt'] : NULL;
			$fvseop_options['aiosp_show_keywords'] = isset( $_POST['fvseo_show_keywords'] ) ? $_POST['fvseo_show_keywords'] : NULL;
			$fvseop_options['aiosp_show_custom_canonical'] = isset( $_POST['fvseo_show_custom_canonical'] ) ? $_POST['fvseo_show_custom_canonical'] : NULL;
			$fvseop_options['aiosp_show_titleattribute'] = isset( $_POST['fvseo_show_titleattribute'] ) ? $_POST['fvseo_show_titleattribute'] : NULL;
			$fvseop_options['aiosp_show_disable'] = isset( $_POST['fvseo_show_disable'] ) ? $_POST['fvseo_show_disable'] : NULL;
			///	End of addition

			update_option('aioseop_options', $fvseop_options);

			if (function_exists('wp_cache_flush'))
			{
				wp_cache_flush();
			}
		}
		
		// TODO: Important, I can't change the four textareas for the additional headers until I change the whole concept in this fields. I need to do it.
?>
<?php if ($message) : ?>
  <div id="message" class="updated fade">
    <p>
      <?php echo $message; ?>
    </p>
  </div>
<?php endif; ?>
  <div id="dropmessage" class="updated" style="display:none;"></div>
  <div class="wrap">
    <h2>
      <?php _e('FV All in One SEO Pack Plugin Options', 'fvseo'); ?>
    </h2>
    <div style="clear:both;"></div>
<script type="text/javascript">
function toggleVisibility(id)
{
  var e = document.getElementById(id);

  if(e.style.display == 'block')
    e.style.display = 'none';
  else
    e.style.display = 'block';
}
</script>
    <form name="dofollow" action="" method="post">

        <?php $fvseop_options = get_option('aioseop_options'); ?>

            <p>
                <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_home_title_tip');">
                  <?php _e('Home Title:', 'fv_seo')?>
                </a><br />
                <input class="regular-text" size="63" name="fvseo_home_title" value="<?php echo esc_attr(stripcslashes($fvseop_options['aiosp_home_title']))?>" />
                <div style="max-width:500px; text-align:left; display:none" id="fvseo_home_title_tip">
                  <?php _e('As the name implies, this will be the title of your homepage. This is independent of any other option. If not set, the default blog title will get used.', 'fv_seo')?>
                </div>
            </p>

            <p>
                <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_home_description_tip');">
                  <?php _e('Home Description:', 'fv_seo')?>
                </a><br />
                <textarea cols="57" rows="2" name="fvseo_home_description"><?php echo esc_attr(stripcslashes($fvseop_options['aiosp_home_description']))?></textarea>
                <div style="max-width:500px; text-align:left; display:none" id="fvseo_home_description_tip">
                  <?php _e('The META description for your homepage. Independent of any other options, the default is no META description at all if this is not set.', 'fv_seo')?>
                </div>
            </p>

            <p>
                <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_home_keywords_tip');">
                  <?php _e('Home Keywords (comma separated):', 'fv_seo')?>
                </a><br />
                <textarea cols="57" rows="2" name="fvseo_home_keywords"><?php echo esc_attr(stripcslashes($fvseop_options['aiosp_home_keywords'])); ?></textarea>
                <div style="max-width:500px; text-align:left; display:none" id="fvseo_home_keywords_tip">
                  <?php _e("A comma separated list of your most important keywords for your site that will be written as META keywords on your homepage. Don't stuff everything in here.", 'fv_seo')?>
                </div>
            </p>
            
            <p>
                <a href="#" onclick="toggleVisibility('fvseo_user_interface_options');">Extra Interface Options</a> <small>(not recommended)</small>
            </p>
            

                <div style="border-left: 1px solid #ddd; padding-left: 10px; margin-left: 20px; text-align:left; 
                <?php if( !$fvseop_options['aiosp_show_keywords'] && !$fvseop_options['aiosp_show_custom_canonical'] && !$fvseop_options['aiosp_show_titleattribute'] && !$fvseop_options['aiosp_show_disable'] ) echo 'display: none;' ?>" id="fvseo_user_interface_options">
                            <p>
                                <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_show_keywords_tip');">
                                <?php _e('Add keywords field to post editing screen:', 'fv_seo')?>
                                </a>
                                <input type="checkbox" name="fvseo_show_keywords" <?php if ($fvseop_options['aiosp_show_keywords']) echo "checked=\"1\""; ?>/>
                                <div style="max-width:500px; text-align:left; display:none" id="fvseo_show_keywords_tip">
                                <?php
                                _e("You don't need this field at all if you are using tags properly. It makes the FV All in One SEO Pack box in the editing screen more complicated too.", 'fv_seo');
                                 ?>
                                </div>
                            </p>
                            
                            <p>
                                <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_show_custom_canonical_tip');">
                                <?php _e('Experimental - Use Custom Canonical URL field:', 'fv_seo')?>
                                </a>
                                <input type="checkbox" name="fvseo_show_custom_canonical" <?php if ($fvseop_options['aiosp_show_custom_canonical']) echo "checked=\"1\""; ?>/>
                                <script type="text/javascript">
                                jQuery("input[name='fvseo_show_custom_canonical']").change( function() {
                                  if( jQuery(this).is(':checked') ) {
                                    if( confirm( 'Are you sure you want to turn on this feature? Using wrong custom canonical URLs can damage your site SEO rankings.'+"\n"+"\n"+' If you are not sure, then leave this off and Wordpress will take care of it on its own.' ) ) {
                                    } else {
                                      jQuery(this).removeAttr('checked');
                                    }
                                  }
                                });
                                </script>
                                <div style="max-width:500px; text-align:left; display:none" id="fvseo_show_custom_canonical_tip">
                                <?php
                                _e("Use this feature only if you are sure you want to enter custom canonical URLs. This is not affected by the \"Canonical URLs\" Advanced Option (bellow).", 'fv_seo');
                                 ?>
                                </div>
                            </p>                            

                            <p>
                                <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_show_titleattribute_tip');">
                                <?php _e('Add Title Attribute field to page editing screen (deprecated):', 'fv_seo')?>
                                </a>
                                <input type="checkbox" name="fvseo_show_titleattribute" <?php if ($fvseop_options['aiosp_show_titleattribute']) echo "checked=\"1\""; ?>/>
                                <div style="max-width:500px; text-align:left; display:none" id="fvseo_show_titleattribute_tip">
                                <?php
                                _e("Allows you to set the anchor title for pages in menus. You don't need this field at all because post title or Long Title will be used instead.", 'fv_seo');
                                 ?>
                                </div>
                            </p>

                            <p>
                                <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_show_disable_tip');">
                                <?php _e('Add "Disable on this post/page" checkbox to post editing screen (deprecated):', 'fv_seo')?>
                                </a>
                                <input type="checkbox" name="fvseo_show_disable" <?php if ($fvseop_options['aiosp_show_disable']) echo "checked=\"1\""; ?>/>
                                <div style="max-width:500px; text-align:left; display:none" id="fvseo_show_disable_tip">
                                <?php
                                _e("Let's you disable the plugin for a specific post or page.", 'fv_seo');
                                 ?>
                                </div>
                            </p>
                </div>

            
            <p>
                <a href="#" onclick="toggleVisibility('fvseo_advanced_options'); return false">Advanced Options</a>
            </p>
            

        <div style="border-left: 1px solid #ddd; padding-left: 10px; margin-left: 20px; text-align:left; display:none" id="fvseo_advanced_options">
        
            <p>
                <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_can_tip');">
                  <?php _e('Canonical URLs:', 'fv_seo')?>
                </a>
                <input type="checkbox" name="fvseo_can" <?php if ($fvseop_options['aiosp_can']) echo 'checked="checked"'; ?>/>
                <div style="max-width:500px; text-align:left; display:none" id="fvseo_can_tip">
                  <?php _e("This option will automatically generate Canonical URLS for your entire WordPress installation.  This will help to prevent duplicate content penalties by <a href='http://googlewebmastercentral.blogspot.com/2009/02/specify-your-canonical.html' target='_blank'>Google</a>.", 'fv_seo')?>
                </div>
            </p>

            <p>
                <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_rewrite_titles_tip');">
                  <?php _e('Rewrite Titles:', 'fv_seo')?>
                </a>
                <input type="checkbox" name="fvseo_rewrite_titles" <?php if ($fvseop_options['aiosp_rewrite_titles']) echo 'checked="checked"'; ?> onclick="toggleVisibility('fvseo_rewrite_titles_options');" /> <abbr title="Not required for most modern templates. Enable to see more options.">(?)</a>
                <div style="max-width:500px; text-align:left; display:none" id="fvseo_rewrite_titles_tip">
                  <?php _e("Note that this is all about the title tag. This is what you see in your browser's window title bar. This is NOT visible on a page, only in the window title bar and of course in the source. If set, all page, post, category, search and archive page titles get rewritten. You can specify the format for most of them. For example: The default templates puts the title tag of posts like this: Blog Archive >> Blog Name >> Post Title (maybe I've overdone slightly). This is far from optimal. With the default post title format, Rewrite Title rewrites this to Post Title | Blog Name. If you have manually defined a title (in one of the text fields for All in One SEO Plugin input) this will become the title of your post in the format string.", 'fv_seo')?>
                </div>
            </p>
            
            <div style="width: 470px; background: #f0f0f0; padding: 10px; margin-left: 20px; text-align:left; display:<?php if ($fvseop_options['aiosp_rewrite_titles']) echo 'block'; else echo 'none'; ?>" id="fvseo_rewrite_titles_options">
                <p>
                    <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_post_title_format_tip');">
                        <?php _e('Post Title Format:', 'fv_seo')?>
                    </a><br />
                    <input size="59" name="fvseo_post_title_format" value="<?php echo esc_attr(stripcslashes($fvseop_options['aiosp_post_title_format'])); ?>"/>
                    <div style="max-width:500px; text-align:left; display:none" id="fvseo_post_title_format_tip">
                        <?php
                        _e('The following macros are supported:', 'fv_seo');
                        echo('<ul>');
                        echo('<li>'); _e('%blog_title% - Your blog title', 'fv_seo'); echo('</li>');
                        echo('<li>'); _e('%blog_description% - Your blog description', 'fv_seo'); echo('</li>');
                        echo('<li>'); _e('%post_title% - The original title of the post', 'fv_seo'); echo('</li>');
                        echo('<li>'); _e('%category_title% - The (main) category of the post', 'fv_seo'); echo('</li>');
                        echo('<li>'); _e('%category% - Alias for %category_title%', 'fv_seo'); echo('</li>');
                        echo('<li>'); _e("%post_author_login% - This post's author' login", 'fv_seo'); echo('</li>');
                        echo('<li>'); _e("%post_author_nicename% - This post's author' nicename", 'fv_seo'); echo('</li>');
                        echo('<li>'); _e("%post_author_firstname% - This post's author' first name (capitalized)", 'fv_seo'); echo('</li>');
                        echo('<li>'); _e("%post_author_lastname% - This post's author' last name (capitalized)", 'fv_seo'); echo('</li>');
                        echo('</ul>');
                        ?>
                    </div>
                </p>
    
                <p>
                    <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_page_title_format_tip');">
                      <?php _e('Page Title Format:', 'fv_seo')?>
                    </a><br />
                    <input size="59" name="fvseo_page_title_format" value="<?php echo esc_attr(stripcslashes($fvseop_options['aiosp_page_title_format'])); ?>"/>
                    <div style="max-width:500px; text-align:left; display:none" id="fvseo_page_title_format_tip">
                        <?php
                        _e('The following macros are supported:', 'fv_seo');
                        echo('<ul>');
                        echo('<li>'); _e('%blog_title% - Your blog title', 'fv_seo'); echo('</li>');
                        echo('<li>'); _e('%blog_description% - Your blog description', 'fv_seo'); echo('</li>');
                        echo('<li>'); _e('%page_title% - The original title of the page', 'fv_seo'); echo('</li>');
                        echo('<li>'); _e("%page_author_login% - This page's author' login", 'fv_seo'); echo('</li>');
                        echo('<li>'); _e("%page_author_nicename% - This page's author' nicename", 'fv_seo'); echo('</li>');
                        echo('<li>'); _e("%page_author_firstname% - This page's author' first name (capitalized)", 'fv_seo'); echo('</li>');
                        echo('<li>'); _e("%page_author_lastname% - This page's author' last name (capitalized)", 'fv_seo'); echo('</li>');
                        echo('</ul>');
                        ?>
                    </div>
                </p>
    
                <p>
                    <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_category_title_format_tip');">
                      <?php _e('Category Title Format:', 'fv_seo')?>
                    </a><br />
                    <input size="59" name="fvseo_category_title_format" value="<?php echo esc_attr(stripcslashes($fvseop_options['aiosp_category_title_format'])); ?>"/>
                    <div style="max-width:500px; text-align:left; display:none" id="fvseo_category_title_format_tip">
                        <?php
                        _e('The following macros are supported:', 'fv_seo');
                        echo('<ul>');
                        echo('<li>'); _e('%blog_title% - Your blog title', 'fv_seo'); echo('</li>');
                        echo('<li>'); _e('%blog_description% - Your blog description', 'fv_seo'); echo('</li>');
                        echo('<li>'); _e('%category_title% - The original title of the category', 'fv_seo'); echo('</li>');
                        echo('<li>'); _e('%category_description% - The description of the category', 'fv_seo'); echo('</li>');
                        echo('</ul>');
                        ?>
                    </div>
                </p>
    
                <p>
                    <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_archive_title_format_tip');">
                      <?php _e('Archive Title Format:', 'fv_seo')?>
                    </a><br />
                    <input size="59" name="fvseo_archive_title_format" value="<?php echo esc_attr(stripcslashes($fvseop_options['aiosp_archive_title_format'])); ?>"/>
                    <div style="max-width:500px; text-align:left; display:none" id="fvseo_archive_title_format_tip">
                        <?php
                        _e('The following macros are supported:', 'fv_seo');
                        echo('<ul>');
                        echo('<li>'); _e('%blog_title% - Your blog title', 'fv_seo'); echo('</li>');
                        echo('<li>'); _e('%blog_description% - Your blog description', 'fv_seo'); echo('</li>');
                        echo('<li>'); _e('%date% - The original archive title given by wordpress, e.g. "2007" or "2007 August"', 'fv_seo'); echo('</li>');
                        echo('</ul>');
                        ?>
                    </div>
                </p>
    
                <p>
                    <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_tag_title_format_tip');">
                      <?php _e('Tag Title Format:', 'fv_seo')?>
                    </a><br />
                    <input size="59" name="fvseo_tag_title_format" value="<?php echo esc_attr(stripcslashes($fvseop_options['aiosp_tag_title_format'])); ?>"/>
                    <div style="max-width:500px; text-align:left; display:none" id="fvseo_tag_title_format_tip">
                        <?php
                        _e('The following macros are supported:', 'fv_seo');
                        echo('<ul>');
                        echo('<li>'); _e('%blog_title% - Your blog title', 'fv_seo'); echo('</li>');
                        echo('<li>'); _e('%blog_description% - Your blog description', 'fv_seo'); echo('</li>');
                        echo('<li>'); _e('%tag% - The name of the tag', 'fv_seo'); echo('</li>');
                        echo('</ul>');
                        ?>
                    </div>
                </p>
    
                <p>
                    <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_search_title_format_tip');">
                      <?php _e('Search Title Format:', 'fv_seo')?>
                    </a><br />
                    <input size="59" name="fvseo_search_title_format" value="<?php echo esc_attr(stripcslashes($fvseop_options['aiosp_search_title_format'])); ?>"/>
                    <div style="max-width:500px; text-align:left; display:none" id="fvseo_search_title_format_tip">
                        <?php
                        _e('The following macros are supported:', 'fv_seo');
                        echo('<ul>');
                        echo('<li>'); _e('%blog_title% - Your blog title', 'fv_seo'); echo('</li>');
                        echo('<li>'); _e('%blog_description% - Your blog description', 'fv_seo'); echo('</li>');
                        echo('<li>'); _e('%search% - What was searched for', 'fv_seo'); echo('</li>');
                        echo('</ul>');
                        ?>
                    </div>
                </p>
    
                <p>
                    <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_description_format_tip');">
                      <?php _e('Description Format:', 'fv_seo')?>
                    </a><br />
                    <input size="59" name="fvseo_description_format" value="<?php echo esc_attr(stripcslashes($fvseop_options['aiosp_description_format'])); ?>" />
                    <div style="max-width:500px; text-align:left; display:none" id="fvseo_description_format_tip">
                        <?php
                        _e('The following macros are supported:', 'fv_seo');
                        echo('<ul>');
                        echo('<li>'); _e('%blog_title% - Your blog title', 'fv_seo'); echo('</li>');
                        echo('<li>'); _e('%blog_description% - Your blog description', 'fv_seo'); echo('</li>');
                        echo('<li>'); _e('%description% - The original description as determined by the plugin, e.g. the excerpt if one is set or an auto-generated one if that option is set', 'fv_seo'); echo('</li>');
                        echo('<li>'); _e('%wp_title% - The original wordpress title, e.g. post_title for posts', 'fv_seo'); echo('</li>');
                        echo('<li>'); _e('%page% - Page number for paged category archives', 'fv_seo'); echo('</li>');                        
                        echo('</ul>');
                        ?>
                    </div>
                </p>
    
                <p>
                    <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_404_title_format_tip');">
                      <?php _e('404 Title Format:', 'fv_seo')?>
                    </a><br />
                    <input size="59" name="fvseo_404_title_format" value="<?php echo esc_attr(stripcslashes($fvseop_options['aiosp_404_title_format'])); ?>"/>
                    <div style="max-width:500px; text-align:left; display:none" id="fvseo_404_title_format_tip">
                        <?php
                        _e('The following macros are supported:', 'fv_seo');
                        echo('<ul>');
                        echo('<li>'); _e('%blog_title% - Your blog title', 'fv_seo'); echo('</li>');
                        echo('<li>'); _e('%blog_description% - Your blog description', 'fv_seo'); echo('</li>');
                        echo('<li>'); _e('%request_url% - The original URL path, like "/url-that-does-not-exist/"', 'fv_seo'); echo('</li>');
                        echo('<li>'); _e('%request_words% - The URL path in human readable form, like "Url That Does Not Exist"', 'fv_seo'); echo('</li>');
                        echo('<li>'); _e('%404_title% - Additional 404 title input"', 'fv_seo'); echo('</li>');
                        echo('</ul>');
                        ?>
                    </div>
                </p>
    
                <p>
                    <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_paged_format_tip');">
                      <?php _e('Paged Format:', 'fv_seo')?>
                    </a><br />
                    <input size="59" name="fvseo_paged_format" value="<?php echo esc_attr(stripcslashes($fvseop_options['aiosp_paged_format'])); ?>"/>
                    <div style="max-width:500px; text-align:left; display:none" id="fvseo_paged_format_tip">
                        <?php
                        _e('This string gets appended/prepended to titles when they are for paged index pages (like home or archive pages).', 'fv_seo');
                        _e('The following macros are supported:', 'fv_seo');
                        echo('<ul>');
                        echo('<li>'); _e('%page% - The page number', 'fv_seo'); echo('</li>');
                        echo('</ul>');
                        ?>
                    </div>
                </p>
            </div>

            <p>
                <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_use_categories_tip');">
                  <?php _e('Use Categories for META keywords:', 'fv_seo')?>
                </a>
                <input type="checkbox" name="fvseo_use_categories" <?php if ($fvseop_options['aiosp_use_categories']) echo 'checked="checked"'; ?>/>
                <div style="max-width:500px; text-align:left; display:none" id="fvseo_use_categories_tip">
                  <?php _e('Check this if you want your categories for a given post used as the META keywords for this post (in addition to any keywords and tags you specify on the post edit page).', 'fv_seo')?>
                </div>
            </p>

            <p>
                <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_use_tags_as_keywords_tip');">
                  <?php _e('Use Tags for META keywords:', 'fv_seo')?>
                </a>
                <input type="checkbox" name="fvseo_use_tags_as_keywords" <?php if ($fvseop_options['aiosp_use_tags_as_keywords']) echo 'checked="checked"'; ?>/>
                <div style="max-width:500px; text-align:left; display:none" id="fvseo_use_tags_as_keywords_tip">
                  <?php _e('Check this if you want your tags for a given post used as the META keywords for this post (in addition to any keywords you specify on the post edit page).', 'fv_seo')?>
                </div>
            </p>

            <p>
                <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_dynamic_postspage_keywords_tip');">
                  <?php _e('Dynamically Generate Keywords for Posts Page:', 'fv_seo')?>
                </a>
                <input type="checkbox" name="fvseo_dynamic_postspage_keywords" <?php if ($fvseop_options['aiosp_dynamic_postspage_keywords']) echo 'checked="checked"'; ?>/>
                <div style="max-width:500px; text-align:left; display:none" id="fvseo_dynamic_postspage_keywords_tip">
                  <?php _e('Check this if you want your keywords on a custom posts page (set it in options->reading) to be dynamically generated from the keywords of the posts showing on that page.  If unchecked, it will use the keywords set in the edit page screen for the posts page.', 'fv_seo') ?>
                </div>
            </p>

            <p>
                <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_category_noindex_tip');">
                  <?php _e('Use noindex for Categories:', 'fv_seo')?>
                </a>
                <input type="checkbox" name="fvseo_category_noindex" <?php if ($fvseop_options['aiosp_category_noindex']) echo 'checked="checked"'; ?>/>
                <div style="max-width:500px; text-align:left; display:none" id="fvseo_category_noindex_tip">
                  <?php _e('Check this for excluding category pages from being crawled. Useful for avoiding duplicate content.', 'fv_seo')?>
                </div>
            </p>

            <p>
                <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_archive_noindex_tip');">
                  <?php _e('Use noindex for Archives:', 'fv_seo')?>
                </a>
                <input type="checkbox" name="fvseo_archive_noindex" <?php if ($fvseop_options['aiosp_archive_noindex']) echo 'checked="checked"'; ?>/>
                <div style="max-width:500px; text-align:left; display:none" id="fvseo_archive_noindex_tip">
                  <?php _e('Check this for excluding archive pages from being crawled. Useful for avoiding duplicate content.', 'fv_seo')?>
                </div>
            </p>

            <p>
                <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_tags_noindex_tip');">
                  <?php _e('Use noindex for Tag Archives:', 'fv_seo')?>
                </a>
                <input type="checkbox" name="fvseo_tags_noindex" <?php if ($fvseop_options['aiosp_tags_noindex']) echo 'checked="checked"'; ?>/>
                <div style="max-width:500px; text-align:left; display:none" id="fvseo_tags_noindex_tip">
                  <?php _e('Check this for excluding tag pages from being crawled. Useful for avoiding duplicate content.', 'fv_seo')?>
                </div>
            </p>

            <p>
                <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_search_noindex_tip');">
                  <?php _e('Use noindex for Search Results:', 'fv_seo')?>
                </a>
                <input type="checkbox" name="fvseo_search_noindex" <?php if ($fvseop_options['aiosp_search_noindex']) echo 'checked="checked"'; ?>/>
                <div style="max-width:500px; text-align:left; display:none" id="fvseo_search_noindex_tip">
                  <?php _e('Check this for excluding search results from being crawled. Useful for avoiding duplicate content.', 'fv_seo')?>
                </div>
            </p>

            <p>
                <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_generate_descriptions_tip');">
                  <?php _e('Autogenerate Descriptions:', 'fv_seo')?>
                </a>
                <input type="checkbox" name="fvseo_generate_descriptions" <?php if ($fvseop_options['aiosp_generate_descriptions']) echo 'checked="checked"'; ?>/>
                <div style="max-width:500px; text-align:left; display:none" id="fvseo_generate_descriptions_tip">
                  <?php _e("Check this and your META descriptions will get autogenerated if there's no excerpt.", 'fv_seo')?>
                </div>
            </p>

            <p>
                <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_cap_cats_tip');">
                  <?php _e('Capitalize Category Titles:', 'fv_seo')?>
                </a>
                <input type="checkbox" name="fvseo_cap_cats" <?php if ($fvseop_options['aiosp_cap_cats']) echo 'checked="checked"'; ?>/>
                <div style="max-width:500px; text-align:left; display:none" id="fvseo_cap_cats_tip">
                  <?php _e("Check this and Category Titles will have the first letter of each word capitalized.", 'fv_seo')?>
                </div>
            </p>

            <p>
                <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_ex_pages_tip');">
                  <?php _e('Exclude Pages:', 'fv_seo')?>
                </a><br />
                <textarea cols="57" rows="2" name="fvseo_ex_pages"><?php if( isset( $fvseop_options['aiosp_ex_pages'] ) ) echo esc_attr(stripcslashes($fvseop_options['aiosp_ex_pages']))?></textarea>
                <div style="max-width:500px; text-align:left; display:none" id="fvseo_ex_pages_tip">
                  <?php _e("Enter any comma separated pages here to be excluded by All in One SEO Pack.  This is helpful when using plugins which generate their own non-WordPress dynamic pages.  Ex: <em>/forum/,/contact/</em>  For instance, if you want to exclude the virtual pages generated by a forum plugin, all you have to do is give forum or /forum or /forum/ or and any URL with the word \"forum\" in it, such as http://mysite.com/forum or http://mysite.com/forum/someforumpage will be excluded from FV All in One SEO Pack.", 'fv_seo')?>
                </div>
            </p>

            <p>
                <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_post_meta_tags_tip');">
                  <?php _e('Additional Post Headers:', 'fv_seo')?>
                </a><br />
                <textarea cols="57" rows="2" name="fvseo_post_meta_tags"><?php echo htmlspecialchars(stripcslashes($fvseop_options['aiosp_post_meta_tags']))?></textarea>
                <div style="max-width:500px; text-align:left; display:none" id="fvseo_post_meta_tags_tip">
    <?php
    _e('What you enter here will be copied verbatim to your header on post pages. You can enter whatever additional headers you want here, even references to stylesheets.', 'fv_seo');
    echo '<br/>';
    _e('NOTE: This field currently only support meta tags.', 'fv_seo');
    ?>
                </div>
            </p>

            <p>
                <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_page_meta_tags_tip');">
                  <?php _e('Additional Page Headers:', 'fv_seo')?>
                </a><br />
                <textarea cols="57" rows="2" name="fvseo_page_meta_tags"><?php echo htmlspecialchars(stripcslashes($fvseop_options['aiosp_page_meta_tags']))?></textarea>
                <div style="max-width:500px; text-align:left; display:none" id="fvseo_page_meta_tags_tip">
    <?php
    _e('What you enter here will be copied verbatim to your header on pages. You can enter whatever additional headers you want here, even references to stylesheets.', 'fv_seo');
    echo '<br/>';
    _e('NOTE: This field currently only support meta tags.', 'fv_seo');
    ?>
                </div>
            </p>

            <p>
                <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_home_meta_tags_tip');">
                  <?php _e('Additional Home Headers:', 'fv_seo')?>
                </a><br />
                <textarea cols="57" rows="2" name="fvseo_home_meta_tags"><?php echo htmlspecialchars(stripcslashes($fvseop_options['aiosp_home_meta_tags']))?></textarea>
                <div style="max-width:500px; text-align:left; display:none" id="fvseo_home_meta_tags_tip">
    <?php
    _e('What you enter here will be copied verbatim to your header on the home page. You can enter whatever additional headers you want here, even references to stylesheets.', 'fv_seo');
    echo '<br/>';
    _e('NOTE: This field currently only support meta tags.', 'fv_seo');
    ?>
                </div>
            </p>

            <p>
                <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_home_google_site_verification_meta_tag_tip');">
                  <?php _e('Google Verification Meta Tag:', 'fv_seo')?>
                </a> <abbr title="We recommend you to use a single file instead for Google verification">(?)</abbr><br />
                <textarea cols="57" rows="1" name="fvseo_home_google_site_verification_meta_tag"><?php if( isset( $fvseop_options['aiosp_home_google_site_verification_meta_tag'] ) ) echo htmlspecialchars(stripcslashes($fvseop_options['aiosp_home_google_site_verification_meta_tag']))?></textarea>
                <div style="max-width:500px; text-align:left; display:none" id="fvseo_home_google_site_verification_meta_tag_tip">
    <?php
    _e('What you enter here will be copied verbatim to your header on the home page. Webmaster Tools provides the meta tag in XHTML syntax.', 'fv_seo');
    echo('<br/>');
    echo('1. '); _e('On the Webmaster Tools Home page, click Verify this site next to the site you want.', 'fv_seo');
    echo('<br/>');
    echo('2. '); _e('In the Verification method list, select Meta tag, and follow the steps on your screen.', 'fv_seo');
    echo('<br/>');
    _e('Once you have added the tag to your home page, click Verify.', 'fv_seo');
    ?>
                </div>
            </p>
            
            <p>
                <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_home_yahoo_site_verification_meta_tag');">
                  <?php _e('Yahoo Verification Meta Tag:', 'fv_seo')?>
                </a><br />
                <textarea cols="57" rows="1" name="fvseo_home_yahoo_site_verification_meta_tag"><?php if( isset( $fvseop_options['aiosp_home_yahoo_site_verification_meta_tag'] ) ) echo htmlspecialchars(stripcslashes($fvseop_options['aiosp_home_yahoo_site_verification_meta_tag']))?></textarea>
                <div style="max-width:500px; text-align:left; display:none" id="fvseo_home_yahoo_site_verification_meta_tag">
    <?php
    _e('Put your Yahoo site verification tag for your homepage here.', 'fv_seo');
    ?>
                </div>
            </p>
            
            <p>
                <a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_home_bing_site_verification_meta_tag');">
                  <?php _e('Bing Verification Meta Tag:', 'fv_seo')?>
                </a><br />
                <textarea cols="57" rows="1" name="fvseo_home_bing_site_verification_meta_tag"><?php if( isset( $fvseop_options['aiosp_home_bing_site_verification_meta_tag'] ) ) echo htmlspecialchars(stripcslashes($fvseop_options['aiosp_home_bing_site_verification_meta_tag']))?></textarea>
                <div style="max-width:500px; text-align:left; display:none" id="fvseo_home_bing_site_verification_meta_tag">
    <?php
    _e('Put your Bing site verification tag for your homepage here.', 'fv_seo');
    ?>
                </div>
            </p>                        

            <p>
		<a style="cursor:pointer;" title="<?php _e('Click for Help!', 'fv_seo')?>" onclick="toggleVisibility('fvseo_dont_use_excerpt_tip');">
		<?php _e('Turn off excerpts for descriptions:', 'fv_seo')?>
		</a>

		<input type="checkbox" name="fvseo_dont_use_excerpt" <?php if ($fvseop_options['aiosp_dont_use_excerpt']) echo "checked=\"1\""; ?>/>
		<div style="max-width:500px; text-align:left; display:none" id="fvseo_dont_use_excerpt_tip">
		<?php
		_e("Since Typepad export is containing auto generated excerpts for the most of the time we use this option a lot.", 'all_in_one_seo_pack');
		?>
		</div>
            </p>
        </div>

      <p class="submit">
        <?php if($fvseop_options) {  ?>
        <input type="hidden" name="action" value="fvseo_update" />
        <input type="hidden" name="nonce-fvseop" value="<?php echo esc_attr(wp_create_nonce('fvseopnonce')); ?>" />
        <input type="hidden" name="page_options" value="fvseo_home_description" />
        <input type="submit" class='button-primary' name="Submit" value="<?php _e('Update Options', 'fv_seo')?> &raquo;" />
        <input type="submit" class='button-primary' name="Submit_Default" value="<?php _e('Reset Settings to Defaults', 'fv_seo')?> &raquo;" />
      </p>
      <?php } ?>
    </form>
  </div>
  <?php
	} // options_panel
} // end fv_seo class

global $fvseop_options;

if (!get_option('aioseop_options'))
{
	fvseop_mrt_mkarry();
}

$fvseop_options = get_option('aioseop_options');

function fvseop_mrt_mkarry()
{
	$nfvseop_options = array(  //  todo - merge with reset options
		"aiosp_can"=>0,
		"aiosp_home_title"=>null,
		"aiosp_home_description"=>'',
		"aiosp_home_keywords"=>null,
		"aiosp_max_words_excerpt"=>'something',
		"aiosp_rewrite_titles"=>0,
		"aiosp_post_title_format"=>'%post_title% | %blog_title%',
		"aiosp_page_title_format"=>'%page_title% | %blog_title%',
		"aiosp_category_title_format"=>'%category_title% | %blog_title%',
		"aiosp_archive_title_format"=>'%date% | %blog_title%',
		"aiosp_tag_title_format"=>'%tag% | %blog_title%',
		"aiosp_search_title_format"=>'%search% | %blog_title%',
		"aiosp_description_format"=>'%description%',
		"aiosp_404_title_format"=>'Nothing found for %request_words%',
		"aiosp_paged_format"=>' - Part %page%',
		"aiosp_use_categories"=>1,
		"aiosp_dynamic_postspage_keywords"=>1,
		"aiosp_category_noindex"=>0,
		"aiosp_archive_noindex"=>0,
		"aiosp_tags_noindex"=>0,
		"aiosp_cap_cats"=>0,
		"aiosp_generate_descriptions"=>0,
		"aiosp_debug_info"=>null,
		"aiosp_post_meta_tags"=>'',
		"aiosp_page_meta_tags"=>'',
		"aiosp_home_meta_tags"=>'',
		'home_google_site_verification_meta_tag' => '',
		'aiosp_use_tags_as_keywords' => 1,
		///	Addition
    'aiosp_search_noindex'=>1,
		'aiosp_dont_use_excerpt'=>0,
		'aiosp_show_keywords'=>0,
		'aiosp_show_titleattribute'=>0,
		'aiosp_show_disable'=>0
		);
		///	End of addition

	if (get_option('aiosp_post_title_format'))
	{
		foreach ($nfvseop_options as $fvseop_opt_name => $value )
		{
			if ($fvseop_oldval = get_option($fvseop_opt_name))
			{
				$nfvseop_options[$fvseop_opt_name] = $fvseop_oldval;
			}
			
			if ($fvseop_oldval == '')
			{
				$nfvseop_options[$fvseop_opt_name] = '';
			}
        
			delete_option($fvseop_opt_name);
		}
	}

	add_option('aioseop_options',$nfvseop_options);

  /// this displays a warning message in WP 3.0
	//echo "<div class='updated fade' style='background-color:green;border-color:green;'><p><strong>Updating FV All in One SEO Pack configuration options in database</strong></p></div>";
}

function fvseop_nav_menu($content)
{
	$url = preg_replace(array('/\//', '/\./', '/\-/'), array('\/', '\.', '\-'), get_option('siteurl'));
	$pattern = '/<li id=\"menu-item-(\d+)\" class="menu-item(.*?)menu-item-(\d+)([^\"]*)"><a href=\"([^\"]+)"[^>]*?>([^<]+)<\/a>/i';
  /// db optimization
  preg_match_all( '~id=\"menu-item-(\d+)\"~', $content, $ids );  
  if( function_exists( 'update_meta_cache' ) && count( $ids[1] ) > 0 ) { update_meta_cache( 'post', $ids[1] ); }
  
  $menu_ids = array();
  foreach ($ids[1] as $id) {    
    $menu_ids[] = get_post_meta($id, '_menu_item_object_id', true); 
  }
  if( function_exists( 'update_meta_cache' ) && count( $menu_ids ) > 0 ) { update_meta_cache( 'post', $menu_ids ); }
  
  return preg_replace_callback($pattern, "fvseop_filter_menu_callback", $content);  
}

function fvseop_filter_menu_callback($matches)
{                      
  $postID = get_post_meta($matches[1], '_menu_item_object_id', true);      
  $my_post = get_post( $postID );      
           	
	if (empty($postID))
		$postID = get_option("page_on_front");
				       
  if ($my_post->post_title == $matches[6]) {
    $menulabel = stripslashes(get_post_meta($postID, '_aioseop_menulabel', true));
  }    
	
	if (empty($menulabel))
		$menulabel = $matches[6];    
                          
  $menulabel = __( $menulabel );  
  
  $filtered = '<li id="menu-item-' . $matches[1] . '" class="menu-item ' . $matches[2] . 'menu-item-' . $matches[1] . '"><a href="' . esc_attr($matches[5]) . '">' . esc_html($menulabel) . '</a>';	
	
	return $filtered;
}

function fvseop_list_pages($content)
{
	$url = preg_replace(array('/\//', '/\./', '/\-/'), array('\/', '\.', '\-'), get_option('siteurl'));
	$pattern = '/<li class="page_item page-item-(\d+)([^\"]*)"><a href=\"([^\"]+)"[^>]*?>([^<]+)<\/a>/i';
  /// db optimization
  preg_match_all( '~page-item-(\d+)~', $content, $ids );
  if( function_exists( 'update_meta_cache' ) && count( $ids[1] ) > 0 ) { update_meta_cache( 'post', $ids[1] ); }
  ///
	return preg_replace_callback($pattern, "fvseop_filter_callback", $content);
}

function fvseop_filter_callback($matches)
{        
  preg_match( '~title="([^\"]+)"~', $matches[0], $match_title );
  if( $match_title ) {
    $matches[4] = $match_title[1];
  }
  
	if ($matches[1] && !empty($matches[1]))
		$postID = $matches[1];
		
	if (empty($postID))
		$postID = get_option("page_on_front");
		
	$title_attrib = stripslashes(get_post_meta($postID, '_aioseop_titleatr', true));
	$menulabel = stripslashes(get_post_meta($postID, '_aioseop_menulabel', true));
	
	if (empty($menulabel))
		$menulabel = $matches[4];
               
  /// Addition
  $longtitle = stripslashes(get_post_meta($postID, '_aioseop_title', true));
            
  $menulabel = __( $menulabel );  
  $longtitle = __( $longtitle );  
  $title_attrib = __( $title_attrib );       
  if( isset($matches[4]) ) {
    $matches[4] = __( $matches[4] );
  }
		
	if (!empty($title_attrib)) :
		$filtered = '<li class="page_item page-item-' . $postID.$matches[2] . '"><a href="' . esc_attr($matches[3]) . '" title="' . esc_attr($title_attrib) . '">' . esc_html($menulabel) . '</a>';
  /// Addition
  elseif (!empty($longtitle)) :
          $filtered = '<li class="page_item page-item-' . $postID.$matches[2] . '"><a href="' . esc_attr($matches[3]) . '" title="' . esc_attr($longtitle) . '">' . esc_html($menulabel) . '</a>';
  /// End of addition
	else :
    	$filtered = '<li class="page_item page-item-' . $postID.$matches[2] . '"><a href="' . esc_attr($matches[3]) . '" title="' . esc_attr($matches[4]) . '">' . esc_html($menulabel) . '</a>';
	endif;    
	
	return $filtered;
}

function fvseo_meta()
{
	global $post;
	global $fvseo;
	
	$post_id = $post;
	
	if (is_object($post_id))
	{
		$post_id = $post_id->ID;
	}
	$url = str_replace('http://','',get_permalink());
 	$keywords = esc_attr(htmlspecialchars(stripcslashes(get_post_meta($post_id, '_aioseop_keywords', true))));
	$title = esc_attr(htmlspecialchars(stripcslashes(get_post_meta($post_id, '_aioseop_title', true))));
	$custom_canonical = esc_attr(htmlspecialchars(stripcslashes(get_post_meta($post_id, '_aioseop_custom_canonical', true))));
	$description = esc_attr(htmlspecialchars(stripcslashes(get_post_meta($post_id, '_aioseop_description', true))));
	$fvseo_meta = esc_attr(htmlspecialchars(stripcslashes(get_post_meta($post_id, '_aioseop_meta', true))));
	$fvseo_disable = esc_attr(htmlspecialchars(stripcslashes(get_post_meta($post_id, '_aioseop_disable', true))));
	$fvseo_titleatr = esc_attr(htmlspecialchars(stripcslashes(get_post_meta($post_id, '_aioseop_titleatr', true))));
	$fvseo_menulabel = esc_attr(htmlspecialchars(stripcslashes(get_post_meta($post_id, '_aioseop_menulabel', true))));
	
	if( $title ) {
	  $title_preview = 	$title;
	} elseif( $title_preview = get_the_title( $post_id ) ) {
	} else {
	  $title_preview = "Fill in your title";
	}
	
	$fvseop_options = get_option('aioseop_options');
	
?>
<script type="text/javascript">
var fvseop_language = '<?php if (function_exists("qtrans_getLanguage")) echo qtrans_getLanguage(); else echo "default"; ?>';
var fvseop_languages;
var fvseop_active_lang = fvseop_language;
<?php if (function_exists("qtrans_getSortedLanguages")) { ?>
fvseop_languages =  <?php echo json_encode(qtrans_getSortedLanguages()); ?>;
<?php } ?>

function countChars(field, cntfield, lang)
{
  if( !field.value ) return;
  
  cntfield.value = field.value.length;

  if( field.name == 'fvseo_description' || field.name == 'fvseo_description' + '_' + lang ) {
	  if( field.value.length > <?php echo $fvseo->maximum_description_length; ?> ) {
	  	if (lang == 'default') {
        jQuery('#lengthD').css('background', 'red').css('color', 'black');
      }
      else {
        jQuery('#lengthD' + '_' + lang).css('background', 'red').css('color', 'black');
      }
	  }
	  else if( field.value.length > <?php echo $fvseo->maximum_description_length_yellow; ?> ) {
	  	if (lang == 'default') {
        jQuery('#lengthD').css('background', 'yellow').css('color', 'black');
      }
      else {
        jQuery('#lengthD' + '_' + lang).css('background', 'yellow').css('color', 'black');
      }
	  }
	  else {
	  	if (lang == 'default') {
        jQuery('#lengthD').css('background', 'white').css('color', 'black');
      }
      else {
        jQuery('#lengthD' + '_' + lang).css('background', 'white').css('color', 'black');
      }
	  }
  }
  else if( field.name == 'fvseo_title' || field.name == 'fvseo_title' + '_' + lang ) {
	  if( field.value.length > <?php echo $fvseo->maximum_title_length; ?> ) {
	  	if (lang == 'default') {
        jQuery('#lengthT').css('background', 'red').css('color', 'black');
      }
      else {
        jQuery('#lengthT' + '_' + lang).css('background', 'red').css('color', 'black');
      }
	  }
	  else {
      if (lang == 'default') {
        jQuery('#lengthT').css('background', 'white').css('color', 'black');
      }
      else {
        jQuery('#lengthT' + '_' + lang).css('background', 'white').css('color', 'black');
      }
	  }
  }
}
function fvseo_timeout() {
  FVSimplerSEO_updateTitle();
  FVSimplerSEO_updateTitleFromWPTitle();
  FVSimplerSEO_updateMeta();
  FVSimplerSEO_updateLink();
  window.setTimeout("fvseo_timeout();", 1000);
}
function FVSimplerSEO_updateLink()
{
  if( jQuery( "#sample-permalink" ).length > 0 ) {
    url = jQuery("#sample-permalink").text();
    url = url.replace( 'http://', '' );
    jQuery("#fvseo_href").html(url);
  }
}
function FVSimplerSEO_updateTitleFromWPTitle()
{  
  if (fvseop_language == 'default') {
    if( jQuery( "#fvseo_title_input" ).hasClass( 'linked-to-wp-title' ) ) {
      jQuery( "#fvseo_title_input" ).val( jQuery( "#title" ).val() );
    }
  }
  else {
    for (i = 0; i < fvseop_languages.length; i++) {
      if (jQuery( "#fvseo_title_input_" + fvseop_languages[i] ).hasClass( 'linked-to-wp-title') ) {
        jQuery( "#fvseo_title_input_" + fvseop_languages[i] ).val( jQuery( "#qtrans_title_" + fvseop_languages[i] ).val() );
      }  
    }
  }
}
function FVSimplerSEO_updateMeta()
{
  meta = FVSimplerSEO_getLocalized('fvseo_description_input');
  meta_add_dots = '';
  if( meta.length > <?php echo $fvseo->maximum_description_length; ?> ) {
    meta_add_dots = ' ...';
  }
  meta = meta.substr(0, <?php echo $fvseo->maximum_description_length; ?>) + meta_add_dots;
  if(meta == ''){
    meta = 'Fill in your meta description';
  }
  jQuery("p#fvseo_meta").html(meta);
}
function FVSimplerSEO_updateTitle()
{
  title = FVSimplerSEO_getLocalized('fvseo_title_input');
  title_add_dots = '';
  if( title.length > <?php echo $fvseo->maximum_title_length; ?> ) {
    title_add_dots = ' ...';
  }
  title = title.substr(0, <?php echo $fvseo->maximum_title_length; ?>) + title_add_dots;
  if (title == ''){
    if( jQuery("#title").val() ) {
      title = jQuery("#title").val();
    } else {
      title = 'Fill in your title';
    }
  }
  url = jQuery("#sample-permalink").text();
  jQuery("h2#fvseo_title").html( '<a href="'+url+'">'+title+'</a>');
}
function FVSimplerSEO_getLocalized(input)
{
  if (fvseop_language == 'default') {
    string = jQuery("#" + input).val();    
  }
  else {
    string = jQuery('#' + input + '_' + fvseop_active_lang).val();
  }    
  return string;
}
jQuery(document).ready(function($) {
  window.setTimeout("fvseo_timeout();", 500);  
  if (fvseop_language == 'default') {
    <?php if( !$title ) : ?>
    if( jQuery( "#title" ).length > 0 ) {
      //jQuery( "#fvseo_title_input" ).val( jQuery( "#title" ).val() );
      jQuery( "#fvseo_title_input" ).css( 'color', '#bbb' );
      jQuery( "#fvseo_title_input" ).addClass( 'linked-to-wp-title' );
    }
    jQuery( "#fvseo_title_input" ).focus( function() {
      jQuery( this ).removeClass( 'linked-to-wp-title' );
      jQuery( this ).css( 'color', '#000' );
    } );
    <?php endif; ?>
  }
  else {
    for (i = 0; i < fvseop_languages.length; i++) {
      if( jQuery( "#qtrans_title_" + fvseop_languages[i] ).val() == jQuery( "#fvseo_title_input_" + fvseop_languages[i] ).val() ) {
        jQuery( "#fvseo_title_input_" + fvseop_languages[i] ).css( 'color', '#bbb' );
        jQuery( "#fvseo_title_input_" + fvseop_languages[i] ).addClass( 'linked-to-wp-title' );
      }
      jQuery( "#fvseo_title_input_" + fvseop_languages[i] ).focus( function() {
        jQuery( this ).removeClass( 'linked-to-wp-title' ); jQuery( this ).css( 'color', '#000' );
        fvseop_active_lang = jQuery( this ).attr("id").substr('fvseo_title_input_'.length);
      } );
      jQuery( "#fvseo_description_input_" + fvseop_languages[i] ).focus( function() {
        fvseop_active_lang = jQuery( this ).attr("id").substr('fvseo_description_input_'.length);
      } );      
    }
  }  
});
</script>
<style type="text/css">
#fvsimplerseopack th { font-size: 90%; } 
#fvsimplerseopack .inputcounter { font-size: 85%; padding: 0px; text-align: center; background: white; color: #000;  }
#fvsimplerseopack .input { width: 99%; }
#fvsimplerseopack small { color: #999; }
#fvsimplerseopack abbr { color: #999; margin-right: 10px;}
#fvsimplerseopack small.link {color:#36C;font-size:13px;cursor:pointer;}
#fvsimplerseopack small#fvseo_href { color: #0E774A !important; margin-left:15px; font-family:arial, sans-serif;font-style:normal;font-size:13px;}
#fvsimplerseopack small.link:hover {text-decoration:underline;}
#fvsimplerseopack p#fvseo_meta {margin:0;padding:0; margin-left:15px; font-family:arial, sans-serif;font-style:normal;font-size:13px;max-width:546px;}
#fvsimplerseopack h2 {margin:0;padding:0; color:#2200c1; font-family:arial, sans-serif; font-style:normal; font-size:16px; text-decoration:underline; margin-left:15px; display:inline; padding-bottom:0px; cursor:pointer; line-height: 18px; }
#fvsimplerseopack h2 a { color:#2200c1; }
</style>
  <input value="fvseo_edit" type="hidden" name="fvseo_edit" />
  <input type="hidden" name="nonce-fvseopedit" value="<?php echo esc_attr(wp_create_nonce('edit-fvseopnonce')) ?>" />

        <?php if (function_exists('qtrans_getSortedLanguages')) { ?>
        <?php
          $languages = qtrans_getSortedLanguages();          
          foreach($languages as $language) { ?>
            <?php            
              $localized_title = fvseo_get_localized_string($title, $language); 
            ?>
            <p>
                <?php _e('Long Title:', 'fv_seo') ?> (<?php echo qtrans_getLanguageName($language); ?>) <abbr title="Displayed in browser toolbar and search engine results. It will replace your post title format defined by your template on this single post/page. For advanced customization use Rewrite Titles in Advanced Options.">(?)</abbr>
                <input id="fvseo_title_input_<?php echo $language; ?>" class="input" value="<?php echo $localized_title ?>" type="text" name="fvseo_title_<?php echo $language; ?>" onkeydown="countChars(document.post.fvseo_title_<?php echo $language; ?>,document.post.lengthT_<?php echo $language; ?>, '<?php echo $language ?>');" onkeyup="countChars(document.post.fvseo_title_<?php echo $language; ?>,document.post.lengthT_<?php echo $language; ?>, '<?php echo $language ?>');" />
                <br />
                <input id="lengthT_<?php echo $language; ?>" class="inputcounter" readonly="readonly" type="text" name="lengthT_<?php echo $language; ?>" size="3" maxlength="3" value="<?php echo strlen($localized_title);?>" />
                <small><?php _e(' characters. Most search engines use a maximum of '.$fvseo->maximum_title_length.' chars for the title.', 'fv_seo') ?></small>
            </p>
                    
        <?php } ?>
        <?php
          $languages = qtrans_getSortedLanguages();
          foreach($languages as $language) { ?>
            <?php            
              $localized_description = fvseo_get_localized_string($description, $language);
            ?>
            <p>
                <?php _e('Meta Description:', 'fv_seo') ?> (<?php echo qtrans_getLanguageName($language); ?>) <abbr title="Displayed in search engine results. Can be called inside of template file with &lt;?php echo get_post_meta('_aioseop_description',$post->ID); ?&gt;">(?)</abbr>
                <textarea id="fvseo_description_input_<?php echo $language; ?>" class="input" name="fvseo_description_<?php echo $language; ?>" rows="2" onkeydown="countChars(document.post.fvseo_description_<?php echo $language; ?>,document.post.lengthD_<?php echo $language; ?>, '<?php echo $language ?>')"
                  onkeyup="countChars(document.post.fvseo_description_<?php echo $language; ?>,document.post.lengthD_<?php echo $language; ?>, '<?php echo $language ?>');"><?php echo $localized_description ?></textarea>
                <br />
                <input id="lengthD_<?php echo $language; ?>" class="inputcounter" readonly="readonly" type="text" name="lengthD_<?php echo $language; ?>" size="3" maxlength="3" value="<?php echo strlen($localized_description);?>" />
                <small><?php _e(' characters. Most search engines use a maximum of '.$fvseo->maximum_description_length.' chars for the description.', 'fv_seo') ?></small>
            </p>
        <?php } ?>
        <?php } else { ?>
        <p>
            <?php _e('Long Title:', 'fv_seo') ?> <abbr title="Displayed in browser toolbar and search engine results. It will replace your post title format defined by your template on this single post/page. For advanced customization use Rewrite Titles in Advanced Options.">(?)</abbr>
            <input id="fvseo_title_input" class="input" value="<?php echo $title ?>" type="text" name="fvseo_title" onkeydown="countChars(document.post.fvseo_title,document.post.lengthT, 'default');" onkeyup="countChars(document.post.fvseo_title,document.post.lengthT, 'default');" />
            <br />
            <input id="lengthT" class="inputcounter" readonly="readonly" type="text" name="lengthT" size="3" maxlength="3" value="<?php echo strlen($title);?>" />
            <small><?php _e(' characters. Most search engines use a maximum of '.$fvseo->maximum_title_length.' chars for the title.', 'fv_seo') ?></small>
        </p>
        <p>
            <?php _e('Meta Description:', 'fv_seo') ?> <abbr title="Displayed in search engine results. Can be called inside of template file with &lt;?php echo get_post_meta('_aioseop_description',$post->ID); ?&gt;">(?)</abbr>
            <textarea id="fvseo_description_input" class="input" name="fvseo_description" rows="2" onkeydown="countChars(document.post.fvseo_description,document.post.lengthD, 'default')"
              onkeyup="countChars(document.post.fvseo_description,document.post.lengthD, 'default');"><?php echo $description ?></textarea>
            <br />
            <input id="lengthD" class="inputcounter" readonly="readonly" type="text" name="lengthD" size="3" maxlength="3" value="<?php echo strlen($description);?>" />
            <small><?php _e(' characters. Most search engines use a maximum of '.$fvseo->maximum_description_length.' chars for the description.', 'fv_seo') ?></small>
        </p>
        <?php } ?>
        <div>
            <p><?php _e('SERP Preview:', 'fv_seo') ?> <abbr title="Preview of Search Engine Results Page">(?)</abbr></p>
            <h2 id="fvseo_title"><a href="<?php the_permalink(); ?>" target="_blank"><?php echo $title_preview; ?></a></h2>
            <p id="fvseo_meta"><?php echo ($description) ? $description : "Fill in your meta description" ?></p>
            <small id="fvseo_href"><?php echo $url; ?></small> - <small class="link">Cached</small> - <small class="link">Similar</small>
            <br /><br />
        </div>

    <?php if ($fvseop_options['aiosp_show_keywords']) : ?>
        <p>
            <?php _e('Keywords:', 'fv_seo') ?> <small>(comma separated)</small>
            <input class="input" value="<?php echo $keywords ?>" type="text" name="fvseo_keywords" />
        </p>    
    <?php endif; ?>
    
    <?php if ($fvseop_options['aiosp_show_custom_canonical']) : ?>
        <p>
            <?php _e('Custom Canonical URL:', 'fv_seo') ?> <abbr title="WARNING - Google will index the URL you enter here instead of the post. Leave empty if you don't want to use it.">(?)</abbr>
            <input class="input" value="<?php echo $custom_canonical ?>" type="text" name="fvseo_custom_canonical" />
        </p>    
    <?php endif; ?>    

<?php if($post->post_type == 'page') { ?>
    
    <?php if ($fvseop_options['aiosp_show_titleattribute']) : ?>
        <p>
            <?php _e('Title Attribute:', 'fv_seo') ?> <abbr title="Displayed in search engine results">(?)</abbr>
            <input class="input" value="<?php echo $fvseo_titleatr ?>" type="text" name="fvseo_titleatr" size="62"/>
        </p>
    <?php endif; ?>
        
        <p>
            <?php _e('Short title | Menu Label:', 'fv_seo') ?> <abbr title="Used in all your page menus. Long Title or Post Title will be used for mouse rollover. Can be called inside of template file with &lt;?php echo get_post_meta('_aioseop_menulabel',$post->ID); ?&gt;">(?)</abbr>
            <input class="input" value="<?php echo $fvseo_menulabel ?>" type="text" name="fvseo_menulabel" size="62"/>
        </p>

<?php } ?>
    
    <?php if ($fvseop_options['aiosp_show_disable']) : ?>
        <p>
            <?php _e('Disable on this page/post:', 'fv_seo')?>
            <input type="checkbox" name="fvseo_disable" <?php if ($fvseo_disable) echo 'checked="checked"'; ?>/>
        </p>
    <?php endif; ?>
    
    <?php if (!function_exists('qtrans_getSortedLanguages')) { ?>
      <script type="text/javascript">
      countChars(document.post.fvseo_description,document.post.lengthD, 'default');
      countChars(document.post.fvseo_title,document.post.lengthT, 'default');
      </script>
    <?php } ?>
<?php
}

function fvseo_get_localized_string($string, $language)
{
  $strings_array = explode('&lt;!--:--&gt;', $string);
  $language_code =  '&lt;!--:' . $language . '--&gt;';
  foreach($strings_array as $string) {
    if (substr($string, 0, strlen($language_code)) == $language_code) {
      return substr($string, strlen($language_code)); 
    }  
  }
}

function fvseo_meta_box_add()
{
	add_meta_box('fvsimplerseopack',__('FV Simpler SEO', 'fv_seo'), 'fvseo_meta', 'post');
	add_meta_box('fvsimplerseopack',__('FV Simpler SEO', 'fv_seo'), 'fvseo_meta', 'page');
}

if ($fvseop_options['aiosp_can'] == '1' || $fvseop_options['aiosp_can'] === 'on')
{
	remove_action('wp_head', 'rel_canonical');
}

add_action('admin_menu', 'fvseo_meta_box_add');
add_action('wp_list_pages', 'fvseop_list_pages');
add_action('wp_nav_menu', 'fvseop_nav_menu');

$fvseo = new FV_Simpler_SEO_Pack();

add_action('init', array($fvseo, 'init'));
add_action('template_redirect', array($fvseo, 'template_redirect'));
add_action('wp_head', array($fvseo, 'wp_head'));
add_action('wp_head', array($fvseo, 'remove_canonical'), 0 );
add_action('edit_post', array($fvseo, 'post_meta_tags'));
add_action('publish_post', array($fvseo, 'post_meta_tags'));
add_action('save_post', array($fvseo, 'post_meta_tags'));
add_action('edit_page_form', array($fvseo, 'post_meta_tags'));
add_action('admin_menu', array($fvseo, 'admin_menu'));

?>