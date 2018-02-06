/** @license Hyphenator 5.2.0(devel) - client side hyphenation for webbrowsers
 *  Copyright (C) 2015  Mathias Nater, Zürich (mathiasnater at gmail dot com)
 *  https://github.com/mnater/Hyphenator
 *
 *  Released under the MIT license
 *  http://mnater.github.io/Hyphenator/LICENSE.txt
 */

/*
 * Comments are jsdoc3 formatted. See http://usejsdoc.org
 * Use mergeAndPack.html to get rid of the comments and to reduce the file size of this script!
 */

/* The following comment is for JSLint: */
/*jslint browser: true, multivar: true*/
/*global Hyphenator window*/

/**
 * @desc Provides all functionality to do hyphenation, except the patterns that are loaded externally
 * @global
 * @namespace Hyphenator
 * @author Mathias Nater, <mathias@mnn.ch>
 * @version 5.2.0(devel)
 * @example
 * &lt;script src = "Hyphenator.js" type = "text/javascript"&gt;&lt;/script&gt;
 * &lt;script type = "text/javascript"&gt;
 *   Hyphenator.run();
 * &lt;/script&gt;
 */
var Hyphenator;
Hyphenator = (function (window) {
    'use strict';

    /**
     * @member Hyphenator~contextWindow
     * @access private
     * @desc
     * contextWindow stores the window for the actual document to be hyphenated.
     * If there are frames this will change.
     * So use contextWindow instead of window!
     */
    var contextWindow = window;


    /**
     * @member {Object.<string, Hyphenator~supportedLangs~supportedLanguage>} Hyphenator~supportedLangs
     * @desc
     * A generated key-value object that stores supported languages and meta data.
     * The key is the {@link http://tools.ietf.org/rfc/bcp/bcp47.txt bcp47} code of the language and the value
     * is an object of type {@link Hyphenator~supportedLangs~supportedLanguage}
     * @namespace Hyphenator~supportedLangs
     * @access private
     * //Check if language lang is supported:
     * if (supportedLangs.hasOwnProperty(lang))
     */
    var supportedLangs = (function () {
        /**
         * @typedef {Object} Hyphenator~supportedLangs~supportedLanguage
         * @property {string} file - The name of the pattern file
         * @property {number} script - The script type of the language (e.g. 'latin' for english), this type is abbreviated by an id
         * @property {string} prompt - The sentence prompted to the user, if Hyphenator.js doesn't find a language hint
         */

        /**
         * @lends Hyphenator~supportedLangs
         */
        var r = {},
            /**
             * @method Hyphenator~supportedLangs~o
             * @desc
             * Sets a value of Hyphenator~supportedLangs
             * @access protected
             * @param {string} code The {@link http://tools.ietf.org/rfc/bcp/bcp47.txt bcp47} code of the language
             * @param {string} file The name of the pattern file
             * @param {Number} script A shortcut for a specific script: latin:0, cyrillic: 1, arabic: 2, armenian:3, bengali: 4, devangari: 5, greek: 6
             * gujarati: 7, kannada: 8, lao: 9, malayalam: 10, oriya: 11, persian: 12, punjabi: 13, tamil: 14, telugu: 15
             * @param {string} prompt The sentence prompted to the user, if Hyphenator.js doesn't find a language hint
             */
            o = function (code, file, script, prompt) {
                r[code] = {'file': file, 'script': script, 'prompt': prompt};
            };

        o('be', 'be.js', 1, 'Мова гэтага сайта не можа быць вызначаны аўтаматычна. Калі ласка пакажыце мову:');
        o('ca', 'ca.js', 0, '');
        o('cs', 'cs.js', 0, 'Jazyk této internetové stránky nebyl automaticky rozpoznán. Určete prosím její jazyk:');
        o('da', 'da.js', 0, 'Denne websides sprog kunne ikke bestemmes. Angiv venligst sprog:');
        o('bn', 'bn.js', 4, '');
        o('de', 'de.js', 0, 'Die Sprache dieser Webseite konnte nicht automatisch bestimmt werden. Bitte Sprache angeben:');
        o('el', 'el-monoton.js', 6, '');
        o('el-monoton', 'el-monoton.js', 6, '');
        o('el-polyton', 'el-polyton.js', 6, '');
        o('en', 'en-us.js', 0, 'The language of this website could not be determined automatically. Please indicate the main language:');
        o('en-gb', 'en-gb.js', 0, 'The language of this website could not be determined automatically. Please indicate the main language:');
        o('en-us', 'en-us.js', 0, 'The language of this website could not be determined automatically. Please indicate the main language:');
        o('eo', 'eo.js', 0, 'La lingvo de ĉi tiu retpaĝo ne rekoneblas aŭtomate. Bonvolu indiki ĝian ĉeflingvon:');
        o('es', 'es.js', 0, 'El idioma del sitio no pudo determinarse autom%E1ticamente. Por favor, indique el idioma principal:');
        o('et', 'et.js', 0, 'Veebilehe keele tuvastamine ebaõnnestus, palun valige kasutatud keel:');
        o('fi', 'fi.js', 0, 'Sivun kielt%E4 ei tunnistettu automaattisesti. M%E4%E4rit%E4 sivun p%E4%E4kieli:');
        o('fr', 'fr.js', 0, 'La langue de ce site n%u2019a pas pu %EAtre d%E9termin%E9e automatiquement. Veuillez indiquer une langue, s.v.p.%A0:');
        o('ga', 'ga.js', 0, 'Níorbh fhéidir teanga an tsuímh a fháil go huathoibríoch. Cuir isteach príomhtheanga an tsuímh:');
        o('grc', 'grc.js', 6, '');
        o('gu', 'gu.js', 7, '');
        o('hi', 'hi.js', 5, '');
        o('hu', 'hu.js', 0, 'A weboldal nyelvét nem sikerült automatikusan megállapítani. Kérem adja meg a nyelvet:');
        o('hy', 'hy.js', 3, 'Չհաջողվեց հայտնաբերել այս կայքի լեզուն։ Խնդրում ենք նշեք հիմնական լեզուն՝');
        o('it', 'it.js', 0, 'Lingua del sito sconosciuta. Indicare una lingua, per favore:');
        o('kn', 'kn.js', 8, 'ಜಾಲ ತಾಣದ ಭಾಷೆಯನ್ನು ನಿರ್ಧರಿಸಲು ಸಾಧ್ಯವಾಗುತ್ತಿಲ್ಲ. ದಯವಿಟ್ಟು ಮುಖ್ಯ ಭಾಷೆಯನ್ನು ಸೂಚಿಸಿ:');
        o('la', 'la.js', 0, '');
        o('lt', 'lt.js', 0, 'Nepavyko automatiškai nustatyti šios svetainės kalbos. Prašome įvesti kalbą:');
        o('lv', 'lv.js', 0, 'Šīs lapas valodu nevarēja noteikt automātiski. Lūdzu norādiet pamata valodu:');
        o('ml', 'ml.js', 10, 'ഈ വെ%u0D2C%u0D4D%u200Cസൈറ്റിന്റെ ഭാഷ കണ്ടുപിടിയ്ക്കാ%u0D28%u0D4D%u200D കഴിഞ്ഞില്ല. ഭാഷ ഏതാണെന്നു തിരഞ്ഞെടുക്കുക:');
        o('nb', 'nb-no.js', 0, 'Nettstedets språk kunne ikke finnes automatisk. Vennligst oppgi språk:');
        o('no', 'nb-no.js', 0, 'Nettstedets språk kunne ikke finnes automatisk. Vennligst oppgi språk:');
        o('nb-no', 'nb-no.js', 0, 'Nettstedets språk kunne ikke finnes automatisk. Vennligst oppgi språk:');
        o('nl', 'nl.js', 0, 'De taal van deze website kan niet automatisch worden bepaald. Geef de hoofdtaal op:');
        o('or', 'or.js', 11, '');
        o('pa', 'pa.js', 13, '');
        o('pl', 'pl.js', 0, 'Języka tej strony nie można ustalić automatycznie. Proszę wskazać język:');
        o('pt', 'pt.js', 0, 'A língua deste site não pôde ser determinada automaticamente. Por favor indique a língua principal:');
        o('ru', 'ru.js', 1, 'Язык этого сайта не может быть определен автоматически. Пожалуйста укажите язык:');
        o('sk', 'sk.js', 0, '');
        o('sl', 'sl.js', 0, 'Jezika te spletne strani ni bilo mogoče samodejno določiti. Prosim navedite jezik:');
        o('sr-cyrl', 'sr-cyrl.js', 1, 'Језик овог сајта није детектован аутоматски. Молим вас наведите језик:');
        o('sr-latn', 'sr-latn.js', 0, 'Jezika te spletne strani ni bilo mogoče samodejno določiti. Prosim navedite jezik:');
        o('sv', 'sv.js', 0, 'Spr%E5ket p%E5 den h%E4r webbplatsen kunde inte avg%F6ras automatiskt. V%E4nligen ange:');
        o('ta', 'ta.js', 14, '');
        o('te', 'te.js', 15, '');
        o('tr', 'tr.js', 0, 'Bu web sitesinin dili otomatik olarak tespit edilememiştir. Lütfen dökümanın dilini seçiniz%A0:');
        o('uk', 'uk.js', 1, 'Мова цього веб-сайту не може бути визначена автоматично. Будь ласка, вкажіть головну мову:');
        o('ro', 'ro.js', 0, 'Limba acestui sit nu a putut fi determinată automat. Alege limba principală:');

        return r;
    }());

    /**
     * @member {Object} Hyphenator~locality
     * @desc
     * An object storing isBookmarklet, basePath and isLocal
     * @access private
     * @see {@link Hyphenator~loadPatterns}
     */
    var locality = (function getLocality() {
        var r = {
                isBookmarklet: false,
                basePath: "//mnater.github.io/Hyphenator/",
                isLocal: false
            },
            scripts = contextWindow.document.getElementsByTagName('script'),
            i = 0,
            src,
            len = scripts.length,
            p,
            currScript;
        while (i < len) {
            currScript = scripts[i];
            if (currScript.hasAttribute("src")) {
                src = currScript.src;
                p = src.indexOf("Hyphenator.js");
                if (p !== -1) {
                    r.basePath = src.substring(0, p);
                    if (src.indexOf("Hyphenator.js?bm=true") !== -1) {
                        r.isBookmarklet = true;
                    }
                    if (window.location.href.indexOf(r.basePath) !== -1) {
                        r.isLocal = true;
                    }
                    break;
                }
            }
            i += 1;
        }
        return r;
    }());

    /**
     * @member {string} Hyphenator~basePath
     * @desc
     * A string storing the basepath from where Hyphenator.js was loaded.
     * This is used to load the pattern files.
     * The basepath is determined dynamically in getLocality by searching all script-tags for Hyphenator.js
     * If the path cannot be determined {@link http://mnater.github.io/Hyphenator/} is used as fallback.
     * @access private
     * @see {@link Hyphenator~loadPatterns}
     */
    var basePath = locality.basePath;

    /**
     * @member {boolean} Hyphenator~isLocal
     * @access private
     * @desc
     * This is computed by getLocality.
     * isLocal is true, if Hyphenator is loaded from the same domain, as the webpage, but false, if
     * it's loaded from an external source (i.e. directly from github)
     */
    var isLocal = locality.isLocal;

    /**
     * @member {boolean} Hyphenator~documentLoaded
     * @access private
     * @desc
     * documentLoaded is true, when the DOM has been loaded. This is set by {@link Hyphenator~runWhenLoaded}
     */
    var documentLoaded = false;

    /**
     * @member {boolean} Hyphenator~persistentConfig
     * @access private
     * @desc
     * if persistentConfig is set to true (defaults to false), config options and the state of the
     * toggleBox are stored in DOM-storage (according to the storage-setting). So they haven't to be
     * set for each page.
     * @default false
     * @see {@link Hyphenator.config}
     */
    var persistentConfig = false;

    /**
     * @member {boolean} Hyphenator~doFrames
     * @access private
     * @desc
     * switch to control if frames/iframes should be hyphenated, too.
     * defaults to false (frames are a bag of hurt!)
     * @default false
     * @see {@link Hyphenator.config}
     */
    var doFrames = false;

    /**
     * @member {Object.<string,boolean>} Hyphenator~dontHyphenate
     * @desc
     * A key-value object containing all html-tags whose content should not be hyphenated
     * @access private
     */
    var dontHyphenate = {'video': true, 'audio': true, 'script': true, 'code': true, 'pre': true, 'img': true, 'br': true, 'samp': true, 'kbd': true, 'var': true, 'abbr': true, 'acronym': true, 'sub': true, 'sup': true, 'button': true, 'option': true, 'label': true, 'textarea': true, 'input': true, 'math': true, 'svg': true, 'style': true};

    /**
     * @member {boolean} Hyphenator~enableCache
     * @desc
     * A variable to set if caching is enabled or not
     * @default true
     * @access private
     * @see {@link Hyphenator.config}
     */
    var enableCache = true;

    /**
     * @member {string} Hyphenator~storageType
     * @desc
     * A variable to define what html5-DOM-Storage-Method is used ('none', 'local' or 'session')
     * @default 'local'
     * @access private
     * @see {@link Hyphenator.config}
     */
    var storageType = 'local';

    /**
     * @member {Object|undefined} Hyphenator~storage
     * @desc
     * An alias to the storage defined in storageType. This is set by {@link Hyphenator~createStorage}.
     * Set by {@link Hyphenator.run}
     * @default null
     * @access private
     * @see {@link Hyphenator~createStorage}
     */
    var storage;

    /**
     * @member {boolean} Hyphenator~enableReducedPatternSet
     * @desc
     * A variable to set if storing the used patterns is set
     * @default false
     * @access private
     * @see {@link Hyphenator.config}
     * @see {@link Hyphenator.getRedPatternSet}
     */
    var enableReducedPatternSet = false;

    /**
     * @member {boolean} Hyphenator~enableRemoteLoading
     * @desc
     * A variable to set if pattern files should be loaded remotely or not
     * @default true
     * @access private
     * @see {@link Hyphenator.config}
     */
    var enableRemoteLoading = true;

    /**
     * @member {boolean} Hyphenator~displayToggleBox
     * @desc
     * A variable to set if the togglebox should be displayed or not
     * @default false
     * @access private
     * @see {@link Hyphenator.config}
     */
    var displayToggleBox = false;

    /**
     * @method Hyphenator~onError
     * @desc
     * A function that can be called upon an error.
     * @see {@link Hyphenator.config}
     * @access private
     */
    var onError = function (e) {
        window.alert("Hyphenator.js says:\n\nAn Error occurred:\n" + e.message);
    };

    /**
     * @method Hyphenator~onWarning
     * @desc
     * A function that can be called upon a warning.
     * @see {@link Hyphenator.config}
     * @access private
     */
    var onWarning = function (e) {
        window.console.log(e.message);
    };

    /**
     * @method Hyphenator~createElem
     * @desc
     * A function alias to document.createElementNS or document.createElement
     * @access private
     */
    function createElem(tagname, context) {
        context = context || contextWindow;
        var el;
        if (window.document.createElementNS) {
            el = context.document.createElementNS('http://www.w3.org/1999/xhtml', tagname);
        } else if (window.document.createElement) {
            el = context.document.createElement(tagname);
        }
        return el;
    }
    /**
     * @method Hyphenator~forEachKey
     * @desc
     * Calls the function f on every property of o
     * @access private
     */
    function forEachKey(o, f) {
        var k;
        if (Object.hasOwnProperty("keys")) {
            Object.keys(o).forEach(f);
        } else {
            for (k in o) {
                if (o.hasOwnProperty(k)) {
                    f(k);
                }
            }
        }
    }

    /**
     * @member {boolean} Hyphenator~css3
     * @desc
     * A variable to set if css3 hyphenation should be used
     * @default false
     * @access private
     * @see {@link Hyphenator.config}
     */
    var css3 = false;

    /**
     * @method Hyphenator~css3_gethsupport
     * @desc
     * This function returns a {@link Hyphenator~css3_hsupport} object for the current UA
     * @type function
     * @access private
     * @see Hyphenator~css3_h9n
     */
    function css3_gethsupport() {
        var support = false,
            supportedBrowserLangs = {},
            property = '',
            checkLangSupport,
            createLangSupportChecker = function (prefix) {
                var testStrings = [
                        //latin: 0
                        'aabbccddeeffgghhiijjkkllmmnnooppqqrrssttuuvvwwxxyyzz',
                        //cyrillic: 1
                        'абвгдеёжзийклмнопрстуфхцчшщъыьэюя',
                        //arabic: 2
                        'أبتثجحخدذرزسشصضطظعغفقكلمنهوي',
                        //armenian: 3
                        'աբգդեզէըթժիլխծկհձղճմյնշոչպջռսվտրցւփքօֆ',
                        //bengali: 4
                        'ঁংঃঅআইঈউঊঋঌএঐওঔকখগঘঙচছজঝঞটঠডঢণতথদধনপফবভমযরলশষসহ়ঽািীুূৃৄেৈোৌ্ৎৗড়ঢ়য়ৠৡৢৣ',
                        //devangari: 5
                        'ँंःअआइईउऊऋऌएऐओऔकखगघङचछजझञटठडढणतथदधनपफबभमयरलळवशषसहऽािीुूृॄेैोौ्॒॑ॠॡॢॣ',
                        //greek: 6
                        'αβγδεζηθικλμνξοπρσςτυφχψω',
                        //gujarati: 7
                        'બહઅઆઇઈઉઊઋૠએઐઓઔાિીુૂૃૄૢૣેૈોૌકખગઘઙચછજઝઞટઠડઢણતથદધનપફસભમયરલળવશષ',
                        //kannada: 8
                        'ಂಃಅಆಇಈಉಊಋಌಎಏಐಒಓಔಕಖಗಘಙಚಛಜಝಞಟಠಡಢಣತಥದಧನಪಫಬಭಮಯರಱಲಳವಶಷಸಹಽಾಿೀುೂೃೄೆೇೈೊೋೌ್ೕೖೞೠೡ',
                        //lao: 9
                        'ກຂຄງຈຊຍດຕຖທນບປຜຝພຟມຢຣລວສຫອຮະັາິີຶືຸູົຼເແໂໃໄ່້໊໋ໜໝ',
                        //malayalam: 10
                        'ംഃഅആഇഈഉഊഋഌഎഏഐഒഓഔകഖഗഘങചഛജഝഞടഠഡഢണതഥദധനപഫബഭമയരറലളഴവശഷസഹാിീുൂൃെേൈൊോൌ്ൗൠൡൺൻർൽൾൿ',
                        //oriya: 11
                        'ଁଂଃଅଆଇଈଉଊଋଌଏଐଓଔକଖଗଘଙଚଛଜଝଞଟଠଡଢଣତଥଦଧନପଫବଭମଯରଲଳଵଶଷସହାିୀୁୂୃେୈୋୌ୍ୗୠୡ',
                        //persian: 12
                        'أبتثجحخدذرزسشصضطظعغفقكلمنهوي',
                        //punjabi: 13
                        'ਁਂਃਅਆਇਈਉਊਏਐਓਔਕਖਗਘਙਚਛਜਝਞਟਠਡਢਣਤਥਦਧਨਪਫਬਭਮਯਰਲਲ਼ਵਸ਼ਸਹਾਿੀੁੂੇੈੋੌ੍ੰੱ',
                        //tamil: 14
                        'ஃஅஆஇஈஉஊஎஏஐஒஓஔகஙசஜஞடணதநனபமயரறலளழவஷஸஹாிீுூெேைொோௌ்ௗ',
                        //telugu: 15
                        'ఁంఃఅఆఇఈఉఊఋఌఎఏఐఒఓఔకఖగఘఙచఛజఝఞటఠడఢణతథదధనపఫబభమయరఱలళవశషసహాిీుూృౄెేైొోౌ్ౕౖౠౡ'
                    ],
                    f = function (lang) {
                        var shadow,
                            computedHeight,
                            bdy,
                            r = false;

                        //check if lang has already been tested
                        if (supportedBrowserLangs.hasOwnProperty(lang)) {
                            r = supportedBrowserLangs[lang];
                        } else if (supportedLangs.hasOwnProperty(lang)) {
                            //create and append shadow-test-element
                            bdy = window.document.getElementsByTagName('body')[0];
                            shadow = createElem('div', window);
                            shadow.id = 'Hyphenator_LanguageChecker';
                            shadow.style.width = '5em';
                            shadow.style.padding = '0';
                            shadow.style.border = 'none';
                            shadow.style[prefix] = 'auto';
                            shadow.style.hyphens = 'auto';
                            shadow.style.fontSize = '12px';
                            shadow.style.lineHeight = '12px';
                            shadow.style.wordWrap = 'normal';
                            shadow.style.visibility = 'hidden';
                            shadow.lang = lang;
                            shadow.style['-webkit-locale'] = "'" + lang + "'";
                            shadow.innerHTML = testStrings[supportedLangs[lang].script];
                            bdy.appendChild(shadow);
                            //measure its height
                            computedHeight = shadow.offsetHeight;
                            //remove shadow element
                            bdy.removeChild(shadow);
                            r = !!(computedHeight > 12);
                            supportedBrowserLangs[lang] = r;
                        } else {
                            r = false;
                        }
                        return r;
                    };
                return f;
            },
            s;

        if (window.getComputedStyle) {
            s = window.getComputedStyle(window.document.getElementsByTagName('body')[0], null);
            if (s.hyphens !== undefined) {
                support = true;
                property = 'hyphens';
                checkLangSupport = createLangSupportChecker('hyphens');
            } else if (s['-webkit-hyphens'] !== undefined) {
                support = true;
                property = '-webkit-hyphens';
                checkLangSupport = createLangSupportChecker('-webkit-hyphens');
            } else if (s.MozHyphens !== undefined) {
                support = true;
                property = '-moz-hyphens';
                checkLangSupport = createLangSupportChecker('MozHyphens');
            } else if (s['-ms-hyphens'] !== undefined) {
                support = true;
                property = '-ms-hyphens';
                checkLangSupport = createLangSupportChecker('-ms-hyphens');
            }
        } //else we just return the initial values because ancient browsers don't support css3 anyway


        return {
            support: support,
            property: property,
            supportedBrowserLangs: supportedBrowserLangs,
            checkLangSupport: checkLangSupport
        };
    }

    /**
     * @typedef {Object} Hyphenator~css3_hsupport
     * @property {boolean} support - if css3-hyphenation is supported
     * @property {string} property - the css property name to access hyphen-settings (e.g. -webkit-hyphens)
     * @property {Object.<string, boolean>} supportedBrowserLangs - an object caching tested languages
     * @property {function} checkLangSupport - a method that checks if the browser supports a requested language
     */

    /**
     * @member {Hyphenator~css3_h9n} Hyphenator~css3_h9n
     * @desc
     * A generated object containing information for CSS3-hyphenation support
     * This is set by {@link Hyphenator~css3_gethsupport}
     * @default undefined
     * @access private
     * @see {@link Hyphenator~css3_gethsupport}
     * @example
     * //Check if browser supports a language
     * css3_h9n.checkLangSupport(&lt;lang&gt;)
     */
    var css3_h9n;

    /**
     * @member {string} Hyphenator~hyphenateClass
     * @desc
     * A string containing the css-class-name for the hyphenate class
     * @default 'hyphenate'
     * @access private
     * @example
     * &lt;p class = "hyphenate"&gt;Text&lt;/p&gt;
     * @see {@link Hyphenator.config}
     */
    var hyphenateClass = 'hyphenate';

    /**
     * @member {string} Hyphenator~urlHyphenateClass
     * @desc
     * A string containing the css-class-name for the urlhyphenate class
     * @default 'urlhyphenate'
     * @access private
     * @example
     * &lt;p class = "urlhyphenate"&gt;Text&lt;/p&gt;
     * @see {@link Hyphenator.config}
     */
    var urlHyphenateClass = 'urlhyphenate';

    /**
     * @member {string} Hyphenator~classPrefix
     * @desc
     * A string containing a unique className prefix to be used
     * whenever Hyphenator sets a CSS-class
     * @access private
     */
    var classPrefix = 'Hyphenator' + Math.round(Math.random() * 1000);

    /**
     * @member {string} Hyphenator~hideClass
     * @desc
     * The name of the class that hides elements
     * @access private
     */
    var hideClass = classPrefix + 'hide';

    /**
     * @member {RegExp} Hyphenator~hideClassRegExp
     * @desc
     * RegExp to remove hideClass from a list of classes
     * @access private
     */
    var hideClassRegExp = new RegExp("\\s?\\b" + hideClass + "\\b", "g");

    /**
     * @member {string} Hyphenator~hideClass
     * @desc
     * The name of the class that unhides elements
     * @access private
     */
    var unhideClass = classPrefix + 'unhide';

    /**
     * @member {RegExp} Hyphenator~hideClassRegExp
     * @desc
     * RegExp to remove unhideClass from a list of classes
     * @access private
     */
    var unhideClassRegExp = new RegExp("\\s?\\b" + unhideClass + "\\b", "g");

    /**
     * @member {string} Hyphenator~css3hyphenateClass
     * @desc
     * The name of the class that hyphenates elements with css3
     * @access private
     */
    var css3hyphenateClass = classPrefix + 'css3hyphenate';

    /**
     * @member {CSSEdit} Hyphenator~css3hyphenateClass
     * @desc
     * The var where CSSEdit class is stored
     * @access private
     */
    var css3hyphenateClassHandle;

    /**
     * @member {string} Hyphenator~dontHyphenateClass
     * @desc
     * A string containing the css-class-name for elements that should not be hyphenated
     * @default 'donthyphenate'
     * @access private
     * @example
     * &lt;p class = "donthyphenate"&gt;Text&lt;/p&gt;
     * @see {@link Hyphenator.config}
     */
    var dontHyphenateClass = 'donthyphenate';

    /**
     * @member {number} Hyphenator~min
     * @desc
     * A number wich indicates the minimal length of words to hyphenate.
     * @default 6
     * @access private
     * @see {@link Hyphenator.config}
     */
    var min = 6;

    /**
     * @member {number} Hyphenator~leftmin
     * @desc
     * A number wich indicates the minimal length of characters before the first hyphenation.
     * This value is only used if it is greater than the value in the pattern file.
     * @default given by pattern file
     * @access private
     * @see {@link Hyphenator.config}
     */
    var leftmin = 6;

    /**
     * @member {number} Hyphenator~rightmin
     * @desc
     * A number wich indicates the minimal length of characters after the last hyphenation.
     * This value is only used if it is greater than the value in the pattern file.
     * @default given by pattern file
     * @access private
     * @see {@link Hyphenator.config}
     */
    var rightmin = 6;

    /**
     * @member {number} Hyphenator~rightmin
     * @desc
     * Control how compound words are hyphenated.
     * "auto": factory-made -> fac-tory-made ('old' behaviour of Hyphenator.js)
     * "all": factory-made -> fac-tory-[ZWSP]made ('made'.length < minWordLength)
     * "hyphen": factory-made -> factory-[ZWSP]made (Zero Width Space inserted after '-' to provide line breaking opportunity)
     * @default "auto"
     * @access private
     * @see {@link Hyphenator.config}
     */
    var compound = "auto";

    /**
     * @member {number} Hyphenator~orphanControl
     * @desc
     * Control how the last words of a line are handled:
     * level 1 (default): last word is hyphenated
     * level 2: last word is not hyphenated
     * level 3: last word is not hyphenated and last space is non breaking
     * @default 1
     * @access private
     */
    var orphanControl = 1;

    /**
     * @member {boolean} Hyphenator~isBookmarklet
     * @desc
     * This is computed by getLocality.
     * True if Hyphanetor runs as bookmarklet.
     * @access private
     */
    var isBookmarklet = locality.isBookmarklet;

    /**
     * @member {string|null} Hyphenator~mainLanguage
     * @desc
     * The general language of the document. In contrast to {@link Hyphenator~defaultLanguage},
     * mainLanguage is defined by the client (i.e. by the html or by a prompt).
     * @access private
     * @see {@link Hyphenator~autoSetMainLanguage}
     */
    var mainLanguage = null;

    /**
     * @member {string|null} Hyphenator~defaultLanguage
     * @desc
     * The language defined by the developper. This language setting is defined by a config option.
     * It is overwritten by any html-lang-attribute and only taken in count, when no such attribute can
     * be found (i.e. just before the prompt).
     * @access private
     * @see {@link Hyphenator.config}
     * @see {@link Hyphenator~autoSetMainLanguage}
     */
    var defaultLanguage = '';

    /**
     * @member {ElementCollection} Hyphenator~elements
     * @desc
     * A class representing all elements (of type Element) that have to be hyphenated. This var is filled by
     * {@link Hyphenator~gatherDocumentInfos}
     * @access private
     */
    var elements = (function () {
        /**
         * @constructor Hyphenator~elements~ElementCollection~Element
         * @desc represents a DOM Element with additional information
         * @access private
         */
        var makeElement = function (element) {
                return {
                    /**
                     * @member {Object} Hyphenator~elements~ElementCollection~Element~element
                     * @desc A DOM Element
                     * @access protected
                     */
                    element: element,
                    /**
                     * @member {boolean} Hyphenator~elements~ElementCollection~Element~hyphenated
                     * @desc Marks if the element has been hyphenated
                     * @access protected
                     */
                    hyphenated: false,
                    /**
                     * @member {boolean} Hyphenator~elements~ElementCollection~Element~treated
                     * @desc Marks if information of the element has been collected but not hyphenated (e.g. dohyphenation is off)
                     * @access protected
                     */
                    treated: false
                };
            },
            /**
             * @constructor Hyphenator~elements~ElementCollection
             * @desc A collection of Elements to be hyphenated
             * @access protected
             */
            makeElementCollection = function () {
                    /**
                     * @member {number} Hyphenator~elements~ElementCollection~counters
                     * @desc Array of [number of collected elements, number of hyphenated elements]
                     * @access protected
                     */
                var counters = [0, 0],
                    /**
                     * @member {Object.<string, Array.<Element>>} Hyphenator~elements~ElementCollection~list
                     * @desc The collection of elements, where the key is a language code and the value is an array of elements
                     * @access protected
                     */
                    list = {},
                    /**
                     * @method Hyphenator~elements~ElementCollection.prototype~add
                     * @augments Hyphenator~elements~ElementCollection
                     * @access protected
                     * @desc adds a DOM element to the collection
                     * @param {Object} el - The DOM element
                     * @param {string} lang - The language of the element
                     */
                    add = function (el, lang) {
                        var elo = makeElement(el);
                        if (!list.hasOwnProperty(lang)) {
                            list[lang] = [];
                        }
                        list[lang].push(elo);
                        counters[0] += 1;
                        return elo;
                    },
                    /**
                     * @callback Hyphenator~elements~ElementCollection.prototype~each~callback fn - The callback that is executed for each element
                     * @param {string} [k] The key (i.e. language) of the collection
                     * @param {Hyphenator~elements~ElementCollection~Element} element
                     */

                    /**
                     * @method Hyphenator~elements~ElementCollection.prototype~each
                     * @augments Hyphenator~elements~ElementCollection
                     * @access protected
                     * @desc takes each element of the collection as an argument of fn
                     * @param {Hyphenator~elements~ElementCollection.prototype~each~callback} fn - A function that takes an element as an argument
                     */
                    each = function (fn) {
                        forEachKey(list, function (k) {
                            if (fn.length === 2) {
                                fn(k, list[k]);
                            } else {
                                fn(list[k]);
                            }
                        });
                    };

                return {
                    counters: counters,
                    list: list,
                    add: add,
                    each: each
                };

            };
        return makeElementCollection();
    }());


    /**
     * @member {Object.<sting, string>} Hyphenator~exceptions
     * @desc
     * An object containing exceptions as comma separated strings for each language.
     * When the language-objects are loaded, their exceptions are processed, copied here and then deleted.
     * Exceptions can also be set by the user.
     * @see {@link Hyphenator~prepareLanguagesObj}
     * @access private
     */
    var exceptions = {};

    /**
     * @member {Object.<string, boolean>} Hyphenator~docLanguages
     * @desc
     * An object holding all languages used in the document. This is filled by
     * {@link Hyphenator~gatherDocumentInfos}
     * @access private
     */
    var docLanguages = {};

    /**
     * @member {string} Hyphenator~url
     * @desc
     * A string containing a insane RegularExpression to match URL's
     * @access private
     */
    var url = '(?:\\w*:\/\/)?(?:(?:\\w*:)?(?:\\w*)@)?(?:(?:(?:[\\d]{1,3}\\.){3}(?:[\\d]{1,3}))|(?:(?:www\\.|[a-zA-Z]\\.)?[a-zA-Z0-9\\-\\.]+\\.(?:[a-z]{2,4})))(?::\\d*)?(?:\/[\\w#!:\\.?\\+=&%@!\\-]*)*';
    //      protocoll     usr     pwd                    ip               or                          host                 tld        port               path

    /**
     * @member {string} Hyphenator~mail
     * @desc
     * A string containing a RegularExpression to match mail-adresses
     * @access private
     */
    var mail = '[\\w-\\.]+@[\\w\\.]+';

    /**
     * @member {string} Hyphenator~zeroWidthSpace
     * @desc
     * A string that holds a char.
     * Depending on the browser, this is the zero with space or an empty string.
     * zeroWidthSpace is used to break URLs
     * @access private
     */
    var zeroWidthSpace = (function () {
        var zws, ua = window.navigator.userAgent.toLowerCase();
        zws = String.fromCharCode(8203); //Unicode zero width space
        if (ua.indexOf('msie 6') !== -1) {
            zws = ''; //IE6 doesn't support zws
        }
        if (ua.indexOf('opera') !== -1 && ua.indexOf('version/10.00') !== -1) {
            zws = ''; //opera 10 on XP doesn't support zws
        }
        return zws;
    }());

    /**
     * @method Hyphenator~onBeforeWordHyphenation
     * @desc
     * This method is called just before a word is hyphenated.
     * It is called with two parameters: the word and its language.
     * The method must return a string (aka the word).
     * @see {@link Hyphenator.config}
     * @access private
     * @param {string} word
     * @param {string} lang
     * @return {string} The word that goes into hyphenation
     */
    var onBeforeWordHyphenation = function (word) {
        return word;
    };

    /**
     * @method Hyphenator~onAfterWordHyphenation
     * @desc
     * This method is called for each word after it is hyphenated.
     * Takes the word as a first parameter and its language as a second parameter.
     * Returns a string that will replace the word that has been hyphenated.
     * @see {@link Hyphenator.config}
     * @access private
     * @param {string} word
     * @param {string} lang
     * @return {string} The word that goes into hyphenation
     */
    var onAfterWordHyphenation = function (word) {
        return word;
    };

    /**
     * @method Hyphenator~onHyphenationDone
     * @desc
     * A method to be called, when the last element has been hyphenated.
     * If there are frames the method is called for each frame.
     * Therefore the location.href of the contextWindow calling this method is given as a parameter
     * @see {@link Hyphenator.config}
     * @param {string} context
     * @access private
     */
    var onHyphenationDone = function (context) {
        return context;
    };

    /**
     * @name Hyphenator~selectorFunction
     * @desc
     * A function set by the user that has to return a HTMLNodeList or array of Elements to be hyphenated.
     * By default this is set to false so we can check if a selectorFunction is set…
     * @see {@link Hyphenator.config}
     * @see {@link Hyphenator~mySelectorFunction}
     * @default false
     * @type {function|boolean}
     * @access private
     */
    var selectorFunction = false;

    /**
     * @name Hyphenator~flattenNodeList
     * @desc
     * Takes a nodeList and returns an array with all elements that are not contained by another element in the nodeList
     * By using this function the elements returned by selectElements can be 'flattened'.
     * @see {@link Hyphenator~selectElements}
     * @param {nodeList} nl
     * @return {Array} Array of 'parent'-elements
     * @access private
     */
    function flattenNodeList(nl) {
        var parentElements = [],
            i = 1,
            j = 0,
            isParent = true;

        parentElements.push(nl[0]); //add the first item, since this is always an parent

        while (i < nl.length) { //cycle through nodeList
            while (j < parentElements.length) { //cycle through parentElements
                if (parentElements[j].contains(nl[i])) {
                    isParent = false;
                    break;
                }
                j += 1;
            }
            if (isParent) {
                parentElements.push(nl[i]);
            }
            isParent = true;
            i += 1;
        }

        return parentElements;
    }

    /**
     * @method Hyphenator~mySelectorFunction
     * @desc
     * A function that returns a HTMLNodeList or array of Elements to be hyphenated.
     * By default it uses the classname ('hyphenate') to select the elements.
     * @access private
     */
    function mySelectorFunction(hyphenateClass) {
        var tmp,
            el = [],
            i = 0;
        if (window.document.getElementsByClassName) {
            el = contextWindow.document.getElementsByClassName(hyphenateClass);
        } else if (window.document.querySelectorAll) {
            el = contextWindow.document.querySelectorAll('.' + hyphenateClass);
        } else {
            tmp = contextWindow.document.getElementsByTagName('*');
            while (i < tmp.length) {
                if (tmp[i].className.indexOf(hyphenateClass) !== -1 && tmp[i].className.indexOf(dontHyphenateClass) === -1) {
                    el.push(tmp[i]);
                }
                i += 1;
            }
        }
        return el;
    }

    /**
     * @method Hyphenator~selectElements
     * @desc
     * A function that uses either selectorFunction set by the user
     * or the default mySelectorFunction.
     * @access private
     */
    function selectElements() {
        var elems;
        if (selectorFunction) {
            elems = selectorFunction();
        } else {
            elems = mySelectorFunction(hyphenateClass);
        }
        if (elems.length !== 0) {
            elems = flattenNodeList(elems);
        }
        return elems;
    }

    /**
     * @member {string} Hyphenator~intermediateState
     * @desc
     * The visibility of elements while they are hyphenated:
     * 'visible': unhyphenated text is visible and then redrawn when hyphenated.
     * 'hidden': unhyphenated text is made invisible as soon as possible and made visible after hyphenation.
     * @default 'hidden'
     * @see {@link Hyphenator.config}
     * @access private
     */
    var intermediateState = 'hidden';

    /**
     * @member {string} Hyphenator~unhide
     * @desc
     * How hidden elements unhide: either simultaneous (default: 'wait') or progressively.
     * 'wait' makes Hyphenator.js to wait until all elements are hyphenated (one redraw)
     * With 'progressive' Hyphenator.js unhides elements as soon as they are hyphenated.
     * @see {@link Hyphenator.config}
     * @access private
     */
    var unhide = 'wait';

    /**
     * @member {Array.<Hyphenator~CSSEdit>} Hyphenator~CSSEditors
     * @desc A container array that holds CSSEdit classes
     * For each window object one CSSEdit class is inserted
     * @access private
     */
    var CSSEditors = [];

    /**
     * @constructor Hyphenator~CSSEdit
     * @desc
     * This class handles access and editing of StyleSheets.
     * Thanks to this styles (e.g. hiding and unhiding elements upon hyphenation)
     * can be changed in one place instead for each element.
     * @access private
     */
    function makeCSSEdit(w) {
        w = w || window;
        var doc = w.document,
            /**
             * @member {Object} Hyphenator~CSSEdit~sheet
             * @desc
             * A StyleSheet, where Hyphenator can write to.
             * If no StyleSheet can be found, lets create one.
             * @access private
             */
            sheet = (function () {
                var i = 0,
                    l = doc.styleSheets.length,
                    s,
                    element,
                    r = false;
                while (i < l) {
                    s = doc.styleSheets[i];
                    try {
                        if (!!s.cssRules) {
                            r = s;
                            break;
                        }
                    } catch (ignore) {}
                    i += 1;
                }
                if (r === false) {
                    element = doc.createElement('style');
                    element.type = 'text/css';
                    doc.getElementsByTagName('head')[0].appendChild(element);
                    r = doc.styleSheets[doc.styleSheets.length - 1];
                }
                return r;
            }()),

            /**
             * @typedef {Object} Hyphenator~CSSEdit~changes
             * @property {Object} sheet - The StyleSheet where the change was made
             * @property {number} index - The index of the changed rule
             */

            /**
             * @member {Array.<changes>} Hyphenator~CSSEdit~changes
             * @desc
             * Sets a CSS rule for a specified selector
             * @access private
             */
            changes = [],

            /**
             * @typedef Hyphenator~CSSEdit~rule
             * @property {number} index - The index of the rule
             * @property {Object} rule - The style rule
             */
            /**
             * @method Hyphenator~CSSEdit~findRule
             * @desc
             * Searches the StyleSheets for a given selector and returns an object containing the rule.
             * If nothing can be found, false is returned.
             * @param {string} sel
             * @return {Hyphenator~CSSEdit~rule|false}
             * @access private
             */
            findRule = function (sel) {
                var s,
                    rule,
                    sheets = w.document.styleSheets,
                    rules,
                    i = 0,
                    j = 0,
                    r = false;
                while (i < sheets.length) {
                    s = sheets[i];
                    try { //FF has issues here with external CSS (s.o.p)
                        if (!!s.cssRules) {
                            rules = s.cssRules;
                        } else if (!!s.rules) {
                            // IE < 9
                            rules = s.rules;
                        }
                    } catch (ignore) {}
                    if (!!rules && !!rules.length) {
                        while (j < rules.length) {
                            rule = rules[j];
                            if (rule.selectorText === sel) {
                                r = {
                                    index: j,
                                    rule: rule
                                };
                            }
                            j += 1;
                        }
                    }
                    i += 1;
                }
                return r;
            },
            /**
             * @method Hyphenator~CSSEdit~addRule
             * @desc
             * Adds a rule to the {@link Hyphenator~CSSEdit~sheet}
             * @param {string} sel - The selector to be added
             * @param {string} rulesStr - The rules for the specified selector
             * @return {number} index of the new rule
             * @access private
             */
            addRule = function (sel, rulesStr) {
                var i, r;
                if (!!sheet.insertRule) {
                    if (!!sheet.cssRules) {
                        i = sheet.cssRules.length;
                    } else {
                        i = 0;
                    }
                    r = sheet.insertRule(sel + '{' + rulesStr + '}', i);
                } else if (!!sheet.addRule) {
                    // IE < 9
                    if (!!sheet.rules) {
                        i = sheet.rules.length;
                    } else {
                        i = 0;
                    }
                    sheet.addRule(sel, rulesStr, i);
                    r = i;
                }
                return r;
            },
            /**
             * @method Hyphenator~CSSEdit~removeRule
             * @desc
             * Removes a rule with the specified index from the specified sheet
             * @param {Object} sheet - The style sheet
             * @param {number} index - the index of the rule
             * @access private
             */
            removeRule = function (sheet, index) {
                if (sheet.deleteRule) {
                    sheet.deleteRule(index);
                } else {
                    // IE < 9
                    sheet.removeRule(index);
                }
            };

        return {
            /**
             * @method Hyphenator~CSSEdit.setRule
             * @desc
             * Sets a CSS rule for a specified selector
             * @access public
             * @param {string} sel - Selector
             * @param {string} rulesString - CSS-Rules
             */
            setRule: function (sel, rulesString) {
                var i, existingRule, cssText;
                existingRule = findRule(sel);
                if (!!existingRule) {
                    if (!!existingRule.rule.cssText) {
                        cssText = existingRule.rule.cssText;
                    } else {
                        // IE < 9
                        cssText = existingRule.rule.style.cssText.toLowerCase();
                    }
                    if (cssText !== sel + ' { ' + rulesString + ' }') {
                        //cssText of the found rule is not uniquely selector + rulesString,
                        if (cssText.indexOf(rulesString) !== -1) {
                            //maybe there are other rules or IE < 9
                            //clear existing def
                            existingRule.rule.style.visibility = '';
                        }
                        //add rule and register for later removal
                        i = addRule(sel, rulesString);
                        changes.push({sheet: sheet, index: i});
                    }
                } else {
                    i = addRule(sel, rulesString);
                    changes.push({sheet: sheet, index: i});
                }
            },
            /**
             * @method Hyphenator~CSSEdit.clearChanges
             * @desc
             * Removes all changes Hyphenator has made from the StyleSheets
             * @access public
             */
            clearChanges: function () {
                var change = changes.pop();
                while (!!change) {
                    removeRule(change.sheet, change.index);
                    change = changes.pop();
                }
            }
        };
    }

    /**
     * @member {string} Hyphenator~hyphen
     * @desc
     * A string containing the character for in-word-hyphenation
     * @default the soft hyphen
     * @access private
     * @see {@link Hyphenator.config}
     */
    var hyphen = String.fromCharCode(173);

    /**
     * @member {string} Hyphenator~urlhyphen
     * @desc
     * A string containing the character for url/mail-hyphenation
     * @default the zero width space
     * @access private
     * @see {@link Hyphenator.config}
     * @see {@link Hyphenator~zeroWidthSpace}
     */
    var urlhyphen = zeroWidthSpace;

    /**
     * @method Hyphenator~hyphenateURL
     * @desc
     * Puts {@link Hyphenator~urlhyphen} (default: zero width space) after each no-alphanumeric char that my be in a URL.
     * @param {string} url to hyphenate
     * @returns string the hyphenated URL
     * @access public
     */
    function hyphenateURL(url) {
        var tmp = url.replace(/([:\/\.\?#&\-_,;!@]+)/gi, '$&' + urlhyphen),
            parts = tmp.split(urlhyphen),
            i = 0;
        while (i < parts.length) {
            if (parts[i].length > (2 * min)) {
                parts[i] = parts[i].replace(/(\w{3})(\w)/gi, "$1" + urlhyphen + "$2");
            }
            i += 1;
        }
        if (parts[parts.length - 1] === "") {
            parts.pop();
        }
        return parts.join(urlhyphen);
    }

    /**
     * @member {boolean} Hyphenator~safeCopy
     * @desc
     * Defines wether work-around for copy issues is active or not
     * @default true
     * @access private
     * @see {@link Hyphenator.config}
     * @see {@link Hyphenator~registerOnCopy}
     */
    var safeCopy = true;

    /**
     * @method Hyphenator~zeroTimeOut
     * @desc
     * defer execution of a function on the call stack
     * Analog to window.setTimeout(fn, 0) but without a clamped delay if postMessage is supported
     * @access private
     * @see {@link http://dbaron.org/log/20100309-faster-timeouts}
     */
    var zeroTimeOut = (function () {
        if (window.postMessage && window.addEventListener) {
            return (function () {
                var timeouts = [],
                    msg = "Hyphenator_zeroTimeOut_message",
                    setZeroTimeOut = function (fn) {
                        timeouts.push(fn);
                        window.postMessage(msg, "*");
                    },
                    handleMessage = function (event) {
                        if (event.source === window && event.data === msg) {
                            event.stopPropagation();
                            if (timeouts.length > 0) {
                                //var efn = timeouts.shift();
                                //efn();
                                timeouts.shift()();
                            }
                        }
                    };
                window.addEventListener("message", handleMessage, true);
                return setZeroTimeOut;
            }());
        }
        return function (fn) {
            window.setTimeout(fn, 0);
        };
    }());

    /**
     * @member {Object} Hyphenator~hyphRunFor
     * @desc
     * stores location.href for documents where run() has been executed
     * to warn when Hyphenator.run() executed multiple times
     * @access private
     * @see {@link Hyphenator~runWhenLoaded}
     */
    var hyphRunFor = {};

    /**
     * @method Hyphenator~runWhenLoaded
     * @desc
     * A crossbrowser solution for the DOMContentLoaded-Event based on
     * <a href = "http://jquery.com/">jQuery</a>
     * I added some functionality: e.g. support for frames and iframes…
     * @param {Object} w the window-object
     * @param {function()} f the function to call when the document is ready
     * @access private
     */
    function runWhenLoaded(w, f) {
        var toplevel,
            add = window.document.addEventListener
                ? 'addEventListener'
                : 'attachEvent',
            rem = window.document.addEventListener
                ? 'removeEventListener'
                : 'detachEvent',
            pre = window.document.addEventListener
                ? ''
                : 'on';

        function init(context) {
            if (hyphRunFor[context.location.href]) {
                onWarning(new Error("Warning: multiple execution of Hyphenator.run() – This may slow down the script!"));
            }
            contextWindow = context || window;
            f();
            hyphRunFor[contextWindow.location.href] = true;
        }

        function doScrollCheck() {
            try {
                // If IE is used, use the trick by Diego Perini
                // http://javascript.nwbox.com/IEContentLoaded/
                w.document.documentElement.doScroll("left");
            } catch (ignore) {
                window.setTimeout(doScrollCheck, 1);
                return;
            }
            //maybe modern IE fired DOMContentLoaded
            if (!hyphRunFor[w.location.href]) {
                documentLoaded = true;
                init(w);
            }
        }

        function doOnEvent(e) {
            var i = 0,
                fl,
                haveAccess;
            if (!!e && e.type === 'readystatechange' && w.document.readyState !== 'interactive' && w.document.readyState !== 'complete') {
                return;
            }

            //DOM is ready/interactive, but frames may not be loaded yet!
            //cleanup events
            w.document[rem](pre + 'DOMContentLoaded', doOnEvent, false);
            w.document[rem](pre + 'readystatechange', doOnEvent, false);

            //check frames
            fl = w.frames.length;
            if (fl === 0 || !doFrames) {
                //there are no frames!
                //cleanup events
                w[rem](pre + 'load', doOnEvent, false);
                documentLoaded = true;
                init(w);
            } else if (doFrames && fl > 0) {
                //we have frames, so wait for onload and then initiate runWhenLoaded recursevly for each frame:
                if (!!e && e.type === 'load') {
                    //cleanup events
                    w[rem](pre + 'load', doOnEvent, false);
                    while (i < fl) {
                        haveAccess = undefined;
                        //try catch isn't enough for webkit
                        try {
                            //opera throws only on document.toString-access
                            haveAccess = w.frames[i].document.toString();
                        } catch (ignore) {
                            haveAccess = undefined;
                        }
                        if (!!haveAccess) {
                            runWhenLoaded(w.frames[i], f);
                        }
                        i += 1;
                    }
                    init(w);
                }
            }
        }

        if (documentLoaded || w.document.readyState === 'complete') {
            //Hyphenator has run already (documentLoaded is true) or
            //it has been loaded after onLoad
            documentLoaded = true;
            doOnEvent({type: 'load'});
        } else {
            //register events
            w.document[add](pre + 'DOMContentLoaded', doOnEvent, false);
            w.document[add](pre + 'readystatechange', doOnEvent, false);
            w[add](pre + 'load', doOnEvent, false);
            toplevel = false;
            try {
                toplevel = !window.frameElement;
            } catch (ignore) {}
            if (toplevel && w.document.documentElement.doScroll) {
                doScrollCheck(); //calls init()
            }
        }
    }

    /**
     * @method Hyphenator~getLang
     * @desc
     * Gets the language of an element. If no language is set, it may use the {@link Hyphenator~mainLanguage}.
     * @param {Object} el The first parameter is an DOM-Element-Object
     * @param {boolean} fallback The second parameter is a boolean to tell if the function should return the {@link Hyphenator~mainLanguage}
     * if there's no language found for the element.
     * @return {string} The language of the element
     * @access private
     */
    function getLang(el, fallback) {
        try {
            return !!el.getAttribute('lang')
                ? el.getAttribute('lang').toLowerCase()
                : !!el.getAttribute('xml:lang')
                    ? el.getAttribute('xml:lang').toLowerCase()
                    : el.tagName.toLowerCase() !== 'html'
                        ? getLang(el.parentNode, fallback)
                        : fallback
                            ? mainLanguage
                            : null;
        } catch (ignore) {}
    }

    /**
     * @method Hyphenator~autoSetMainLanguage
     * @desc
     * Retrieves the language of the document from the DOM and sets the lang attribute of the html-tag.
     * The function looks in the following places:
     * <ul>
     * <li>lang-attribute in the html-tag</li>
     * <li>&lt;meta http-equiv = "content-language" content = "xy" /&gt;</li>
     * <li>&lt;meta name = "DC.Language" content = "xy" /&gt;</li>
     * <li>&lt;meta name = "language" content = "xy" /&gt;</li>
     * </li>
     * If nothing can be found a prompt using {@link Hyphenator~languageHint} and a prompt-string is displayed.
     * If the retrieved language is in the object {@link Hyphenator~supportedLangs} it is copied to {@link Hyphenator~mainLanguage}
     * @access private
     */
    function autoSetMainLanguage(w) {
        w = w || contextWindow;
        var el = w.document.getElementsByTagName('html')[0],
            m = w.document.getElementsByTagName('meta'),
            i = 0,
            getLangFromUser = function () {
                var ml,
                    text = '',
                    dH = 300,
                    dW = 450,
                    dX = Math.floor((w.outerWidth - dW) / 2) + window.screenX,
                    dY = Math.floor((w.outerHeight - dH) / 2) + window.screenY,
                    ul = '',
                    languageHint;
                if (!!window.showModalDialog && (w.location.href.indexOf(basePath) !== -1)) {
                    ml = window.showModalDialog(basePath + 'modalLangDialog.html', supportedLangs, "dialogWidth: " + dW + "px; dialogHeight: " + dH + "px; dialogtop: " + dY + "; dialogleft: " + dX + "; center: on; resizable: off; scroll: off;");
                } else {
                    languageHint = (function () {
                        var r = '';
                        forEachKey(supportedLangs, function (k) {
                            r += k + ', ';
                        });
                        r = r.substring(0, r.length - 2);
                        return r;
                    }());
                    ul = window.navigator.language || window.navigator.userLanguage;
                    ul = ul.substring(0, 2);
                    if (!!supportedLangs[ul] && supportedLangs[ul].prompt !== '') {
                        text = supportedLangs[ul].prompt;
                    } else {
                        text = supportedLangs.en.prompt;
                    }
                    text += ' (ISO 639-1)\n\n' + languageHint;
                    ml = window.prompt(window.unescape(text), ul).toLowerCase();
                }
                return ml;
            };
        mainLanguage = getLang(el, false);
        if (!mainLanguage) {
            while (i < m.length) {
                //<meta http-equiv = "content-language" content="xy">
                if (!!m[i].getAttribute('http-equiv') && (m[i].getAttribute('http-equiv').toLowerCase() === 'content-language')) {
                    mainLanguage = m[i].getAttribute('content').toLowerCase();
                }
                //<meta name = "DC.Language" content="xy">
                if (!!m[i].getAttribute('name') && (m[i].getAttribute('name').toLowerCase() === 'dc.language')) {
                    mainLanguage = m[i].getAttribute('content').toLowerCase();
                }
                //<meta name = "language" content = "xy">
                if (!!m[i].getAttribute('name') && (m[i].getAttribute('name').toLowerCase() === 'language')) {
                    mainLanguage = m[i].getAttribute('content').toLowerCase();
                }
                i += 1;
            }
        }
        //get lang for frame from enclosing document
        if (!mainLanguage && doFrames && (!!contextWindow.frameElement)) {
            autoSetMainLanguage(window.parent);
        }
        //fallback to defaultLang if set
        if (!mainLanguage && defaultLanguage !== '') {
            mainLanguage = defaultLanguage;
        }
        //ask user for lang
        if (!mainLanguage) {
            mainLanguage = getLangFromUser();
        }
        el.lang = mainLanguage;
    }

    /**
     * @method Hyphenator~gatherDocumentInfos
     * @desc
     * This method runs through the DOM and executes the process()-function on:
     * - every node returned by the {@link Hyphenator~selectorFunction}.
     * @access private
     */
    function gatherDocumentInfos() {
        var elToProcess,
            urlhyphenEls,
            tmp,
            i = 0;
        /**
         * @method Hyphenator~gatherDocumentInfos
         * @desc
         * This method copies the element to the elements-variable, sets its visibility
         * to intermediateState, retrieves its language and recursivly descends the DOM-tree until
         * the child-Nodes aren't of type 1
         * @param {Object} el a DOM element
         * @param {string} plang the language of the parent element
         * @param {boolean} isChild true, if the parent of el has been processed
         */
        function process(el, pLang, isChild) {
            var n,
                j = 0,
                hyphenate = true,
                eLang,
                useCSS3 = function () {
                    css3hyphenateClassHandle = makeCSSEdit(contextWindow);
                    css3hyphenateClassHandle.setRule('.' + css3hyphenateClass, css3_h9n.property + ': auto;');
                    css3hyphenateClassHandle.setRule('.' + dontHyphenateClass, css3_h9n.property + ': manual;');
                    if ((eLang !== pLang) && css3_h9n.property.indexOf('webkit') !== -1) {
                        css3hyphenateClassHandle.setRule('.' + css3hyphenateClass, '-webkit-locale : ' + eLang + ';');
                    }
                    el.className = el.className + ' ' + css3hyphenateClass;
                },
                useHyphenator = function () {
                    //quick fix for test111.html
                    //better: weight elements
                    if (isBookmarklet && eLang !== mainLanguage) {
                        return;
                    }
                    if (supportedLangs.hasOwnProperty(eLang)) {
                        docLanguages[eLang] = true;
                    } else {
                        if (supportedLangs.hasOwnProperty(eLang.split('-')[0])) { //try subtag
                            eLang = eLang.split('-')[0];
                            docLanguages[eLang] = true;
                        } else if (!isBookmarklet) {
                            hyphenate = false;
                            onError(new Error('Language "' + eLang + '" is not yet supported.'));
                        }
                    }
                    if (hyphenate) {
                        if (intermediateState === 'hidden') {
                            el.className = el.className + ' ' + hideClass;
                        }
                        elements.add(el, eLang);
                    }
                };
            isChild = isChild || false;
            if (el.lang && typeof el.lang === 'string') {
                eLang = el.lang.toLowerCase(); //copy attribute-lang to internal eLang
            } else if (!!pLang && pLang !== '') {
                eLang = pLang.toLowerCase();
            } else {
                eLang = getLang(el, true);
            }

            if (!isChild) {
                if (css3 && css3_h9n.support && !!css3_h9n.checkLangSupport(eLang)) {
                    useCSS3();
                } else {
                    useHyphenator();
                }
            } else {
                if (eLang !== pLang) {
                    if (css3 && css3_h9n.support && !!css3_h9n.checkLangSupport(eLang)) {
                        useCSS3();
                    } else {
                        useHyphenator();
                    }
                } else {
                    if (!css3 || !css3_h9n.support || !css3_h9n.checkLangSupport(eLang)) {
                        useHyphenator();
                    } // else do nothing
                }
            }
            n = el.childNodes[j];
            while (!!n) {
                if (n.nodeType === 1 && !dontHyphenate[n.nodeName.toLowerCase()] &&
                        n.className.indexOf(dontHyphenateClass) === -1 &&
                        n.className.indexOf(urlHyphenateClass) === -1 && !elToProcess[n]) {
                    process(n, eLang, true);
                }
                j += 1;
                n = el.childNodes[j];
            }
        }
        function processUrlStyled(el) {
            var n, j = 0;

            n = el.childNodes[j];
            while (!!n) {
                if (n.nodeType === 1 && !dontHyphenate[n.nodeName.toLowerCase()] &&
                        n.className.indexOf(dontHyphenateClass) === -1 &&
                        n.className.indexOf(hyphenateClass) === -1 && !urlhyphenEls[n]) {
                    processUrlStyled(n);
                } else if (n.nodeType === 3) {
                    n.data = hyphenateURL(n.data);
                }
                j += 1;
                n = el.childNodes[j];
            }
        }

        if (css3) {
            css3_h9n = css3_gethsupport();
        }
        if (isBookmarklet) {
            elToProcess = contextWindow.document.getElementsByTagName('body')[0];
            process(elToProcess, mainLanguage, false);
        } else {
            if (!css3 && intermediateState === 'hidden') {
                CSSEditors.push(makeCSSEdit(contextWindow));
                CSSEditors[CSSEditors.length - 1].setRule('.' + hyphenateClass, 'visibility: hidden;');
                CSSEditors[CSSEditors.length - 1].setRule('.' + hideClass, 'visibility: hidden;');
                CSSEditors[CSSEditors.length - 1].setRule('.' + unhideClass, 'visibility: visible;');
            }
            elToProcess = selectElements();
            tmp = elToProcess[i];
            while (!!tmp) {
                process(tmp, '', false);
                i += 1;
                tmp = elToProcess[i];
            }

            urlhyphenEls = mySelectorFunction(urlHyphenateClass);
            i = 0;
            tmp = urlhyphenEls[i];
            while (!!tmp) {
                processUrlStyled(tmp);
                i += 1;
                tmp = urlhyphenEls[i];
            }
        }
        if (elements.counters[0] === 0) {
            //nothing to hyphenate or all hyphenated by css3
            i = 0;
            while (i < CSSEditors.length) {
                CSSEditors[i].clearChanges();
                i += 1;
            }
            onHyphenationDone(contextWindow.location.href);
        }
    }

    /**
     * @method Hyphenator~createCharMap
     * @desc
     * reads the charCodes from lo.characters and stores them in a bidi map:
     * charMap.int2code =  [0: 97, //a
     *                      1: 98, //b
     *                      2: 99] //c etc.
     * charMap.code2int = {"97": 0, //a
     *                     "98": 1, //b
     *                     "99": 2} //c etc.
     * @access private
     * @param {Object} language object
     */
    function makeCharMap() {
        var int2code = [],
            code2int = {},
            add = function (newValue) {
                if (!code2int[newValue]) {
                    int2code.push(newValue);
                    code2int[newValue] = int2code.length - 1;
                }
            };
        return {
            int2code: int2code,
            code2int: code2int,
            add: add
        };
    }

    /**
     * @constructor Hyphenator~ValueStore
     * @desc Storage-Object for storing hyphenation points (aka values)
     * @access private
     */
    function makeValueStore(len) {
        var indexes = (function () {
                var arr;
                if (Object.prototype.hasOwnProperty.call(window, "Uint32Array")) { //IE<9 doesn't have window.hasOwnProperty (host object)
                    arr = new window.Uint32Array(3);
                    arr[0] = 1; //start position of a value set
                    arr[1] = 1; //next index
                    arr[2] = 1; //last index with a significant value
                } else {
                    arr = [1, 1, 1];
                }
                return arr;
            }()),
            keys = (function () {
                var i, r;
                if (Object.prototype.hasOwnProperty.call(window, "Uint8Array")) { //IE<9 doesn't have window.hasOwnProperty (host object)
                    return new window.Uint8Array(len);
                }
                r = [];
                r.length = len;
                i = r.length - 1;
                while (i >= 0) {
                    r[i] = 0;
                    i -= 1;
                }
                return r;
            }()),
            add = function (p) {
                keys[indexes[1]] = p;
                indexes[2] = indexes[1];
                indexes[1] += 1;
            },
            add0 = function () {
                //just do a step, since array is initialized with zeroes
                indexes[1] += 1;
            },
            finalize = function () {
                var start = indexes[0];
                keys[indexes[2] + 1] = 255; //mark end of pattern
                indexes[0] = indexes[2] + 2;
                indexes[1] = indexes[0];
                return start;
            };
        return {
            keys: keys,
            add: add,
            add0: add0,
            finalize: finalize
        };
    }

    /**
     * @method Hyphenator~convertPatternsToArray
     * @desc
     * converts the patterns to a (typed, if possible) array as described by Liang:
     *
     * 1. Create the CharMap: an alphabet of used character codes mapped to an int (e.g. a: "97" -> 0)
     *    This map is bidirectional:
     *    charMap.code2int is an object with charCodes as keys and corresponging ints as values
     *    charMao.int2code is an array of charCodes at int indizes
     *    the length of charMao.int2code is equal the length of the alphabet
     *
     * 2. Create a ValueStore: (typed) array that holds "values", i.e. the digits extracted from the patterns
     *    The first value set starts at index 1 (since the trie is initialized with zeroes, starting at 0 would create errors)
     *    Each value set ends with a value of 255; trailing 0's are not stored. So pattern values like e.g. "010200" will become […,0,1,0,2,255,…]
     *    The ValueStore-Object manages handling of indizes automatically. Use ValueStore.add(p) to add a running value.
     *    Use ValueStore.finalize() when the last value of a pattern is added. It will add the final 255, prepare the valueStore for new values
     *    and return the starting index of the pattern.
     *    To prevent doubles we could temporarly store the values in a object {value: startIndex} and only add new values,
     *    but this object deoptimizes very fast (new hidden map for each entry); here we gain speed and pay memory
     *
     * 3. Create and zero initialize a (typed) array to store the trie. The trie uses two slots for each entry/node:
     *    i: a link to another position in the array or -1 if the pattern ends here or more rows have to be added.
     *    i + 1: a link to a value in the ValueStore or 0 if there's no value for the path to this node.
     *    Although the array is one-dimensional it can be described as an array of "rows",
     *    where each "row" is an array of length trieRowLength (see below).
     *    The first entry of this "row" represents the first character of the alphabet, the second a possible link to value store,
     *    the third represents the second character of the alphabet and so on…
     *
     * 4. Initialize trieRowLength (length of the alphabet * 2)
     *
     * 5. Now we apply extract to each pattern collection (patterns of the same length are collected and concatenated to one string)
     *    extract goes through these pattern collections char by char and adds them either to the ValueStore (if they are digits) or
     *    to the trie (adding more "rows" if necessary, i.e. if the last link pointed to -1).
     *    So the first "row" holds all starting characters, where the subsequent rows hold the characters that follow the
     *    character that link to this row. Therefor the array is dense at the beginning and very sparse at the end.
     *
     *
     * @access private
     * @param {Object} language object
     */
    function convertPatternsToArray(lo) {
        var trieNextEmptyRow = 0,
            i,
            charMapc2i,
            valueStore,
            indexedTrie,
            trieRowLength,

            extract = function (patternSizeInt, patterns) {
                var charPos = 0,
                    charCode = 0,
                    mappedCharCode = 0,
                    rowStart = 0,
                    nextRowStart = 0,
                    prevWasDigit = false;
                while (charPos < patterns.length) {
                    charCode = patterns.charCodeAt(charPos);
                    if ((charPos + 1) % patternSizeInt !== 0) {
                        //more to come…
                        if (charCode <= 57 && charCode >= 49) {
                            //charCode is a digit
                            valueStore.add(charCode - 48);
                            prevWasDigit = true;
                        } else {
                            //charCode is alphabetical
                            if (!prevWasDigit) {
                                valueStore.add0();
                            }
                            prevWasDigit = false;
                            if (nextRowStart === -1) {
                                nextRowStart = trieNextEmptyRow + trieRowLength;
                                trieNextEmptyRow = nextRowStart;
                                indexedTrie[rowStart + mappedCharCode * 2] = nextRowStart;
                            }
                            mappedCharCode = charMapc2i[charCode];
                            rowStart = nextRowStart;
                            nextRowStart = indexedTrie[rowStart + mappedCharCode * 2];
                            if (nextRowStart === 0) {
                                indexedTrie[rowStart + mappedCharCode * 2] = -1;
                                nextRowStart = -1;
                            }
                        }
                    } else {
                        //last part of pattern
                        if (charCode <= 57 && charCode >= 49) {
                            //the last charCode is a digit
                            valueStore.add(charCode - 48);
                            indexedTrie[rowStart + mappedCharCode * 2 + 1] = valueStore.finalize();
                        } else {
                            //the last charCode is alphabetical
                            if (!prevWasDigit) {
                                valueStore.add0();
                            }
                            valueStore.add0();
                            if (nextRowStart === -1) {
                                nextRowStart = trieNextEmptyRow + trieRowLength;
                                trieNextEmptyRow = nextRowStart;
                                indexedTrie[rowStart + mappedCharCode * 2] = nextRowStart;
                            }
                            mappedCharCode = charMapc2i[charCode];
                            rowStart = nextRowStart;
                            if (indexedTrie[rowStart + mappedCharCode * 2] === 0) {
                                indexedTrie[rowStart + mappedCharCode * 2] = -1;
                            }
                            indexedTrie[rowStart + mappedCharCode * 2 + 1] = valueStore.finalize();
                        }
                        rowStart = 0;
                        nextRowStart = 0;
                        prevWasDigit = false;
                    }
                    charPos += 1;
                }
            };/*,
            prettyPrintIndexedTrie = function (rowLength) {
                var s = "0: ",
                    idx;
                for (idx = 0; idx < indexedTrie.length; idx += 1) {
                    s += indexedTrie[idx];
                    s += ",";
                    if ((idx + 1) % rowLength === 0) {
                        s += "\n" + (idx + 1) + ": ";
                    }
                }
                console.log(s);
            };*/

        lo.charMap = makeCharMap();
        i = 0;
        while (i < lo.patternChars.length) {
            lo.charMap.add(lo.patternChars.charCodeAt(i));
            i += 1;
        }
        charMapc2i = lo.charMap.code2int;

        valueStore = makeValueStore(lo.valueStoreLength);
        lo.valueStore = valueStore;

        if (Object.prototype.hasOwnProperty.call(window, "Int32Array")) { //IE<9 doesn't have window.hasOwnProperty (host object)
            lo.indexedTrie = new window.Int32Array(lo.patternArrayLength * 2);
        } else {
            lo.indexedTrie = [];
            lo.indexedTrie.length = lo.patternArrayLength * 2;
            i = lo.indexedTrie.length - 1;
            while (i >= 0) {
                lo.indexedTrie[i] = 0;
                i -= 1;
            }
        }
        indexedTrie = lo.indexedTrie;
        trieRowLength = lo.charMap.int2code.length * 2;

        forEachKey(lo.patterns, function (i) {
            extract(parseInt(i, 10), lo.patterns[i]);
        });
        //prettyPrintIndexedTrie(lo.charMap.int2code.length * 2);
    }

    /**
     * @method Hyphenator~recreatePattern
     * @desc
     * Recreates the pattern for the reducedPatternSet
     * @param {string} pattern The pattern (chars)
     * @param {string} nodePoints The nodePoints (integers)
     * @access private
     * @return {string} The pattern (chars and numbers)
     */
    function recreatePattern(pattern, nodePoints) {
        var r = [],
            c = pattern.split(''),
            i = 0;
        while (i <= c.length) {
            if (nodePoints[i] && nodePoints[i] !== 0) {
                r.push(nodePoints[i]);
            }
            if (c[i]) {
                r.push(c[i]);
            }
            i += 1;
        }
        return r.join('');
    }

    /**
     * @method Hyphenator~convertExceptionsToObject
     * @desc
     * Converts a list of comma seprated exceptions to an object:
     * 'Fortran,Hy-phen-a-tion' -> {'Fortran':'Fortran','Hyphenation':'Hy-phen-a-tion'}
     * @access private
     * @param {string} exc a comma separated string of exceptions (without spaces)
     * @return {Object.<string, string>}
     */
    function convertExceptionsToObject(exc) {
        var w = exc.split(', '),
            r = {},
            i = 0,
            l = w.length,
            key;
        while (i < l) {
            key = w[i].replace(/-/g, '');
            if (!r.hasOwnProperty(key)) {
                r[key] = w[i];
            }
            i += 1;
        }
        return r;
    }

    /**
     * @method Hyphenator~loadPatterns
     * @desc
     * Checks if the requested file is available in the network.
     * Adds a &lt;script&gt;-Tag to the DOM to load an externeal .js-file containing patterns and settings for the given language.
     * If the given language is not in the {@link Hyphenator~supportedLangs}-Object it returns.
     * One may ask why we are not using AJAX to load the patterns. The XMLHttpRequest-Object
     * has a same-origin-policy. This makes the Bookmarklet impossible.
     * @param {string} lang The language to load the patterns for
     * @access private
     * @see {@link Hyphenator~basePath}
     */
    function loadPatterns(lang, cb) {
        var location, xhr, head, script, done = false;
        if (supportedLangs.hasOwnProperty(lang) && !Hyphenator.languages[lang]) {
            location = basePath + 'patterns/' + supportedLangs[lang].file;
        } else {
            return;
        }
        if (isLocal && !isBookmarklet) {
            //check if 'location' is available:
            xhr = null;
            try {
                // Mozilla, Opera, Safari and Internet Explorer (ab v7)
                xhr = new window.XMLHttpRequest();
            } catch (ignore) {
                try {
                    //IE>=6
                    xhr = new window.ActiveXObject("Microsoft.XMLHTTP");
                } catch (ignore) {
                    try {
                        //IE>=5
                        xhr = new window.ActiveXObject("Msxml2.XMLHTTP");
                    } catch (ignore) {
                        xhr = null;
                    }
                }
            }

            if (xhr) {
                xhr.open('HEAD', location, true);
                xhr.setRequestHeader('Cache-Control', 'no-cache');
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 2) {
                        if (xhr.status >= 400) {
                            onError(new Error('Could not load\n' + location));
                            delete docLanguages[lang];
                            return;
                        }
                        xhr.abort();
                    }
                };
                xhr.send(null);
            }
        }
        if (createElem) {
            head = window.document.getElementsByTagName('head').item(0);
            script = createElem('script', window);
            script.src = location;
            script.type = 'text/javascript';
            script.charset = 'utf8';
            script.onreadystatechange = function () {
                if (!done && (!script.readyState || script.readyState === "loaded" || script.readyState === "complete")) {
                    done = true;

                    cb();

                    // Handle memory leak in IE
                    script.onreadystatechange = null;
                    script.onload = null;
                    if (head && script.parentNode) {
                        head.removeChild(script);
                    }
                }
            };
            script.onload = script.onreadystatechange;
            head.appendChild(script);
        }
    }

    /**
     * @method Hyphenator~prepareLanguagesObj
     * @desc
     * Adds some feature to the language object:
     * - cache
     * - exceptions
     * Converts the patterns to a trie using {@link Hyphenator~convertPatterns}
     * @access private
     * @param {string} lang The language of the language object
     */
    function prepareLanguagesObj(lang) {
        var lo = Hyphenator.languages[lang], wrd;

        if (!lo.prepared) {
            if (enableCache) {
                lo.cache = {};
                //Export
                //lo['cache'] = lo.cache;
            }
            if (enableReducedPatternSet) {
                lo.redPatSet = {};
            }
            if (leftmin > lo.leftmin) {
                lo.leftmin = leftmin;
            }
            if (rightmin > lo.rightmin) {
                lo.rightmin = rightmin;
            }
            //add exceptions from the pattern file to the local 'exceptions'-obj
            if (lo.hasOwnProperty('exceptions')) {
                Hyphenator.addExceptions(lang, lo.exceptions);
                delete lo.exceptions;
            }
            //copy global exceptions to the language specific exceptions
            if (exceptions.hasOwnProperty('global')) {
                if (exceptions.hasOwnProperty(lang)) {
                    exceptions[lang] += ', ' + exceptions.global;
                } else {
                    exceptions[lang] = exceptions.global;
                }
            }
            //move exceptions from the the local 'exceptions'-obj to the 'language'-object
            if (exceptions.hasOwnProperty(lang)) {
                lo.exceptions = convertExceptionsToObject(exceptions[lang]);
                delete exceptions[lang];
            } else {
                lo.exceptions = {};
            }
            convertPatternsToArray(lo);
            if (String.prototype.normalize) {
                wrd = '[\\w' + lo.specialChars + lo.specialChars.normalize("NFD") + String.fromCharCode(173) + String.fromCharCode(8204) + '-]{' + min + ',}';
            } else {
                wrd = '[\\w' + lo.specialChars + String.fromCharCode(173) + String.fromCharCode(8204) + '-]{' + min + ',}';
            }
            lo.genRegExp = new RegExp('(' + wrd + ')|(' + url + ')|(' + mail + ')', 'gi');
            lo.prepared = true;
        }
    }

    /****
     * @method Hyphenator~prepare
     * @desc
     * This funtion prepares the Hyphenator~Object: If RemoteLoading is turned off, it assumes
     * that the patternfiles are loaded, all conversions are made and the callback is called.
     * If storage is active the object is retrieved there.
     * If RemoteLoading is on (default), it loads the pattern files and repeatedly checks Hyphenator.languages.
     * If a patternfile is loaded the patterns are stored in storage (if enabled),
     * converted to their object style and the lang-object extended.
     * Finally the callback is called.
     * @access private
     */
    function prepare(callback) {
        var tmp1;

        function languagesLoaded() {
            forEachKey(docLanguages, function (l) {
                if (Hyphenator.languages.hasOwnProperty(l)) {
                    delete docLanguages[l];
                    if (!!storage) {
                        storage.setItem(l, window.JSON.stringify(Hyphenator.languages[l]));
                    }
                    prepareLanguagesObj(l);
                    callback(l);
                }
            });
        }

        if (!enableRemoteLoading) {
            forEachKey(Hyphenator.languages, function (lang) {
                prepareLanguagesObj(lang);
            });
            callback('*');
            return;
        }
        // get all languages that are used and preload the patterns
        forEachKey(docLanguages, function (lang) {
            if (!!storage && storage.test(lang)) {
                Hyphenator.languages[lang] = window.JSON.parse(storage.getItem(lang));
                prepareLanguagesObj(lang);
                if (exceptions.hasOwnProperty('global')) {
                    tmp1 = convertExceptionsToObject(exceptions.global);
                    forEachKey(tmp1, function (tmp2) {
                        Hyphenator.languages[lang].exceptions[tmp2] = tmp1[tmp2];
                    });
                }
                //Replace exceptions since they may have been changed:
                if (exceptions.hasOwnProperty(lang)) {
                    tmp1 = convertExceptionsToObject(exceptions[lang]);
                    forEachKey(tmp1, function (tmp2) {
                        Hyphenator.languages[lang].exceptions[tmp2] = tmp1[tmp2];
                    });
                    delete exceptions[lang];
                }
                //Replace genRegExp since it may have been changed:
                if (String.prototype.normalize) {
                    tmp1 = '[\\w' + Hyphenator.languages[lang].specialChars + Hyphenator.languages[lang].specialChars.normalize("NFD") + String.fromCharCode(173) + String.fromCharCode(8204) + '-]{' + min + ',}';
                } else {
                    tmp1 = '[\\w' + Hyphenator.languages[lang].specialChars + String.fromCharCode(173) + String.fromCharCode(8204) + '-]{' + min + ',}';
                }
                Hyphenator.languages[lang].genRegExp = new RegExp('(' + tmp1 + ')|(' + url + ')|(' + mail + ')', 'gi');
                if (enableCache) {
                    if (!Hyphenator.languages[lang].cache) {
                        Hyphenator.languages[lang].cache = {};
                    }
                }
                delete docLanguages[lang];
                callback(lang);
            } else {
                loadPatterns(lang, languagesLoaded);
            }
        });
        //call languagesLoaded in case language has been loaded manually
        //and remoteLoading is on (onload won't fire)
        languagesLoaded();
    }

    /**
     * @method Hyphenator~toggleBox
     * @desc
     * Creates the toggleBox: a small button to turn off/on hyphenation on a page.
     * @see {@link Hyphenator.config}
     * @access private
     */
    var toggleBox = function () {
        var bdy,
            myTextNode,
            text = (Hyphenator.doHyphenation
                ? 'Hy-phen-a-tion'
                : 'Hyphenation'),
            myBox = contextWindow.document.getElementById('HyphenatorToggleBox');
        if (!!myBox) {
            myBox.firstChild.data = text;
        } else {
            bdy = contextWindow.document.getElementsByTagName('body')[0];
            myBox = createElem('div', contextWindow);
            myBox.setAttribute('id', 'HyphenatorToggleBox');
            myBox.setAttribute('class', dontHyphenateClass);
            myTextNode = contextWindow.document.createTextNode(text);
            myBox.appendChild(myTextNode);
            myBox.onclick = Hyphenator.toggleHyphenation;
            myBox.style.position = 'absolute';
            myBox.style.top = '0px';
            myBox.style.right = '0px';
            myBox.style.zIndex = '1000';
            myBox.style.margin = '0';
            myBox.style.backgroundColor = '#AAAAAA';
            myBox.style.color = '#FFFFFF';
            myBox.style.font = '6pt Arial';
            myBox.style.letterSpacing = '0.2em';
            myBox.style.padding = '3px';
            myBox.style.cursor = 'pointer';
            myBox.style.WebkitBorderBottomLeftRadius = '4px';
            myBox.style.MozBorderRadiusBottomleft = '4px';
            myBox.style.borderBottomLeftRadius = '4px';
            bdy.appendChild(myBox);
        }
    };

    /**
     * @method Hyphenator~doCharSubst
     * @desc
     * Replace chars in a word
     *
     * @param {Object} loCharSubst Map of substitutions ({'ä': 'a', 'ü': 'u', …})
     * @param {string} w the word
     * @returns string The word with substituted characers
     * @access private
     */
    function doCharSubst(loCharSubst, w) {
        var r = w;
        forEachKey(loCharSubst, function (subst) {
            r = r.replace(new RegExp(subst, 'g'), loCharSubst[subst]);
        });
        return r;
    }

    /**
     * @member {Array} Hyphenator~wwAsMappedCharCodeStore
     * @desc
     * Array (typed if supported) container for charCodes
     * @access private
     * @see {@link Hyphenator~hyphenateWord}
     */
    var wwAsMappedCharCodeStore = (function () {
        if (Object.prototype.hasOwnProperty.call(window, "Int32Array")) {
            return new window.Int32Array(64);
        }
        return [];
    }());

    /**
     * @member {Array} Hyphenator~wwhpStore
     * @desc
     * Array (typed if supported) container for hyphenation points
     * @access private
     * @see {@link Hyphenator~hyphenateWord}
     */
    var wwhpStore = (function () {
        var r;
        if (Object.prototype.hasOwnProperty.call(window, "Uint8Array")) {
            r = new window.Uint8Array(64);
        } else {
            r = [];
        }
        return r;
    }());

    /**
     * @method Hyphenator~hyphenateCompound
     * @desc
     * Treats compound words accordingly to the 'compound' setting
     *
     * @param {Object} lo A language object (containing the patterns)
     * @param {string} lang The language of the word
     * @param {string} word The word
     * @returns string The (hyphenated) compound word
     * @access private
     */
    function hyphenateCompound(lo, lang, word) {
        var hw, parts, i = 0;
        switch (compound) {
        case "auto":
            parts = word.split('-');
            while (i < parts.length) {
                if (parts[i].length >= min) {
                    parts[i] = hyphenateWord(lo, lang, parts[i]);
                }
                i += 1;
            }
            hw = parts.join('-');
            break;
        case "all":
            parts = word.split('-');
            while (i < parts.length) {
                if (parts[i].length >= min) {
                    parts[i] = hyphenateWord(lo, lang, parts[i]);
                }
                i += 1;
            }
            hw = parts.join('-' + zeroWidthSpace);
            break;
        case "hyphen":
            hw = word.replace('-', '-' + zeroWidthSpace);
            break;
        default:
            onError(new Error('Hyphenator.settings: compound setting "' + compound + '" not known.'));
        }
        return hw;
    }

    /**
     * @method Hyphenator~hyphenateWord
     * @desc
     * This function is the heart of Hyphenator.js. It returns a hyphenated word.
     *
     * If there's already a {@link Hyphenator~hypen} in the word, the word is returned as it is.
     * If the word is in the exceptions list or in the cache, it is retrieved from it.
     * If there's a '-' it calls Hyphenator~hyphenateCompound
     * The hyphenated word is returned and (if acivated) cached.
     * Both special Events onBeforeWordHyphenation and onAfterWordHyphenation are called for the word.
     * @param {Object} lo A language object (containing the patterns)
     * @param {string} lang The language of the word
     * @param {string} word The word
     * @returns string The hyphenated word
     * @access private
     */
    function hyphenateWord(lo, lang, word) {
        var pattern = "",
            ww,
            wwlen,
            wwhp = wwhpStore,
            pstart = 0,
            plen,
            hp,
            hpc,
            wordLength = word.length,
            hw = '',
            charMap = lo.charMap.code2int,
            charCode,
            mappedCharCode,
            row = 0,
            link = 0,
            value = 0,
            values,
            indexedTrie = lo.indexedTrie,
            valueStore = lo.valueStore.keys,
            wwAsMappedCharCode = wwAsMappedCharCodeStore;
        word = onBeforeWordHyphenation(word, lang);
        if (word === '') {
            hw = '';
        } else if (enableCache && lo.cache && lo.cache.hasOwnProperty(word)) { //the word is in the cache
            hw = lo.cache[word];
        } else if (word.indexOf(hyphen) !== -1) {
            //word already contains shy; -> leave at it is!
            hw = word;
        } else if (lo.exceptions.hasOwnProperty(word)) { //the word is in the exceptions list
            hw = lo.exceptions[word].replace(/-/g, hyphen);
        } else if (word.indexOf('-') !== -1) {
            hw = hyphenateCompound(lo, lang, word);
        } else {
            ww = word.toLowerCase();
            if (String.prototype.normalize) {
                ww = ww.normalize("NFC");
            }
            if (lo.hasOwnProperty("charSubstitution")) {
                ww = doCharSubst(lo.charSubstitution, ww);
            }
            if (word.indexOf("'") !== -1) {
                ww = ww.replace(/'/g, "’"); //replace APOSTROPHE with RIGHT SINGLE QUOTATION MARK (since the latter is used in the patterns)
            }
            ww = '_' + ww + '_';
            wwlen = ww.length;
            //prepare wwhp and wwAsMappedCharCode
            while (pstart < wwlen) {
                wwhp[pstart] = 0;
                charCode = ww.charCodeAt(pstart);
                wwAsMappedCharCode[pstart] = charMap.hasOwnProperty(charCode)
                    ? charMap[charCode]
                    : -1;
                pstart += 1;
            }
            //get hyphenation points for all substrings
            pstart = 0;
            while (pstart < wwlen) {
                row = 0;
                pattern = '';
                plen = pstart;
                while (plen < wwlen) {
                    mappedCharCode = wwAsMappedCharCode[plen];
                    if (mappedCharCode === -1) {
                        break;
                    }
                    if (enableReducedPatternSet) {
                        pattern += ww.charAt(plen);
                    }
                    link = indexedTrie[row + mappedCharCode * 2];
                    value = indexedTrie[row + mappedCharCode * 2 + 1];
                    if (value > 0) {
                        hpc = 0;
                        hp = valueStore[value + hpc];
                        while (hp !== 255) {
                            if (hp > wwhp[pstart + hpc]) {
                                wwhp[pstart + hpc] = hp;
                            }
                            hpc += 1;
                            hp = valueStore[value + hpc];
                        }
                        if (enableReducedPatternSet) {
                            if (!lo.redPatSet) {
                                lo.redPatSet = {};
                            }
                            if (valueStore.subarray) {
                                values = valueStore.subarray(value, value + hpc);
                            } else {
                                values = valueStore.slice(value, value + hpc);
                            }
                            lo.redPatSet[pattern] = recreatePattern(pattern, values);
                        }
                    }
                    if (link > 0) {
                        row = link;
                    } else {
                        break;
                    }
                    plen += 1;
                }
                pstart += 1;
            }
            //create hyphenated word
            hp = 0;
            while (hp < wordLength) {
                if (hp >= lo.leftmin && hp <= (wordLength - lo.rightmin) && (wwhp[hp + 1] % 2) !== 0) {
                    hw += hyphen + word.charAt(hp);
                } else {
                    hw += word.charAt(hp);
                }
                hp += 1;
            }
        }
        hw = onAfterWordHyphenation(hw, lang);
        if (enableCache) { //put the word in the cache
            lo.cache[word] = hw;
        }
        return hw;
    }

    /**
     * @method Hyphenator~removeHyphenationFromElement
     * @desc
     * Removes all hyphens from the element. If there are other elements, the function is
     * called recursively.
     * Removing hyphens is usefull if you like to copy text. Some browsers are buggy when the copy hyphenated texts.
     * @param {Object} el The element where to remove hyphenation.
     * @access public
     */
    function removeHyphenationFromElement(el) {
        var h, u, i = 0, n;
        switch (hyphen) {
        case '|':
            h = '\\|';
            break;
        case '+':
            h = '\\+';
            break;
        case '*':
            h = '\\*';
            break;
        default:
            h = hyphen;
        }
        switch (urlhyphen) {
        case '|':
            u = '\\|';
            break;
        case '+':
            u = '\\+';
            break;
        case '*':
            u = '\\*';
            break;
        default:
            u = urlhyphen;
        }
        n = el.childNodes[i];
        while (!!n) {
            if (n.nodeType === 3) {
                n.data = n.data.replace(new RegExp(h, 'g'), '');
                n.data = n.data.replace(new RegExp(u, 'g'), '');
            } else if (n.nodeType === 1) {
                removeHyphenationFromElement(n);
            }
            i += 1;
            n = el.childNodes[i];
        }
    }

    var copy = (function () {
        var makeCopy = function () {
            var oncopyHandler = function (e) {
                    e = e || window.event;
                    var shadow,
                        selection,
                        range,
                        rangeShadow,
                        restore,
                        target = e.target || e.srcElement,
                        currDoc = target.ownerDocument,
                        bdy = currDoc.getElementsByTagName('body')[0],
                        targetWindow = currDoc.defaultView || currDoc.parentWindow;
                    if (target.tagName && dontHyphenate[target.tagName.toLowerCase()]) {
                        //Safari needs this
                        return;
                    }
                    //create a hidden shadow element
                    shadow = currDoc.createElement('div');
                    //Moving the element out of the screen doesn't work for IE9 (https://connect.microsoft.com/IE/feedback/details/663981/)
                    //shadow.style.overflow = 'hidden';
                    //shadow.style.position = 'absolute';
                    //shadow.style.top = '-5000px';
                    //shadow.style.height = '1px';
                    //doing this instead:
                    shadow.style.color = window.getComputedStyle
                        ? targetWindow.getComputedStyle(bdy, null).backgroundColor
                        : '#FFFFFF';
                    shadow.style.fontSize = '0px';
                    bdy.appendChild(shadow);
                    if (!!window.getSelection) {
                        //FF3, Webkit, IE9
                        e.stopPropagation();
                        selection = targetWindow.getSelection();
                        range = selection.getRangeAt(0);
                        shadow.appendChild(range.cloneContents());
                        removeHyphenationFromElement(shadow);
                        selection.selectAllChildren(shadow);
                        restore = function () {
                            shadow.parentNode.removeChild(shadow);
                            selection.removeAllRanges(); //IE9 needs that
                            selection.addRange(range);
                        };
                    } else {
                        // IE<9
                        e.cancelBubble = true;
                        selection = targetWindow.document.selection;
                        range = selection.createRange();
                        shadow.innerHTML = range.htmlText;
                        removeHyphenationFromElement(shadow);
                        rangeShadow = bdy.createTextRange();
                        rangeShadow.moveToElementText(shadow);
                        rangeShadow.select();
                        restore = function () {
                            shadow.parentNode.removeChild(shadow);
                            if (range.text !== "") {
                                range.select();
                            }
                        };
                    }
                    zeroTimeOut(restore);
                },
                removeOnCopy = function (el) {
                    var body = el.ownerDocument.getElementsByTagName('body')[0];
                    if (!body) {
                        return;
                    }
                    el = el || body;
                    if (window.removeEventListener) {
                        el.removeEventListener("copy", oncopyHandler, true);
                    } else {
                        el.detachEvent("oncopy", oncopyHandler);
                    }
                },
                registerOnCopy = function (el) {
                    var body = el.ownerDocument.getElementsByTagName('body')[0];
                    if (!body) {
                        return;
                    }
                    el = el || body;
                    if (window.addEventListener) {
                        el.addEventListener("copy", oncopyHandler, true);
                    } else {
                        el.attachEvent("oncopy", oncopyHandler);
                    }
                };
            return {
                oncopyHandler: oncopyHandler,
                removeOnCopy: removeOnCopy,
                registerOnCopy: registerOnCopy
            };
        };

        return (safeCopy
            ? makeCopy()
            : false);
    }());


    /**
     * @method Hyphenator~checkIfAllDone
     * @desc
     * Checks if all elements in {@link Hyphenator~elements} are hyphenated, unhides them and fires onHyphenationDone()
     * @access private
     */
    function checkIfAllDone() {
        var allDone = true,
            i = 0,
            doclist = {};
        elements.each(function (ellist) {
            var j = 0,
                l = ellist.length;
            while (j < l) {
                allDone = allDone && ellist[j].hyphenated;
                if (!doclist.hasOwnProperty(ellist[j].element.baseURI)) {
                    doclist[ellist[j].element.ownerDocument.location.href] = true;
                }
                doclist[ellist[j].element.ownerDocument.location.href] = doclist[ellist[j].element.ownerDocument.location.href] && ellist[j].hyphenated;
                j += 1;
            }
        });
        if (allDone) {
            if (intermediateState === 'hidden' && unhide === 'progressive') {
                elements.each(function (ellist) {
                    var j = 0,
                        l = ellist.length,
                        el;
                    while (j < l) {
                        el = ellist[j].element;
                        el.className = el.className.replace(unhideClassRegExp, '');
                        if (el.className === '') {
                            el.removeAttribute('class');
                        }
                        j += 1;
                    }
                });
            }
            while (i < CSSEditors.length) {
                CSSEditors[i].clearChanges();
                i += 1;
            }
            forEachKey(doclist, function (doc) {
                onHyphenationDone(doc);
            });
            if (!!storage && storage.deferred.length > 0) {
                i = 0;
                while (i < storage.deferred.length) {
                    storage.deferred[i].call();
                    i += 1;
                }
                storage.deferred = [];
            }
        }
    }

    /**
     * @method Hyphenator~controlOrphans
     * @desc
     * removes orphans depending on the 'orphanControl'-setting:
     * orphanControl === 1: do nothing
     * orphanControl === 2: prevent last word to be hyphenated
     * orphanControl === 3: prevent one word on a last line (inserts a nobreaking space)
     * @param {string} part - The sring where orphans have to be removed
     * @access private
     */
    function controlOrphans(part) {
        var h, r;
        switch (hyphen) {
        case '|':
            h = '\\|';
            break;
        case '+':
            h = '\\+';
            break;
        case '*':
            h = '\\*';
            break;
        default:
            h = hyphen;
        }
        //strip off blank space at the end (omitted closing tags)
        part = part.replace(/[\s]*$/, '');
        if (orphanControl >= 2) {
            //remove hyphen points from last word
            r = part.split(' ');
            r[1] = r[1].replace(new RegExp(h, 'g'), '');
            r[1] = r[1].replace(new RegExp(zeroWidthSpace, 'g'), '');
            r = r.join(' ');
        }
        if (orphanControl === 3) {
            //replace spaces by non breaking spaces
            r = r.replace(/[\ ]+/g, String.fromCharCode(160));
        }
        return r;
    }

    /**
     * @method Hyphenator~hyphenateElement
     * @desc
     * Takes the content of the given element and - if there's text - replaces the words
     * by hyphenated words. If there's another element, the function is called recursively.
     * When all words are hyphenated, the visibility of the element is set to 'visible'.
     * @param {string} lang - The language-code of the element
     * @param {Element} elo - The element to hyphenate {@link Hyphenator~elements~ElementCollection~Element}
     * @access private
     */
    function hyphenateElement(lang, elo) {
        var el = elo.element,
            hyphenate,
            n,
            i,
            lo;
        if (Hyphenator.languages.hasOwnProperty(lang) && Hyphenator.doHyphenation) {
            lo = Hyphenator.languages[lang];
            hyphenate = function (match, word, url, mail) {
                var r;
                if (!!url || !!mail) {
                    r = hyphenateURL(match);
                } else {
                    r = hyphenateWord(lo, lang, word);
                }
                return r;
            };
            if (safeCopy && (el.tagName.toLowerCase() !== 'body')) {
                copy.registerOnCopy(el);
            }
            i = 0;
            n = el.childNodes[i];
            while (!!n) {
                if (n.nodeType === 3 //type 3 = #text
                        && (/\S/).test(n.data) //not just white space
                        && n.data.length >= min) { //longer then min
                    n.data = n.data.replace(lo.genRegExp, hyphenate);
                    if (orphanControl !== 1) {
                        n.data = n.data.replace(/[\S]+\ [\S]+[\s]*$/, controlOrphans);
                    }
                }
                i += 1;
                n = el.childNodes[i];
            }
        }
        if (intermediateState === 'hidden' && unhide === 'wait') {
            el.className = el.className.replace(hideClassRegExp, '');
            if (el.className === '') {
                el.removeAttribute('class');
            }
        }
        if (intermediateState === 'hidden' && unhide === 'progressive') {
            el.className = el.className.replace(hideClassRegExp, ' ' + unhideClass);
        }
        elo.hyphenated = true;
        elements.counters[1] += 1;
        if (elements.counters[0] <= elements.counters[1]) {
            checkIfAllDone();
        }
    }

    /**
     * @method Hyphenator~hyphenateLanguageElements
     * @desc
     * Calls hyphenateElement() for all elements of the specified language.
     * If the language is '*' then all elements are hyphenated.
     * This is done with a setTimout
     * to prevent a "long running Script"-alert when hyphenating large pages.
     * Therefore a tricky bind()-function was necessary.
     * @param {string} lang The language of the elements to hyphenate
     * @access private
     */

    function hyphenateLanguageElements(lang) {
        /*function bind(fun, arg1, arg2) {
            return function () {
                return fun(arg1, arg2);
            };
        }*/
        var i = 0,
            l;
        if (lang === '*') {
            elements.each(function (lang, ellist) {
                var j = 0,
                    le = ellist.length;
                while (j < le) {
                    //zeroTimeOut(bind(hyphenateElement, lang, ellist[j]));
                    hyphenateElement(lang, ellist[j]);
                    j += 1;
                }
            });
        } else {
            if (elements.list.hasOwnProperty(lang)) {
                l = elements.list[lang].length;
                while (i < l) {
                    //zeroTimeOut(bind(hyphenateElement, lang, elements.list[lang][i]));
                    hyphenateElement(lang, elements.list[lang][i]);
                    i += 1;
                }
            }
        }
    }

    /**
     * @method Hyphenator~removeHyphenationFromDocument
     * @desc
     * Does what it says and unregisters the onCopyEvent from the elements
     * @access private
     */
    function removeHyphenationFromDocument() {
        elements.each(function (ellist) {
            var i = 0,
                l = ellist.length;
            while (i < l) {
                removeHyphenationFromElement(ellist[i].element);
                if (safeCopy) {
                    copy.removeOnCopy(ellist[i].element);
                }
                ellist[i].hyphenated = false;
                i += 1;
            }
        });
    }

    /**
     * @method Hyphenator~createStorage
     * @desc
     * inits the private var {@link Hyphenator~storage) depending of the setting in {@link Hyphenator~storageType}
     * and the supported features of the system.
     * @access private
     */
    function createStorage() {
        var s;
        function makeStorage(s) {
            var store = s,
                prefix = 'Hyphenator_' + Hyphenator.version + '_',
                deferred = [],
                test = function (name) {
                    var val = store.getItem(prefix + name);
                    return !!val;
                },
                getItem = function (name) {
                    return store.getItem(prefix + name);
                },
                setItem = function (name, value) {
                    try {
                        store.setItem(prefix + name, value);
                    } catch (e) {
                        onError(e);
                    }
                };
            return {
                deferred: deferred,
                test: test,
                getItem: getItem,
                setItem: setItem
            };
        }
        try {
            if (storageType !== 'none' &&
                    window.JSON !== undefined &&
                    window.localStorage !== undefined &&
                    window.sessionStorage !== undefined &&
                    window.JSON.stringify !== undefined &&
                    window.JSON.parse !== undefined) {
                switch (storageType) {
                case 'session':
                    s = window.sessionStorage;
                    break;
                case 'local':
                    s = window.localStorage;
                    break;
                default:
                    s = undefined;
                    break;
                }
                //check for private mode
                s.setItem('storageTest', '1');
                s.removeItem('storageTest');
            }
        } catch (ignore) {
            //FF throws an error if DOM.storage.enabled is set to false
            s = undefined;
        }
        if (s) {
            storage = makeStorage(s);
        } else {
            storage = undefined;
        }
    }

    /**
     * @method Hyphenator~storeConfiguration
     * @desc
     * Stores the current config-options in DOM-Storage
     * @access private
     */
    function storeConfiguration() {
        if (!storage) {
            return;
        }
        var settings = {
            'STORED': true,
            'classname': hyphenateClass,
            'urlclassname': urlHyphenateClass,
            'donthyphenateclassname': dontHyphenateClass,
            'minwordlength': min,
            'hyphenchar': hyphen,
            'urlhyphenchar': urlhyphen,
            'togglebox': toggleBox,
            'displaytogglebox': displayToggleBox,
            'remoteloading': enableRemoteLoading,
            'enablecache': enableCache,
            'enablereducedpatternset': enableReducedPatternSet,
            'onhyphenationdonecallback': onHyphenationDone,
            'onerrorhandler': onError,
            'onwarninghandler': onWarning,
            'intermediatestate': intermediateState,
            'selectorfunction': selectorFunction || mySelectorFunction,
            'safecopy': safeCopy,
            'doframes': doFrames,
            'storagetype': storageType,
            'orphancontrol': orphanControl,
            'dohyphenation': Hyphenator.doHyphenation,
            'persistentconfig': persistentConfig,
            'defaultlanguage': defaultLanguage,
            'useCSS3hyphenation': css3,
            'unhide': unhide,
            'onbeforewordhyphenation': onBeforeWordHyphenation,
            'onafterwordhyphenation': onAfterWordHyphenation,
            'leftmin': leftmin,
            'rightmin': rightmin,
            'compound': compound
        };
        storage.setItem('config', window.JSON.stringify(settings));
    }

    /**
     * @method Hyphenator~restoreConfiguration
     * @desc
     * Retrieves config-options from DOM-Storage and does configuration accordingly
     * @access private
     */
    function restoreConfiguration() {
        var settings;
        if (storage.test('config')) {
            settings = window.JSON.parse(storage.getItem('config'));
            Hyphenator.config(settings);
        }
    }

    /**EXPORTED VALUES**/

    /**
     * @member {string} Hyphenator.version
     * @desc
     * String containing the actual version of Hyphenator.js
     * [major release].[minor releas].[bugfix release]
     * major release: new API, new Features, big changes
     * minor release: new languages, improvements
     * @access public
     */
    var version = '5.2.0(devel)';

    /**
     * @member {boolean} Hyphenator.doHyphenation
     * @desc
     * If doHyphenation is set to false, hyphenateDocument() isn't called.
     * All other actions are performed.
     * @default true
     */
    var doHyphenation = true;

    /**
     * @typedef {Object} Hyphenator.languages.language
     * @property {Number} leftmin - The minimum of chars to remain on the old line
     * @property {Number} rightmin - The minimum of chars to go on the new line
     * @property {string} specialChars - Non-ASCII chars in the alphabet.
     * @property {Object.<number, string>} patterns - the patterns in a compressed format. The key is the length of the patterns in the value string.
     * @property {Object.<string, string>} charSubstitution - optional: a hash table with chars that are replaced during hyphenation
     * @property {string | Object.<string, string>} exceptions - optional: a csv string containing exceptions
     */

    /**
     * @member {Object.<string, Hyphenator.languages.language>} Hyphenator.languages
     * @desc
     * Objects that holds key-value pairs, where key is the language and the value is the
     * language-object loaded from (and set by) the pattern file.
     * @namespace Hyphenator.languages
     * @access public
     */
    var languages = {};

    /**
     * @method Hyphenator.config
     * @desc
     * The Hyphenator.config() function that takes an object as an argument. The object contains key-value-pairs
     * containig Hyphenator-settings.
     * @param {Hyphenator.config} obj
     * @access public
     * @example
     * &lt;script src = "Hyphenator.js" type = "text/javascript"&gt;&lt;/script&gt;
     * &lt;script type = "text/javascript"&gt;
     *     Hyphenator.config({'minwordlength':4,'hyphenchar':'|'});
     *     Hyphenator.run();
     * &lt;/script&gt;
     */
    function config(obj) {
        var assert = function (name, type) {
            var r,
                t;
            t = typeof obj[name];
            if (t === type) {
                r = true;
            } else {
                onError(new Error('Config onError: ' + name + ' must be of type ' + type));
                r = false;
            }
            return r;
        };

        if (obj.hasOwnProperty('storagetype')) {
            if (assert('storagetype', 'string')) {
                storageType = obj.storagetype;
            }
            if (!storage) {
                createStorage();
            }
        }
        if (!obj.hasOwnProperty('STORED') && storage && obj.hasOwnProperty('persistentconfig') && obj.persistentconfig === true) {
            restoreConfiguration();
        }

        forEachKey(obj, function (key) {
            switch (key) {
            case 'STORED':
                break;
            case 'classname':
                if (assert('classname', 'string')) {
                    hyphenateClass = obj[key];
                }
                break;
            case 'urlclassname':
                if (assert('urlclassname', 'string')) {
                    urlHyphenateClass = obj[key];
                }
                break;
            case 'donthyphenateclassname':
                if (assert('donthyphenateclassname', 'string')) {
                    dontHyphenateClass = obj[key];
                }
                break;
            case 'minwordlength':
                if (assert('minwordlength', 'number')) {
                    min = obj[key];
                }
                break;
            case 'hyphenchar':
                if (assert('hyphenchar', 'string')) {
                    if (obj.hyphenchar === '&shy;') {
                        obj.hyphenchar = String.fromCharCode(173);
                    }
                    hyphen = obj[key];
                }
                break;
            case 'urlhyphenchar':
                if (obj.hasOwnProperty('urlhyphenchar')) {
                    if (assert('urlhyphenchar', 'string')) {
                        urlhyphen = obj[key];
                    }
                }
                break;
            case 'togglebox':
                if (assert('togglebox', 'function')) {
                    toggleBox = obj[key];
                }
                break;
            case 'displaytogglebox':
                if (assert('displaytogglebox', 'boolean')) {
                    displayToggleBox = obj[key];
                }
                break;
            case 'remoteloading':
                if (assert('remoteloading', 'boolean')) {
                    enableRemoteLoading = obj[key];
                }
                break;
            case 'enablecache':
                if (assert('enablecache', 'boolean')) {
                    enableCache = obj[key];
                }
                break;
            case 'enablereducedpatternset':
                if (assert('enablereducedpatternset', 'boolean')) {
                    enableReducedPatternSet = obj[key];
                }
                break;
            case 'onhyphenationdonecallback':
                if (assert('onhyphenationdonecallback', 'function')) {
                    onHyphenationDone = obj[key];
                }
                break;
            case 'onerrorhandler':
                if (assert('onerrorhandler', 'function')) {
                    onError = obj[key];
                }
                break;
            case 'onwarninghandler':
                if (assert('onwarninghandler', 'function')) {
                    onWarning = obj[key];
                }
                break;
            case 'intermediatestate':
                if (assert('intermediatestate', 'string')) {
                    intermediateState = obj[key];
                }
                break;
            case 'selectorfunction':
                if (assert('selectorfunction', 'function')) {
                    selectorFunction = obj[key];
                }
                break;
            case 'safecopy':
                if (assert('safecopy', 'boolean')) {
                    safeCopy = obj[key];
                }
                break;
            case 'doframes':
                if (assert('doframes', 'boolean')) {
                    doFrames = obj[key];
                }
                break;
            case 'storagetype':
                if (assert('storagetype', 'string')) {
                    storageType = obj[key];
                }
                break;
            case 'orphancontrol':
                if (assert('orphancontrol', 'number')) {
                    orphanControl = obj[key];
                }
                break;
            case 'dohyphenation':
                if (assert('dohyphenation', 'boolean')) {
                    Hyphenator.doHyphenation = obj[key];
                }
                break;
            case 'persistentconfig':
                if (assert('persistentconfig', 'boolean')) {
                    persistentConfig = obj[key];
                }
                break;
            case 'defaultlanguage':
                if (assert('defaultlanguage', 'string')) {
                    defaultLanguage = obj[key];
                }
                break;
            case 'useCSS3hyphenation':
                if (assert('useCSS3hyphenation', 'boolean')) {
                    css3 = obj[key];
                }
                break;
            case 'unhide':
                if (assert('unhide', 'string')) {
                    unhide = obj[key];
                }
                break;
            case 'onbeforewordhyphenation':
                if (assert('onbeforewordhyphenation', 'function')) {
                    onBeforeWordHyphenation = obj[key];
                }
                break;
            case 'onafterwordhyphenation':
                if (assert('onafterwordhyphenation', 'function')) {
                    onAfterWordHyphenation = obj[key];
                }
                break;
            case 'leftmin':
                if (assert('leftmin', 'number')) {
                    leftmin = obj[key];
                }
                break;
            case 'rightmin':
                if (assert('rightmin', 'number')) {
                    rightmin = obj[key];
                }
                break;
            case 'compound':
                if (assert('compound', 'string')) {
                    compound = obj[key];
                }
                break;
            default:
                onError(new Error('Hyphenator.config: property ' + key + ' not known.'));
            }
        });
        if (storage && persistentConfig) {
            storeConfiguration();
        }
    }

    /**
     * @method Hyphenator.run
     * @desc
     * Bootstrap function that starts all hyphenation processes when called:
     * Tries to create storage if required and calls {@link Hyphenator~runWhenLoaded} on 'window' handing over the callback 'process'
     * @access public
     * @example
     * &lt;script src = "Hyphenator.js" type = "text/javascript"&gt;&lt;/script&gt;
     * &lt;script type = "text/javascript"&gt;
     *   Hyphenator.run();
     * &lt;/script&gt;
     */
    function run() {
            /**
             *@callback Hyphenator.run~process process - The function is called when the DOM has loaded (or called for each frame)
             */
        var process = function () {
            try {
                if (contextWindow.document.getElementsByTagName('frameset').length > 0) {
                    return; //we are in a frameset
                }
                autoSetMainLanguage(undefined);
                gatherDocumentInfos();
                if (displayToggleBox) {
                    toggleBox();
                }
                prepare(hyphenateLanguageElements);
            } catch (e) {
                onError(e);
            }
        };

        if (!storage) {
            createStorage();
        }
        runWhenLoaded(window, process);
    }

    /**
     * @method Hyphenator.addExceptions
     * @desc
     * Adds the exceptions from the string to the appropriate language in the
     * {@link Hyphenator~languages}-object
     * @param {string} lang The language
     * @param {string} words A comma separated string of hyphenated words WITH spaces.
     * @access public
     * @example &lt;script src = "Hyphenator.js" type = "text/javascript"&gt;&lt;/script&gt;
     * &lt;script type = "text/javascript"&gt;
     *   Hyphenator.addExceptions('de','ziem-lich, Wach-stube');
     *   Hyphenator.run();
     * &lt;/script&gt;
     */
    function addExceptions(lang, words) {
        if (lang === '') {
            lang = 'global';
        }
        if (exceptions.hasOwnProperty(lang)) {
            exceptions[lang] += ", " + words;
        } else {
            exceptions[lang] = words;
        }
    }

    /**
     * @method Hyphenator.hyphenate
     * @access public
     * @desc
     * Hyphenates the target. The language patterns must be loaded.
     * If the target is a string, the hyphenated string is returned,
     * if it's an object, the values are hyphenated directly and undefined (aka nothing) is returned
     * @param {string|Object} target the target to be hyphenated
     * @param {string} lang the language of the target
     * @returns {string|undefined}
     * @example &lt;script src = "Hyphenator.js" type = "text/javascript"&gt;&lt;/script&gt;
     * &lt;script src = "patterns/en.js" type = "text/javascript"&gt;&lt;/script&gt;
     * &lt;script type = "text/javascript"&gt;
     * var t = Hyphenator.hyphenate('Hyphenation', 'en'); //Hy|phen|ation
     * &lt;/script&gt;
     */
    function hyphenate(target, lang) {
        var turnout, n, i, lo;
        lo = Hyphenator.languages[lang];
        if (Hyphenator.languages.hasOwnProperty(lang)) {
            if (!lo.prepared) {
                prepareLanguagesObj(lang);
            }
            turnout = function (match, word, url, mail) {
                var r;
                if (!!url || !!mail) {
                    r = hyphenateURL(match);
                } else {
                    r = hyphenateWord(lo, lang, word);
                }
                return r;
            };
            if (typeof target === 'object' && !(typeof target === 'string' || target.constructor === String)) {
                i = 0;
                n = target.childNodes[i];
                while (!!n) {
                    if (n.nodeType === 3 //type 3 = #text
                            && (/\S/).test(n.data) //not just white space
                            && n.data.length >= min) { //longer then min
                        n.data = n.data.replace(lo.genRegExp, turnout);
                    } else if (n.nodeType === 1) {
                        if (n.lang !== '') {
                            Hyphenator.hyphenate(n, n.lang);
                        } else {
                            Hyphenator.hyphenate(n, lang);
                        }
                    }
                    i += 1;
                    n = target.childNodes[i];
                }
            } else if (typeof target === 'string' || target.constructor === String) {
                return target.replace(lo.genRegExp, turnout);
            }
        } else {
            onError(new Error('Language "' + lang + '" is not loaded.'));
        }
    }

    /**
     * @method Hyphenator.getRedPatternSet
     * @desc
     * Returns the reduced pattern set: an object looking like: {'patk': pat}
     * @param {string} lang the language patterns are stored for
     * @returns {Object.<string, string>}
     * @access public
     */
    function getRedPatternSet(lang) {
        return Hyphenator.languages[lang].redPatSet;
    }

    /**
     * @method Hyphenator.getConfigFromURI
     * @desc
     * reads and sets configurations from GET parameters in the URI
     * @access public
     */
    function getConfigFromURI() {
        var loc = null,
            re = {},
            jsArray = contextWindow.document.getElementsByTagName('script'),
            i = 0,
            j = 0,
            l = jsArray.length,
            s,
            gp,
            option;
        while (i < l) {
            if (!!jsArray[i].getAttribute('src')) {
                loc = jsArray[i].getAttribute('src');
            }
            if (loc && (loc.indexOf('Hyphenator.js?') !== -1)) {
                s = loc.indexOf('Hyphenator.js?');
                gp = loc.substring(s + 14).split('&');
                while (j < gp.length) {
                    option = gp[j].split('=');
                    if (option[0] !== 'bm') {
                        if (option[1] === 'true') {
                            option[1] = true;
                        } else if (option[1] === 'false') {
                            option[1] = false;
                        } else if (isFinite(option[1])) {
                            option[1] = parseInt(option[1], 10);
                        }
                        if (option[0] === 'togglebox' ||
                                option[0] === 'onhyphenationdonecallback' ||
                                option[0] === 'onerrorhandler' ||
                                option[0] === 'selectorfunction' ||
                                option[0] === 'onbeforewordhyphenation' ||
                                option[0] === 'onafterwordhyphenation') {
                            option[1] = new Function('', option[1]);
                        }
                        re[option[0]] = option[1];
                    }
                    j += 1;
                }
                break;
            }
            i += 1;
        }
        return re;
    }

    /**
     * @method Hyphenator.toggleHyphenation
     * @desc
     * Checks the current state of the ToggleBox and removes or does hyphenation.
     * @access public
     */
    function toggleHyphenation() {
        if (Hyphenator.doHyphenation) {
            if (!!css3hyphenateClassHandle) {
                css3hyphenateClassHandle.setRule('.' + css3hyphenateClass, css3_h9n.property + ': none;');
            }
            removeHyphenationFromDocument();
            Hyphenator.doHyphenation = false;
            storeConfiguration();
            toggleBox();
        } else {
            if (!!css3hyphenateClassHandle) {
                css3hyphenateClassHandle.setRule('.' + css3hyphenateClass, css3_h9n.property + ': auto;');
            }
            Hyphenator.doHyphenation = true;
            hyphenateLanguageElements('*');
            storeConfiguration();
            toggleBox();
        }
    }

    return {
        version: version,
        doHyphenation: doHyphenation,
        languages: languages,
        config: config,
        run: run,
        addExceptions: addExceptions,
        hyphenate: hyphenate,
        getRedPatternSet: getRedPatternSet,
        isBookmarklet: isBookmarklet,
        getConfigFromURI: getConfigFromURI,
        toggleHyphenation: toggleHyphenation
    };

}(window));

//Export properties/methods (for google closure compiler)
/**** to be moved to external file
Hyphenator['languages'] = Hyphenator.languages;
Hyphenator['config'] = Hyphenator.config;
Hyphenator['run'] = Hyphenator.run;
Hyphenator['addExceptions'] = Hyphenator.addExceptions;
Hyphenator['hyphenate'] = Hyphenator.hyphenate;
Hyphenator['getRedPatternSet'] = Hyphenator.getRedPatternSet;
Hyphenator['isBookmarklet'] = Hyphenator.isBookmarklet;
Hyphenator['getConfigFromURI'] = Hyphenator.getConfigFromURI;
Hyphenator['toggleHyphenation'] = Hyphenator.toggleHyphenation;
window['Hyphenator'] = Hyphenator;
*/

/*
 * call Hyphenator if it is a Bookmarklet
 */
if (Hyphenator.isBookmarklet) {
    Hyphenator.config({displaytogglebox: true, intermediatestate: 'visible', storagetype: 'local', doframes: true, useCSS3hyphenation: true});
    Hyphenator.config(Hyphenator.getConfigFromURI());
    Hyphenator.run();
}


/*global Hyphenator*/
Hyphenator.languages['de'] = {
    leftmin: 2,
    rightmin: 2,
    specialChars: "äüößſ",
    patterns: {
        3: "2aaa1äa1ba1da1ga1j2aoa1öa1p2aqa1ßa2ua1xä1aä1bä1dä1gä1jä1k1äqä1ß1äxä1z1bibl21cacä3c1dc4h1cic1jc4k3co2cp2cs3cu1cy1de1did1ö1due1be1d4eee1fe1ge1ke1m2eoe1pe1qe1ße1te3üe1wey1e1z1fa1fä1fe1fi1fo1fö1fu1fü1fy2gd1geg1n1guh1j2hl2hnh1q2hr4hsh2ü2hwh1zi1a2iä2ici1d2ifi1ji1ßi1üj2u1ka1käkl21ko1kök1q2ks1kü1le1li4ln1lo1lö1ly1ma3mä1me1mi1mo1mö1mu1mü1my1na1nä1ne1nin1j1noo1b2oco1d2oi2ol2omo1qo2uo1vo1xö1bö1dö1e1öf2önöo1ö1ßö1vö1wö1zp2a1päp2e1php1j1puqu42rc1re1ri4rnr1q1ru1rü1ry1sa1sä1sc1se1si1so1sös1t1su1sü1ße1ßiß1j1ßu1ta1tä1tet1h1ti1to2tö2ts1tu2tü2ua2ucu1h2uiu1ju1lun12uou1q2usu1w1üb2üc2üdü1gü1k2ünü1ß2ütü1vü1zve2v2r2vsw2aw2ä2wnw2rw2ux1a1xe1xix1jx1q1xu2xyx1zy1by1ey1gy1hy1jy1ly1py1ry1vy1wy1yzä2zu1zw2",
        4: "_ax4_äm3_ch2_en1_eu1_fs4_gd2_gs4_he2_ia4_in1_ks2_oa3_öd2_pf4_ph4_ps2_st4_th4_ts2_um3_ur1_xe3a1abaa1ca3au2abaab1ä1abd1abf1abg1abh2abi1abkab1l1abnab3r1abs2abu2abü1abw2aby1abz2aca2acc2acu1add2adf2adh5adj2ado2adp2adq2adu2a1eae2bae2cae2da2ekae2pa2eta2ewae2xaf1a2afe2afia2fö2agaag2n2agt2ah_2ahsa1huah1wa1hyaif2a2il2aisaje22ak_2akb2akc2akd4ako2aks1akza1laa1lä2ale2ali2aloa1lu4aly2am_2amä2amf2amk2amla2mö2amu1anb2ane1anf1anh2anj1anl2anna1nö1anra1nü1anwao1ia1opa1or2ap_2apa2apea2pfap2n2apr2ar_a1raa1rä1arb2are2arf2arh2ari2arr2arua2rü2arv2ary4asha2söa2süaße22a1tata1at2cat2eat2h3atmat1ö4atra3tü2au_2aub4auc2aue2aug2auj4aum4aunau1o2auu2auw2aux2auz2a1ü2a1v4avia2vr2a1wax2eays4ay3t2a1zaz2aaz2oaz2uäb2sä1ckä2daä2dräd2s2ä1eäf3läf3räf2säg2näh1aä3hi2ähm2ähsä1huäh1wä1imä1la2äleä1lu2ämläm2s2än_2äne2änsä1onä1paär1äär1c4äreä1röä2rü1ärzä3suä3teät2häu1cä2uf1äug4äul2äumä2un2äur1äuß4ä1v3bah3basb2ärb2äs4b1bb3bebb2sbbu12b1c3be_3bea3beb3bek3bel1bembe1o3bet1bezbge3bib23bilbiz24b1j2bl_b2leb2lo3blü2b1mbni2bo4abo2cboe1b1op2böfb1öl2b1qb2r42br_3brä3brü4b1sb3säb3scb4slb2söbss2bs2t4b3tb5teb4thbt4rbtü1bu2fbü1c2b1v2b1w3by1by3pbys2ca1h3camc4an3carcäs22c1ccch22cec2cefce1i2cek1cen1cer1cetce1u2c1f4ch_2chb2chc2chd2chf2chg2chh2chj2chk2chp4chs2cht4chü2chv4chw1chy2chzci1cci2s4ck_ck1ack1ä2ckb2ckc2ckd1cke2ckf2ckg2ckh1cki2ckk2ckm2ckp4cks2ckt1cku2ckv2ckw1cky2ckzclo1co2ccoi22c1qcre2cry2cs2ac2si4c1tcti22c1z3da_da1ad1afd1agda1sdä2u2d1cd3dhd5dodeg2d1eides1det2dga2d3gl3di_3dicdi2edi1p2d1j4d1ld3ladni2d1obdo2o2d1qd2r4d3rid3rö2d1s4dsb4dsld2södss4dst42d1td2thdto2d3tödt3rd3tüdu2fdu1idu1odur22düb3düf3dün2d1wdwa2dy2s2d1z2e1aea2ceak1eam3e2ase1ä22eba2ebl2ebre3bue1ce2ecle3cr2ected2eed2öee1eeeg2e1eie1en2ef_2efa2efe2efi2eflefs22efu2efüegd4e3gee2gn2egue1hee1hi2ehme1hoehs22ehte1hue1hüeh1we1hy4eibe2idei1ee4ilei1p2eire2it2eiu2e1jek2a1ekdek4nek2oek4r2ektek2ue1la2eli2eln2eloe1lü2elz2ema2emm2emüen3fe4nre4nten1ue1nüe1nye1ofe1ohe4ole1ore1ove1ö2e3pae3puer1ae1räer1cer3h2erie1roer1ö2eru2esbes2c2esf4eshes3l2esmes2ö2esp2esres3we3syes3ze3teet2he3tie3tö2etre3tü2etz2euf1euke1um2euneu1p2eut2eux2e1ve3vo2ewae3wä2eweew2s2ex_3exp2exuey4neys4e3ziez2wfab43facf4ahf2alf2arf3atfä1cf1äu2f1cfe2c3fewf1ex3fez2f1fff2efff4ff3lff2s3fi_fid2fi2ofi2r3fis3fiz2f1jf2l22fl_1fläf3löf4lü2föf2f1qf2r2f3ruf3rü4f1sf3scf3sifs2tf2süf3sy4f1tf2thf3töf3tü3fugf1umf2ur3fut2fübfü2r2f1v2f1w2f1zfz2afz2öfzu33ga_ga1c5gaiga1kgäs5gä4ugbi22g1cg1dag1dog1dögdt4gd1uge1cged4gef4g2el4g1gg3gegg4r2g1h4gh_gh2egh1lg2hugh1w2g1j4gl_2gls3glüg2ly2gn_gn2e2gng2gnp2gns2gnt2gnug2nüg2ny2gnzgo4a2goggo1igo1y2g1qg2r4gse2g4slgso2gsp4g4swg3sy2g1tg3tegt2sg3tügu1cgu2egu2t2gübgür1güs32g1v2g1w3haah1ahh1aph2as2h1c2heahe3x2hi_2hiahi2ehi2n2hio2hiuhlb4hld4hlg4hll2hlm2h2lo2h1mh2moh3möhm2sh2muh2nah2nähn2eh1nu2hodhoe42hoih2on2hoo2hop3hov1h2öhö2ch4örhr1chr3dhrf2hrg2h2rihrr4h3rüh2ryhrz2hss24h1th2thhto2h4tshtt4h3tühu1chu2n2hurhüs32h1vhvi23hyg3hyphz2o2ia_i4aai2ab2iaci2afi2ahi3aii2aji2ak2iali2am2iani2apia1q2iasi3au2iavi1ämiär22i1bib2oi2böice1idt4i2dyie1ci1eii1exif3lif3rif2s2i1gi2gli3go4i1hi3heih3mih3nih3rihs2ih1wi3i2ii4s2i1k4ikei2kni1la6ilbil2cilf22iloilv42im_2ime2imo2imt2imu2inein3f2inoi1nö2inp2inrin1ui1ny2i1oio1cio2dion2i2ori2oui2ovio2xi3ön2ip_i1pai1peiph2ip4li1pr2ips2ipu2i1qi1räir1cir2eir2i2irki1roi1rö2isb2iseis3ti2sü4itäi6tli3töi3tü2itzium12i1v2i1w2i1xi2xai3xi2i1zi2zöja1c2jatje2aje1cje2gje2pje3wji2ajit3ji2vjoa3jo2iju2kjus32j1v3ka_ka1ck2adk2agka2o3kask1ähk1änkär2kby42k3cki1c3kir2kiz2k3j4kl_k2lek1lu2kly2k1mk2n2k3nek3nu3knü3komk2onk2os3kowkö2fk1ölk2r4kst44k1tk2thktt2k3tükt3zku1ckuh12kübkü1c2k1v2k1w3la_1lad2laf1lai3lao1lawlay1lä1c1läd2läf4lät2l1blb2slb2u2l1c4l1dld3rldt43le_2lec3ledle2e3lehl2ek2leple2u3levl2ey2l1flf4u2l1glgd4l3go3li_3liali1cl2ie3ligli3l2limli2o3liu4l1j2l1klk2l4l1lllb4llg4llk4ll5mlln22l1mlm3plm3tlnd2l3nil1nul1nü3loklo2o2lox2löd4lög4löß2l1plp2fl3pu2l1q4l1s4l1tl2thl6tsltt2l3tü1luf4luo2lur3lux2lüb5lüd2l1v2l3wly3c3lynly1oly3u2l1zl2zölz1wm1abmae2ma1f3mas3maßm4aymb4lmby42m3c2m1dmd1ameb43mehme1o2meö3mesmeu13mi_mi1c3mig3mil3mit2m1jm3ka4m1lm3li4m1mmmd2mmm2mm3pmm2smoa33moh3mom3mos3motmo1ymö2c4mökm1öl2m1pm2pfm3pim3pu2m1q4m1sm3säm3scm3sem2süm3sy4m1tm2thm3tömtt2m3tümt3zmu1a3munm4us2müb3mün3müt2m1vmwa2my4s2m1z3na_n1af3nain1ar3nas3natn1au3näe3näs2näunby42n1cn2ck2n1dn2döndy33ne_2nec3nedn1efneg4ne2l3nenne2un2ew3nez2n1fnf2änff4n3finf4lnf2onf4rnf3s4n1gng3mn2gnn3hän3hen3hu3nian1idn4ie3niknin1n2ip2nitni3v3nix2n1k4n1nnn3fnng4n3ni3no_no1cn1of3nov3now3noz2nödn2ör2n1q6n1snsp4n3sy2n1tn3ton3tön4tsn3tun3tü1nu_1nud3nuenuf21nug1nuinu2n1nuo2nup2nur1nut1nuu1nux1nuz3nü_3nüs1nüt4n1w1ny_1nyhn1yo1nyr1nys1nyw2n1znz3so4aco4ado4aho2aro2aso4ato5au2obbob2e1objob1lo3cao1ceo1ck2odrodt4o2ecoen12ofa2ofiof3l2ofo2oft2o1go3ghogs2o1hao1häo1heo1hio1hooh1soh3to1huoh1wo3ieo1imo1inoi2r2o1j2o1kok4n4okrokt4o1lao1läol2io3loo1lu3olyoms2omy12ona2onä2onc2oneono1o1nuon3v1onyon3zoof2o1opo1oro1pao1pi2or_or1ao3räor1c4ore2orf2orh2orm2orq2orro3ru2osh2osio3sk2oso2o1to3tüoub4oug2o3uho3um2our2ouv2o1ü2ovi2ovo2o1wo3wiox2aox2eo2xu1oxyo1yo2o1zoz2eo3ziöb2l2ö1cödi3öf3lög3lög3rö1heö1huö1keök3r3öl_öls2öm2sön2eö3niön2sö1nuö1peör1cöru4ö2saö2spö2stö3su2ö1töt2höts2öze31pa_1paa1pacpag41pak1pap2paß1pat1pau3päd3pär3päs2p1b2p3cpda41pe_pe2a1pedpef4pei13pel1pem1pep3pet4pf_1pfäpff4pf3r2p1g4ph_ph2a2phä2phb4phd2phf4phg4phkph2l2phm2phn2phöph4r2phs2phz3pik1pilpi2o3pip3pispku22pl_3pläp4lo2p1n1p2opo1c3podpo2i3pokpo2wpo3xpö2c2p1ppp3lppt2p2r2p4rä2p1s4ps_p3sep2söp2st2p1tpt1ap3tep2thptt2ptü4pt3zpu1apub42puc2pur3put1püf2pülpün22p1v2p1w3py1pys4py3t2p1z1ra_r1abr2ad1raer2afr2air2alr2apr1arr2as2raß1rat1raür2ax4räf4räg2räh2rämrä2u2r1brbb2rb2orb2srb2ur1ce2r1dr2dördt43re_2reä3reg3rekre2u2reür1ew3rez2r1frf2u4r1gr1h42rh_2rha2rhä2rhö2rhsrid2r2ie3rigr2isr2itrix12r1j2r1krk4n4r1lrl2erl3t4r1mrm2urnd4r3nern3frng2r3nirn1ör1nur1nür1nyro1c2rof3roir2onr1or4roß2rox2röf4rögr1ök4röpr1örrp4erpf4r3porp3tr3pu2r1rrrb2rr1crr2or3ru4r1sr3sirs3lr3sor3sy4r1tr3tör4tsrtt4r3türt3zru1a3ruf4rug2rum3rut4ruz2rüb2r1v2r1w4r1xry2c2r1zrz2ö3sa_3saa3sams1an3sat3säl2sc_s2ci2scj4scl2scos2cr2scs2scusd4r3see3seh3seq3set2s1hsh2as3häsh3ns3hösh4rsib43sio2s1j4sk_4skbsk4lsk4n4skö4skss3läsl3bs3les3li4sna4snö3so_so4aso1c3sog3sol3somso3o3sos3sov3sow3sozsö2csö2fs1ös1sp22sp_s2pä2spls3pn4spy2s1q6s1sss3l6st_s2ta2stb2stdst2e2stf2stg4sth2stj2stk4stl4stm2stns2to1stö2stp2stqs2trst2u1stü2stv2stwsu2n3suv3süc3sün4s3v2s1ws3was3we1s4ysyl12s1zsz2os3zü2ß1c2ß1d2ß1f2ß1h2ß1l2ß1mß1o2ßos2ßst22ß1t2ß1ü2ß1v2ß1w2ß1z3ta_4taatah2t2ai2tam3tas3tav3tax4täbtä1c4täd3täe3täg2täh4tämt1äptä2st2ät2täx4t1ct4ckt3cr3te_2teh3ten3tes4th_th2e1thi2thk2thp2ths2thü2thvt2hy3tig3tik3tio3tip3tis3tiv2t1j4t3ltl4e3to_to1c3tod3tok3ton3too4toß3tow4töftö4l3tön4töß3töttpf42t1q2tr_3tritry14ts_ts1ot2söt3sy4t1tt3tit3tot3töttt4t3tut3tü2tub3tuc2tud3tue4tuf2tuh2tuk4tüb3tüf3tüm4t3v4t3wtwa21ty13typtys44t1ztz1ätz2öu1amu3auu1ayu1ämu1äu2u1bub2lub1ru1ce2u1d2u1eu2edu2eguen1u2ep2uffuf3luf3r2u1gugo3u2göu2gü2uh_uh1wu1ieu3iguk2au1keu1kiuk4nuk2öu1kuulb4ulg4u2lü1umf1umg1umk1uml4umm1umr1umz4un_u3ne2unk1unruns21unt1unw2unzu3ofuos2u1pau3piu1pr2ur_u1raurd22ure2urfu1röur3purt2u3ruurü2u2sü2u1ß2u1tu3teuto1u3töu3tüu1ü22u1xux2eux2oux3tu1ya2u1z2übc2übdübe2üb3lüb3rüd3rüf3lü2gnüg3süh1aü1heüh1iüh1süh3tü1huüh1wül1aül2cül4eü1luün2sünt2ü1nuü1peü1piür1aürr2ür2süs2aü2stva1cva1sv4at2v1b2v1dve3bve3cve3dve3gve3hve4ive3over1ves12veüve3v2v1g2v1hvi2cvig22v1k2v1m2v1n3vol3voyvö2c2v1pv3revs2e2v3t2v1v2v1w2v1z1waa1wag1wah1walwa2p1was1wäh1wäl1wäswbu22w1c2w1dwe2a1weg1wehwe2i1wet2w1g2w3h1widwi2ewik21wil2w1k2w1l2w1mwn3s1wohwot21wöc2w1pw3ro2w1sws2t2w1twti21wucwul2wus21wühwül2wün32w1w1xa_1xae2x1b2x1c4x1d2xekxe2lx1emx2en3xes2x1f2x1g2x1hxib4xi1cxi3gxil12x1l2x1m2x1nx1or4x1p2x1r4x1txt1äxt1uxu1axu2s2x1v2x1w3xy_3xys1yacy1äty1c2y1d4y2efy1f2ygi2yg2lyhr2y1i4y1k2yl3cynt2y1nuy1ofyom2y1osy1ouypa2ype2y2pfy3phypo3y3riyrr2yse1y1t2yu2ry1z2za1c3zahz1anz1as2z3czdä1ze1e2z1h2z1j3zolzo2oz1orz1öl2zön2z1qz3saz3shz3skz3sz2z1tz3töz3tüzu3azub4zud4zu3kzuz22züb2z1v4z1zzz2ö",
        5: "_ab1a_abi4_ab3l_abo2_ack2_ag4n_ag4r_ag2u_ai2s_ang2_an3s_apo1_aps2_as3t_at4h_au3d_ät2s_by4t_dab4_de1i_de1s_dü1b_dys1_ei3k_eke2_enn2_er1e_erf4_er1i_es1p_et2s_eu3t_ext4_fe2i_fi2s_ga4t_ge3u_hi2s_im2a_im5m_in3e_ink4_inu1_ire3_is2a_jor3_ka2i_ki4e_kus2_li2f_ma3d_ma2i_me2e_ne4s_ni4e_nob4_nus2_ob1a_obe2_or2a_ort2_ozo4_pro1_ro4a_ro3m_rü1b_sch4_sha2_te2e_te2f_te2s_ti2a_tid1_ti2s_to2w_umo2_un3d_un3e_un3g_un3s_ur2i_ut2a_ut3r_übe4_vo4r_wa2s_wi4e_wor2_ya4l_za2s_zi2e_zwe2aa2beaa2gr4a2araart2aas5tab2äuab1ebabe1eabei12abela3ber2abet2abew3abfiab1irab1it2ableab3liab4loa2blua2bo_ab2of2abora3braa4brä2abrü2abs_abs2aab5scab3spabst4ab3szab1uraby4ta1cem2ach_ach1a2achba1che4achfa1chiach3lach3mach3na1choach3öach3ra4chta1chuach3ü2achvac1in2ada_ad2agada2m4adav1a2dä2ade_2aden4a3diad2obad3ru2ads2ad3stad3szad2t1ad4tead4tra2elaa2eleae2o3aes5ta2faka2fana3faraf4ata2faua2fexaf2fl2af3lafo1saf3raaf3räaf3reaf3röaf2spag1abag1arag1auag2diag2drag2duage1iag2er2agesag3gl1aggr2a2glag4laa4glöag4nuag4roagsa2ags3pag2th2a1haah4at2a1heahe1sa1h2iahin3ah2löahnt21ahorah1osa2h3öahr1aah3riaht3saian3aid2sai1e2aien3ai3g4a3ik_ai3keai3kuai2loa1indain4ea1ingai2saaiso2a3iv_aive3a3ivla3ivs2akal2akarak4at4a1kea2kefa2keu2a1ki2ak3lak4li2a1kr4akra3akroak3sh2akta2aktb2a1kua2kun4a3kü2ala_al1abal1afala2ga3lalal1ama2larala4s2alatal1aual1ämal2bralb3sal2däal2dral3dualen1ale2pale4talf4r3algi3almba2l1öal3öfal2ös1alphal2ufa2lumal1ural2zw2am2aamab4amad2ama3g2am4e4ame_a2meba3meta2mewa3miea3mis2ammlammu2am3pr2am2sam3sa1amt_am4töam2tu2ana_2anabana3ca3nak2anam2ananan1äs2anbuan3ch2and_2andua3nee2anfi4ang_2angf2anghang1l2angoang1r2a3ni2ank_an3klank1rankt42anmu3annäan1oda3nola3nos2anpr1ansä1ansc2ansk2ant_2anto1antr1antw2a1nuanu3s2anzb2anzg2anzs1anzü2anzwa1os3ao3t2a3ot_a2pefap2faa3pfla3phäa2pht2ap3la2pot3applap3pu2a3pua3ra_ar2ab2arb_4arba2arbiar2bl2arbr2arbt2arbu1ar1ca2reaa4rega2reha4reka3renare3uar2ewarf1rar2glar2gnar2iaar1ima3riuarm2äarn2e2a1roar1oba2rorar2rh2arsaarse32arsiar2st2arto2artsar1ufar1uhar1umarwa2ar2zä2arze1arztas3aua2s1äa2sca4as2ea2seba3ses2asisas1ora2s1pas2phas2pias2poa3spuas2stas3teas3tias3to2astraßen3at1abat2afat4agata3la3tama2tatat1aua2t1ä4ate_a2teb4atena2tep4atesat3ha3athl4a3ti4atorat3räat3reat2saat2seat2siat2soat3taatt3sa3tubatu2nat2zoau2draue2baue2sau2faauff43aufn4au1iau2isau3lüaun2eau1nua4unz2aup22ausc1ausd3ausf1ausg1auslau2so1ausr1ausü1ausz2aut_2aute1autoauz2wa3v4aawi3eax4am2a1yaa1yeuaysi1ä2b3lä1cheä1chiäch3lä2chrä1chuäck2eäf2fläge1iäge3sä2g3lä2g3räg4ra1ä2gy2ä3heähl1aähl2eäh3neäh3riä1is_ä1iskä2k3lä2k3rälbe2äl2bläl2p3ämt2eän5deän2dräne1sän2f52ängeän2glän2gr2ä3niänk2eän2kränk2säp2pläp2präp4stär4afäre2när2grärk2särm2sär1o2ärse2är4siär2stärt4eär2thär2zwä5s4eäse3tä2s1päss2eäs2stäs4träte2nät1obä2t3rät2saät2sääts3lät4trät2zwäu2bräude3äu3eläuf2eäug3läu2maäun2eäu1nuäu3seä3usgä3uskä3usnäu2späu2trba2bl2babs2b1afbais2ba2kabak1lbak1rbal2a2b1amban2ab1ang2banlban3tb1anzbar3bbar3nba2scba2stbau3gbau1sba1yobben3bbe4pbb2lö2b3d4bde1sbe3anbe3arbe3asb2ebe1be1cbedi4be1eh3bef4be3g2beil2b2einbe3li1ben_ben3nbe1ra3be1sbes2abe1ur3b2ew2b1ex2b5f4bfal22b1g2bges42b5h2bhut2bi3akbibe2bie2sbik2abil2abi2lubin2ebi2o1bio3dbi3onbiri1bi3seb1isobi2spb2it_b2itebi2tu2b1k4b3lad3blatb3leb3blemb4letb3leub2lie2bligb4lisb2litb4locb3los2blun3blut4b3n2bnis1bo5asb1ob3bo2blbo2brbo3d22b1ofbo3febo1is3bon_bond1bo2ne3bonsbo4räbor2sb1ortbo2scbo3thbo2xibö2b32b1p2bpa2gb4ra_b4rahbrä4u2bre_3brea2breg3bremb4rer2brigb4riob3rohb4ronb4rucbru4sbs3arbsat2b4särbs2äubs2cabs4cub3se_bse2bbsi4tbs2kubso2rbs2plb3stob3stöb3stübtal3btil4b4ts2bu2e3bu3libung4b2urgbu2sa2b3z22c1abca2chca2e3ca3g4cal3tca2pecar3ncas3tca1y2ceco4ce2drcen3gcere3ce3sh2ceta2chab2chaf1chaoch1äs1chef4chei2chic2chl2ch2lech2lu4ch2m2chn42chobcho2fch1ohch2r44chrech3rh2chuf2chuh2chum1cka_2ckac1ckag2ckalcka4r2ckau2ckeh2ckexck1imck1in3ckis2ck3l2ck3nck1o22ck3rckt2e3c4l2clet4co3chco2d2co3dicoff4co1itco2keco2lecol2oco2peco1racor3dco3recos3tco4te1c4r2cte3ecti4octur6cu2p32d1ab2d1acd2ac_dagi2dah3lda1ho3d4aida1inda1isdal2ada3löd1altdamo3d4ampd2an_d1ang2danw2d1apd2aph4dapp3darlda2rod3arrdar3sd1artda2rudas4tdat2a4datmdau3e2dauk2d1äh2d1äp2därzdä3us2d1b4dbu2cdco4r2d1d2ddar2de2adde3asde3b43de1cde1e4de3gldehe2de3hod2eicde2löd2en_dend2den3gd2enhde2nide1nude1ondepi2d4er_de3rude2sade2spde2sude1unde3us2dexp2d1f42d1g2dga3gd2ge_2d1h2d2hisdi4abdi2addi4amdi1cediet3dik2adin2adi2obdi2spdist2di2tadi2thdit3sdi2tu3di5vdi3z22d1k4d3l2edli2f2d3m24d5n2dnis1d2obadob4ld2obrdole4doll22doped2opp2dorc2dordd2orp2dortd2os_dos3sdost1dot6hdo3undö2l13d2ör2d3p2drag4d3rai2drädd4räh4dre_2dreg4drem2d3rhd4ri_d4ridd4ried4rifd4rikd4rild3robd3rocd4roid3roud5rubdrü1bd2sands1änd3seidse4td3shodso2rd2späds2pods2pud2steds2tids2tud2sundta2dd5teadt3hodt5s2du1ardub3l2d1uh2dumd2dumf2dumg2dumld2ump2dumrd1umsdung42dunrdun2s2duntdus3t2d1v2e3a2beab3lea2drea2g4ea3gaea3gleakt2ea2laeam1oea2nae2anoe3ar_ea2rae3arre3arveas3se3athea5tre3aug2ebedebe2i2ebeleb2en2ebeteb3loeb2lö2eb2oebot2ebö2seb4rueb2s1ebse22e3caech1äe1chiech3lech3mech3ne1chuech1weci6a2eckteco3dec1s4e3d2aed2dre3deiede2re3d2oeds2äed2suedu2se3dy3ee3a2eeb2lee2ceee1chee2ckeede3e1effeef4leef3see1imeel2ee1empeena2e2enäe2encee3nie2enoeen3see1rae1erde1erkee1röeert2e1erzee3s2ees3kee3taee2thee1u2e1e2xef1are2fate2fäue3fe_ef1emef2er2eff_1effief2flefi2s1efkue3fraef4rüef3soef3spe2fumege1ue2gloeg3nieg2thegus32e1ha2e1häeh2eceh2ele3hereh1läehle2eh3loeh3mue3holehr1äeh3rieh3sheh3übei2blei3de2eidn1eifrei3gl2eigt2eigu2eil_2eilbeil3d2eilne1impei4näein3kei3o2eip2fei3ree1irre2is_2eitäei3teei2theitt4e3ke_e3kene3kese3keye3k2lekt2oe3k2wela2cel1afela2h2elaoela4s2e1läel2da2ele_elea2ele2c2eleh2elei1eleke3lepel2ete3leu2elevele2x1elf_el3feelf4l1elfm1elfte3lieel3klel3leelm2ael5nae2lofe2lolelon2elö2selto22e1luel1ure2lyaelz2eema2keme2se2mop3empfem2saem2stem3t21emule2n1a4ena_2enace3nade4naf4enahe4nak4enam4enaten1äu2ene_2enem2enen2enesenf2aenf2uen3geen2gl1engpe3ni_e3nice2nide3niee3nio2enise3nit2enive2nofen1ohe3nolen1one3noteno2w2e1nöen3sp1entd1entn2entü1entw1entz2enut4enwüeo2fee1on_e1onde1onfe1onhe1onle1onre1onse1opee1opfeop4te3or_e3orbe3orse3orweo1s2e3os_eo3ulepa2gep3leep2paep4plep2prept2aepu2se3ra_era2ge1raie2rake1rale1rape2rare1rasera2ße1rawe1razer1äher1ämerb2eer3brer3da1erdber3de4ere_er1ebere2l2erer2ereserf2eerf4rerg3s2erhüe3ribe3rio2erk_erk3te3ro_er3oaer1ofer1ohe3rone3rose3rowerö2d2eröker3p4er3rä2errüers2aer3seers2ier3sker3sner3sper3sz4ertier3uzerü4bes3abes3ake3sceesch2es2eles2hues2ide2siles2ire4skees3kles3kue4skye3sote3spies3sces3se2essoe1stre1stues4tüeße2setab4et1am3etapet4atet1ähet2enete2oet3hüeti2m2e3toeto2bets2pet3suett1aet2thet2zäet2zweu1a2eu2gaeugs4euil4eu1ineu2käe3um_e3umbe3umleun2eeu1o2eur2eeu3speust4eut2heu2zw4everewä2se2we_e3wirewi2se3witex3atex1er1exis2ext_ex2tu2e3xye3z2aezi2sf1abefab5sfa2drfaib4fa2ke2fanb2fanf2fanlf1anp2fanrfan3s2fanw2f1ap3farifa3shf3aug3f4avfa2xa2f1b22f3d4fdie2f2echfe2drfe2eife1emfef4lf4eief1eisfel3tf2em_fem4m2fempfe2näfen3gfe2nof1entf2er_fe1raf2eref2ertf1erwfe2st3fete2fexpff3arff1auffe2eff3eiffe2mff4enf2fexff4laff4läff4lof3fluf3flüff3roff3röffs3t4f3g2fge3s2f1h2fi3atfien3fi3klfi2krfil3dfilg4fi3lif2inafi3nifin2sfi3olfi3rafis2afis2pfi3tu4f1k4f3ladf3lapf3länf4leef3lerflo2wf4luc2f3m2fma2d2f3n2fni2sfob2l2f1offoli3fo2nafon2efo2nu2f1opfo1ra3form2f1ök2f1ölför2s4f1p2f4racf5radfra4mf5rap2fre_f3recf3red2fregf3repf4reufri3dfri2e2frig1frisf3rocfro2sf3rotf2sanfs3arf4scefs4cofse4tf2sphfs1prfs3s4fs3thf4ta_f2tabft1afft1anft1arf3tatft3hoft1opft2s1ftsa2ftse4ft3stf2tumftwa4ft3z23f2uhfung42funt2gabfgab4r2gabz2gadlga1flga2kagal2ag4amo2ganbgan3d2ganh2ganl2ganwga1ny2garb2garc3gardg2arsga3ruga2saga2siga3spgas3sgat2a2gatmgat4rgau1cg2aukg1aus2g1äp2gärz2g1b2gber2gby4tgd1ing1d3rgd3s2ge3a2geb2ageb4rge1e2ge3ecge2esge1imge1irge2isge3lege3lügelz2ge3migem2uge3nagen3ggen3ngeo2rge1ouge3p4ge1ragerm4ge3sigest2ge5trge1ulge1ur2g1ex2g1f4gga4tg2g3lgg4log2g3n3gh2rgie3ggi2elgi2gugi3negi3tugi4us4g3k2g1labg1lac3glad3glätg2l4e2gle_3gleag3lecg3leg2glehg3len2glesg4lia2glib2glif2gligg2lik4gling2lio2glisg2lizglo3gg2lom2g1luglu2t2g1m2g2n2ag4na_2gnacg4nat3g2näg3neh2gneug2nieg2nifg4nin3g2nogno1r2g1of2g1ohgol2a2gord2gorggo2s1go3stgo3th2g1p2g4rebg4remg4rerg3retg3revgri2e3grif2grig2groc2grohgron4g4rosgro4ug4ruf2grut4g2s1gsa2gg3salgs3angs3arg3s2cg4scagsch4g4scogs2ehgsen1gs3ergse4tgsi2dg3silg3spigs3plgsrü2gs5s4gs3tag3stog3stögs3trg3stugs3tügti2mg5t4rgu3amgu1as2guedguet42g1uhgu1is3gummgu4stgut1agut3h2g3z2hab2ahab2eh2absha1kl2haleh1alph1amth2an_h2andh4ann2hanr2hantha2plha2pr2harbh2ardhasi1h1äff2h3b22h3d4hdan2he2adhe3behe2blhe3brhed2ghee4she2fä2heffhe2frhe2fuhe3guh1eieh1eifh1eighe2im4heioh1eiwhe3lihe3lohe2lö3hemdhe3mi3hemmh2en_he2näheng22henihe2nohen3z4he2ohe3onhe3ophe3phherg22hermhe3roh1eröhert2he3thhet2ih2e2uheu3ghe1y22h3f4hfi2s2h3g2hget42h1h2hi2achi1ce2hi3dh2idehi2krh1infh1inhhi3nohi4onhi3or2hip1hi2phhi2pih2i2rhi3rahi3rihirn1hi3rohir2shis2ahi2sehi2sthi1thhi3ti2h1k4h4lachla2nh1lash1lath3lädh1läsh1läuh3lebhle3eh3lerh3lesh3lexh2lieh2lifh2liph2lish2lith3lochl1ofhl1oph4lorh3löch2löshl3t2h3lufh3lukh1lüfh2mabh3magh3manh3marh4mäch4mähh4mälh4mäuh3me_hme1eh3menh4monhm3p4hm3sahms1phn1adh3namhn1anhn3d4h2nelhn3exh2nich2nidh2niehn1imhn1inh2niphn3k4h2norhnts2h2nuch2nulho2blho2efho4fa3hole4holo3holzhom2ehono3ho1rahor3dh1orgho3slho2spho4st2hot_ho3thh1o2xho1y2hö3ckhö2s1h3öst2h3p2hr1achr3adh1raih3räuh2rech3redh3refh3relh3rephre2th3revh3richri4eh3rinh2robh3rohh3rolh4ronh2rorh3rouhrs3khr2suhr4swhr2thh3ruhh4rübh2sanh2sauh2späh2sphh1stah1stoh2s1uh2t1ahta4nht2ash2tärht1ehhte2sh4thohtod1h3töpht4riht3röht2soht2sphtti2ht3z2hu2buhuko3hu2lähu2loh1umsh1unah1up_h1upshurg2hu3sahu2sohu2tihut2th4übsh3übuhvil4hwe1c2hy2thzug4iab4liaf4li3ak_i3akti5al_ia2läial3bial3dialk2i3allia2lui3am_i4amoian2ei3anni2anoi3anti3anzi3ar_ia2rai2ascia3shi2asiias3siast4i3at_i4ate1iatri3atsia3uni1är_i1ärsi1ät_i1ätaib1eiibe4nibi2ki3blai3blei4bräich1aich1äi1chei1chiich3lich3mi1choi1chuich1wi3damid2ani2deiidni3i2dol2i2drie3a2ie2bäie2blie2ckie2drie1e2iel3di1ell2i1eni3en_i3enai3endi2enei3enfi3enhi3enji3enki3enmi3enni3enöi3enpi3enrien2sie1nui3envi3enwi3enzie1o2i2erei4erii1ernie2röie3sui1ettieu2eie1unif1arif4atif1aui2fecife2iif2enif2flif4läi1flüif4rai1freif3seif3spif2taiga3iig1läig4nai4gnäig4noig4raig3säig4seig3soi2harihe1eihe4ni4is_i4i3ti2käri3ki_ik1ini2k3lik3noiko3si2kölik3räik3reik1s2ik3soik3szikt2eikt3ri2kuni3kusi1lä1il2daild1oil2drile2hil1el2ill_2illsil3öfi1lu2i2lumi3lusim4ati2megi2meji2meki2mew1immo1impoimp4s1impuim2stin2afin3ami3napina4sin1äsin3do2indrin3eii3nelin1euine2x2ingain2gl4inhei3nie2inigin2ir2inis2inn_2innlin1odin1orino3tin3suint2hin3zwi2odaio3e4iof4li2o3hio3k4i3ol_i3om_i3omsi3on_ion3di2onyi2o1pio4pfi3opsi3opti3or_i3orci3orpi3orsi3ortio3s2i2osti3ot_i3otsi3oz_i1ö2ki1ös_ipen3i3perip3fa2i1piipi2sip2plip3pui1r2ai3radirat2ir2bli3ree2irekir2glirg4sir2he2irigir4mäir2no1ironiro2sirr2hir3seir3shir2sti3sacis2api2saui2scaise3eisi2ais1opis1pais1peis3sais2stis4töis4tüit1amit1ani3tatit1auit2ärität22itelite4ni2texi5thr1itiii5tocit3rei3truit2sait2soit1uhitut4it2zä2i3u2i2vebive4niwur2ix2emiz1apiz1auize2niz4erizo2bi2z1wja3nejani1ja1stje3najet3tjo2b1job3rjoni1jo1rajord2jo2scjou4lju2blju3nijur2ok3a2aka3ar2kabh2kabska1frka1inka3kak1allkalo5k3amakand4kan2ekank42kanlk1anska3nu2kanw3kara2karbk2ardk2argk2arkk2arskar3tkaru2k2arwka3sekasi1kas3s2kattk1auskäse32k3b4kbo4nkbu2s2k3d2k1effkefi4kege2ke2glk1einkei1skeit2ke2lake2läkel1ek4eltk2en_ke2no2keo2ke2plk2er_k2erck2erlkerz2k6es_ket3ske1up2k3f42k1g22k1h4kho3mki3a4ki3drki2elki3k4ki3liki3lok2imik2in_k2ing2kinhk2inik2innkin3ski3orkio4skis2pkist2ki3zi2k1k44kla_k4lar4kle_4kleh2klic2kligk2link3lipk2lir4klizk4lopklö2sk2lötkluf23knabk4neiko2al2kobjkoff4ko1i2kol4ako3leko4muko3nu2kop_ko1pe2kops2kopzko3riko2spko2stko3ta2k1ouko2wek1o2x2k1p2k4rawk4raz2kre_2kreg2k3rh2krib2krip3kris2krufkrü1bk2sanks3ark2sauks2änksch4ks3hak3sofks1pak3speks2puks3s2k1stak1stek1stok1strk1stuk2s1uk3talkt1amkt1anktä3skte3ekt1eik2texkt3hokt1imk3topkt4rokt3s4kul2a4kulpkung42kuntku2roku2spkus3tku2sukür4s2k3z2kze3lla3ba2labb2labf2labg2labhlab2ol2abrl1abt3labu2labwla1celad2il1adl2ladm3ladul1advla2falaf3slaf3tla2gala2gnlago2l2akk2l1al4lall4lalpl2amil2amp2lanb2lanf2lanll1anp2lanslar3sla2ru4lasdla3se2lash2lasila2so2laspla2stlat2ala3telat2s1lauglawa41länd2läub2läuc2läue1läufl3bacl3blälb3lel2blil3blolb3salb3selb4sklb3splbs6tl3chel3chilch3llch3rlch3ülch1wlda2gld1all3daml3dasl3datld1auld1ärl2deil2dexldo2rld2osld2ö2l2dreld4rüld3sald3stld3thle2adle2bl4leddle3dele3eilef2ale2gäle2glleg4r4lehs4lehtl2eicl2eidl2eitlel3s4lemplem3sl2en_le2näl2enfle3nil2enkle1os3lepa3lepf3leprl2er_lerb4lerk2ler3tl1erzles2ele3shlesi1le3skles2t4lesw2lesy2leto4leud3leut2lexe2lexzl3fahlfe1elf3lolf2trlfur1lga3tlg3rel3gro2l1h23lhi_li3acli3akli3amli3arlia1sli3b4libi34lickli4ds3lie_lig4nli3keli2krlil2a3limol1inv2linzli4om3lis_li2spliss2lit2ali3telit2hli3tu2lixili2zalk3lolk4nelk4ralk2s1lk3sälks3tl3k2ülla2nl3lapll1aullch4ll3d4ll2emll2esl2lexll3l2ll1obl3lowll3shll5t4llu2fll1urll3z2lme2el2möllmpf4lms2tlna4rl3n4e2lobjl2obrlo1fllof4rloi4rlol2a2lopf2loptlo1ralo4rä2lorcl1ordlo3ro3lorq3los_lo4sa3loselo2talot4h2l1ovlo2velö2b3l2ö2fl1öhrlpi4plp3t42l3r2lre1slrut4lrü1bl3sacl2saul3sexl4shalsho2ls2pols3s2lst2al2stels4trls2tuls1uml2sunlsu3sl2tabltag4lt1aklt1ehlt2enlt3hol3thul2toblt1oplto2wlt1öll3törlt1ösl3trält3relt3sclt2solt1uhlu1anluba2lubs2lu2drlu2es2lufflu2golu2gu2l1uhlume22lumf2lumll2umpl1umsl1umw1lu2n2lunt2lunwl1urnl1urt2luselu2splu4stlu2tälüh1lly1ar2lymply3nolzo2flz3t2m2abe2mabk2mabs2mabtma2cima3damal3dmalu4mam3m2manbm2anfm2anh2manlm4ann2manzma2orm2app2marb4marrm1arzmat4cma3unma1yom1ähnmä1i2m1ärg2m1b2mbe2em3b4rm2d1äm2deimds2em2e1cmedi32medyme1efmega1m2eil3meldmell2m2en_m2ens2meou3mer_me1rame2ro3mersmes1ame4sä4mesume3th2m1ex2m1f4mfi4l4m1g22m1h4mi2admi3akmibi1mi3damie3lmi2ermi4etmi2kimi2ku4milzmi3nimi1nu3mir_mi3ra3miri3mirs3mirwmi2samise1mi2tami2th4mitz4m1k4m2mabmm1eimm3simm3spm2mummm2unmmül22m3n22mobj3m2odmo2dr4mog_mo2i32mol_mom2e3m2onmo3ne3mo2o2moptmo1ramork4m1o2xmp2flm3ponmp3ta2m3r2m2sanm4sapms1asm2saumsch2m4scom4sexmso2rm2späms2poms2pums3s2m3stoms4trms4tüms1ummt1abmt1akm3tammt1armt3homti2smt1ösm4ts1mt2samt2semt1um2m3uhmu3la2mulsmu3nim4unkmunt24munzmu3ra3musimu2spmus3tmu2sumuts32m1w2mwa4rmwel42n1abna2bä4nabg4nabhna2bln2abona2br4nabt3n2ac4naddn2ade3n2ag3n2ahn3ahnnai2en1aig2n1akna2ka3nakon2al_na2län4alena2lu2nalyn4am_3name3namon1an_4nanb2nanh2nani4nank2nanl3nannna3non1anp2nanr2nanw5nar_2narcn2ard4narg3narin2ark2narmn2arpn2as_4naspn4ata4natmnats14natt4naufn3aug5naui3n2äcn1ähn2n1ännä2scn2äss2n3b4nbe3nnbes4nbu2snch3mnd2agndat2nd1aun2dein2dobndo1cnd1opnd1orn2drönd3thndt4rn2dü4ne2apne3asne3atne2bl3necane1ckne2de2nee33nehm2n1ein2eid4neifne2ke3nelanel3bne3lin2em_n4en_n2enbn2encn2enhne2nin2enjnen3kne2non2ensn2envn2enwne2obne1os2nepfn2er_ne1ranere2n1erfn1erh3nerin1erkne2ron2erpn2erv3n2esn4es_nes4cnes1one2thneu1cneu3gneur22n1exnf1aknfo1snft2on2f1ung1adng3d4n3gefn3gerng3g4ng3hun2glon2glöng3neng1orngs3cng3tsn2gum2n1h4n3hann3harn3haunhe2rnib4lni2deni3drnie3bni1elnig2anig3rni3klni2kr3n2ilnim2o2ninfni2obni3okni3olni3ra3n2isni2tinit4sni3tunk2amn2kähnke2cnk2lonk2lunk4nan2knenk2öfn2köl2n3l22n1m4n2naunne2snn2exn2nofnn3scnn3senn2thnn1ur3nobl2no2dno3drn3olen2on_3nor_nor2a2norc3norh3norm3norsn1ortno3shno2täno2tr2nö2f2n3p4npa2gnpro1npsy32n3r2n3savns2cans1ebnse2tn3sexn3siln4sphn2sponsrü2ns3s2ns2tins2tunst2ün2styns2umnta3mnt4atnt1ämnte2bnte1ent1ehnt2enn3ternteu3nte3vn3thrnti3cntmo2nt3sants2onts2pnts2tntum4nt3z21nu1anu3arnubi11nu1cnu2esnu2fe2n1uhnu3k4n2um_2numf2numg3numm2numr2nuna2nunt3nu2snu3scnu3senu3slnu2ta2nü4bnür1c2n1v2n3ver2nymun2zadn2zann2zärnz1ecn2zornz2öln2zwö2o3a2o4abioa3deo4a3ioa3ke2obano3bar2obe_2obea2obewobi4t2o3boo3briob3skobs2pob3sz2o3buobu2s2o3bü2oby4och1ao1cheoch3loch3moch1ooch3roch1socht2o1chuoch1wo3ckeo3ckio2ckoo3d2aod2dro3debo3dexo3diro2donodo4so2dre2o3du2o1e2o4e3so2e3to3et_o3etsof1amof1auof2eno3feroffs2of2fuof1laof4läof4löof3raof3räof4rüofs1aof3thoga3dog2loo3g4nog3spohl1aoh3looh2lu3ohngoh2ni1ohnmo2h3öohr1aoh1ro2o1hyo1i2do2isco1ismoiss2oi1thoki2ook1läo2labol2arol4drole3eoler2ole3sol1exol2faol2flolf1rol2glol2grol2klolk3rol2of1olymol2zwo2mabo2mebome3co2melo2mepom2esom3maom3pfomtu3ona2bo2naeo3nalon1apon2auonbe3one2ion3f2ong4rong3s4o3nion3k2onli4o3nodono3sons1aonsi2ons3lons1pont2hont3s2onukoor3foo4skoo2tr2o1ö2opab4o3panopa5so1peco1pei2opf_op2fäo2pfeopf1l4oph2o3pheopin2op3li2o3poop4plop2pr2o1pr1opsiop3szo1rad2orak2oral3oramo1rasor1ätorb2l2orcaor2ce4orda1ordnor2do2ordr2ords2ordwore2hor1eror3gaor2glor2gn4oril2oritork2aork2s2o1ro2o1röorr4aor3rh2ors2or3shor3szor4töor2ufo2r3üo2ryaos3ados4anosa1sos4co2o3seose3eose2no3shoo4skaos3keo4skios2lo2os1pos2peos2saos4säos3to2osu42o3syo2tebote2s4ot2hot4heo2throt2inotli2ot4olot2oroto1so3traot2saot3scots1pot2thou2ceou2geou3glouri4outu4ove3so3wecoy1s4o3z2aozon1ö2bleö2b3röb2s3öch1lö2chröch2söcht4öd2stöf2flöh3riö3ig_ö2ko3öl1a2öl1eiöl1emöl4enöl1imöl1inöl3laöl1o2öl3saöl3szö2l1uölz2wönn2eön3scön3spöpf3lör3a2ör2drör2glör2klör1o2örs2eört2eör2trös2stös3teös2thös3trö2t3aöt2scöt2trözes4pa3dapa2drpa3ghpa1ho3pala1paläpa3li2paltpank42panl2pannpant2panz4papi23para1parc2parg1paro2parppa4stpat4cp3auf3pä2cpä2to2p1d2pea4rpech1pe2en2peicpe1im2pekupel3dpena41pennpe1rapere21perl3pero5perspe3sape2stp2fabp2fadp2fafpf1aip2feipf3lopf3lup2forpf1ra2pfs2pf3slpf3sz2pf3tpgra2p3hopph3t2phu4s2p1hüpi2a3pias4p4id2pi2el3pierpi3lepin2epi3oipi2pepi3ri4pisopi1thpit2s2pitz2p1k2pkur11p2l43p4lap5la_p5lad2ple_ple1cp4legp4lem2pligp4likp4liz2p3lu2p1m2po3b42p3ohpo3id3poin3p4olpo3li2pondpo1pepo2plpo3pt2pornpor3spos2epo3ta3potepö2blp2p1hpp1läp2plep2pripp3sa1prak1prax1präd1präg3präm3präs2pre_2prec1pred1preipri4e2prig1p4ro3prob2proc3prod3prog3proj3prot1prüf2prünps4anp3s2hps1idps2pop3staps2tup3stü3p2syps2zept2abpt3atpte4lp4tospto2wp2t3rpt3s2pt1um3p2typu2dr2p1uh2pundpun2s2puntput2spwa4r1queura2abr3aalra3ar2rabd2rabf2rabgra2br2rabs2rabt1rabyra1cer2ackr4ad_3radf3radlrad5tra2gn4raht2raic1rake3rakür4al_ral3bra3le2ralgr4aliralk2r4alsra2lu3ralyr2ammr2an_4ranc2ranf2ranl2ranr2rapfr2ara2rarbr2arkr2arpr4as_ras2ar4at_r3atlrat4r4rau_4raud2rauf2raug3raum3r2äd3rän_3räni3räns2r1ärr2är_rä3raräu2s4räutr2bakr3blärb2lörb4rirb3serbs1orb3sprby4tr1chirch3lrch3mrch3rrch1wr2ck1r2dafrd2amr4dapr2deir3denrd1itr2dobr3donrd1osrd4rird3tard3thrdwa4re2amre3asreb1rre2bür2ech3red_4reddre1elre1er3refe4reff3refl3refo5reg_rehl4r2ei_r2eie2reigr1einre3larel2ere3lorelu2r4em_r2emi4remur4en_r2enare2näre2nir2enzre3or3repe3repo4reppr1erfr1ergr1erkr1erlrer2nr2eror1erör1ertre2sa3rese3reso2ress3rest3resu2reulre2wi4rezirf2äurf2esrf4lör3flür3forrf4rurf4rürf2sarf2targ2abrg2anr2gnorg3spr2ha_r3herr2hoe2rholrhu2sri3amria1sri3atri1ceri1elri1euri2frrif3s5rig_5rigjrig1l4rigrrik1lr2imb2rimprim2s2rink3rinn2rint4r1irris2ari3so3rissri2strit4r5riturk2amr2kährk4lork2lur3krirk2sprk1strk2tark1uhrk2umrku2nr3l2arle2ar3lecrle2ir3letr3l2irli2sr3l2orm2ärrm3d2r3me_r2meorm2esrmo1srm3sarmt2arna2brna4nr2naurn3drr4nefrn2eirne2nr5nesrn2etr4nexr3nodr1nötrn1ur2robj2robsro3e4roh1lro1irro3lerol3s2roly4rom_4romm4romt3ronnrons2ro1pero3phr2oraro3shro2ßu3routrö2du1r2öh1r2öl3römir2ös_r2öse2r1p2r3p4ar2plirpro1rps3trr2abrr2arrr1ämr3r2er4rewrr2herrik2rro3mrr2strr2thr3r2ürrü1brs3abrs2anrs3arr3shors2klr4skor4skrr4skurs4nor4sobrs2p4rs3s2rs2thrs2tir3stor3störs2tur3swirtal2rt1amrt1ärrten1r2thirto1prt1orr5trirt2sorube2ru2drru2fa3ruinru1is4rumfru2mi4ruml4rumz2rund4runn2runwru3pr4r3urru2ra5ruroru2siru2strut3hru2zwrü1ch4rümmrz2anr2zarr2zasrz1idrz1oprz3terz2thr3zwä2s1absa2besa2blsa2br4sabss1adm3safasa2fe3safi3sagasag4nsa2gr3s2aisail22s1aksa2ka3saki3sakr4sakt3salo5samms1amps2an_s3anbs2and3sani2s1apsa2po3sapr2s1ar3saris3arrs1aspsat2a4satmsa2trsa3tss1a4u3sau_3sauc3saue3saum3saur2s3avsa2vos3ähns1ält2s1äm2s1är3s2ät3säul2säuß4s3b4sba4n2scams2cans2cap2scar2s1ce4sch_s4chä4schb4schc2schd2schf2schg2schh2schks4chls4chö2schp2schq4schss4chu3schü2schv2schz4s3d2sde1sseb4rse1ecse2glseg4rse3heseh1lseh1sseh3ts1ein3s2eks2el_s2elsse2nä3senkse2noseo2rs4er_3seraser3gs1erh3seriseru25ses_se3su2s1exse2xe4sexpsex3t4s3f4sflo44s3g2sha2k1shass3h2e3shi_3shidshi4rs3hoc4shof3shop3showsi2ad2siat5si1cs2ido3s4iesien3sie2ssi1f43s4igsig4nsi2kisik1lsi2krsik3ssi2ku3silosin1ision43s2issi2sasis3s3s2itsit3rsi3tusiv1asive3si2vr2s1k24skams3kar4skasskel1s4keps2kifs2kig4skirski1s3skiz4skom4skor4skow4sk3t2s1l23slal4slans2laws3lo_s3loe2s3m22s3n4snab4so3baso3et3softso3la3s2onsone22sopf3sor_s1orc3sorsso4rus4os_2s1ox2s1ök2spaa4spak4spap3spaß4spaus2paz3späh2spärs3pe_2spel4spet4s3pf2sphas4phäs3phespi2k4spil3spio4spis4spla4splä4sple2spod2spogs2poi2spok4spol4spr_3spru2s3ps2s4pt2spun2spup3spur4sput4s3r4sret3srü2ds5safs3sagss1ajs3sals3s2äs4sces4scoss1ecssoi4ss2poss3s4sst2ass2thss2tis3stü4sta_3staast2ac2stag3stah2stak2stax3s2tä4stäg2st3c2steas2ted4stee2stem4stens2tep2ster4stes2stetst3ev4stexs4thäs4this2thu2stia2stibs2ticsti2e2stig2stiks2til2stio2stis2stiv2sto_s3tob1stof4ston4stoo1stoß4stou2stow2stoz2stöt1stru1stub4stuc2stue3stuf3stuhstu2n3stüt4st3zsu1ansuba24subi3su1c2s1uhsu1issul2asul2isult23summ3sun_su4nes1unf4sunt3s2upsup3psu2ras1urtsu2s1su3sasu3shsu3sisus3s2sü4bsü2d1sweh24swie4swilsy4n34s3zas2zess2zis4s3zu4s3zw2ß1a22ß1b22ß1ec2ß1eißen3gße2niße2noße2roßer3t2ß3g2ßig4s2ß1in2ß1k4ßler32ß1n22ß1p22ß3r22ß1s22ß1um5taan4tab_2tabf2tabg2tabh2tabkta2br4tabsta2bü2tabw2tabz2t1ac3tacut1adatadi33taf_4tafft1afg3t2agt3agotai2ltai4r2takzta2latal3d3talo2talt3tameta2mit1amt3tan_2tanbta3ne4tanf2tang3tanit2ank4tanlt2anot1ansta2nuta3or2tapfta2pl2tarb4tark2taro2tartta2ruta3sata2tht3atlt4atmt1auk3taum4tägyt1ämt3tänzt2är_tä2ru4tätt2täuß4t3b2t3chat3chetch2itch3lt2chutch1w4t3d4tdun2te2a22teakte3alte3an3tebat2ech2teckte1emte2es2teff3teha3tehä3tei_teik43teiltekt25tel_3telatelb43telg3telk5teln3telp5tels3tem_tem3st6en_ten3ate2nät4enbten3gt4enhte2nit4enjt4enmten3n3terct4erit4erot3erötert2teru2t2estte2su3tet2t2et_4teth4tetl3teuf3teumte1unte2vite1xa4texp3text4t1f4tfi2l4t1g2tger22th4at2hagt3hait2hak2t3hä3thea2thebt2hect2hekt2hem1then3theot2hest2heut2hik4th3l4th3m2th3n1t2hot3hoft3horthou24t3hö2thub4thunti2ad3tib4ti1cetieg42tiehti1elti1etti1eu3tif_ti1fr4tift3tilgti2lötil3stilt4ti2lut2imiti3nat1inbt1infti1nuti3orti3plti1rhti2sptium2tive3ti2za4t3k45tlem6t5li4t3m24t5n4tnes2to4asto5at4tobjtob2ltode2toi4rto3la3tole4tolz2tomg3topo2topt3tor_to1ra4torct1ord3toret1orgto2rö3torsto2rut2orwto3sc3toseto4sktos2p4toss3totrtots23t4outo3un3töch4t1ökt1öst4t3p21t2r45tra_3trac3trag3trak3tral4traß5träc3träg4träs4träß4treb4trec3tref4treg2trekt4remt4rert4rett4reut3rev2trez2t3rh4trict4riptri2x3tro_3troe3tront4rop3troyt3röc2tröh3trös3trua4truktrum2t4rübt4rügts1adts1alt2sants1ast2sauts1emts3krtso2rt3sout2spät2spht2spots3s4t1st4ts2tut2s1u1tsubtt1abtt2actt1aktt2altta1st3telttes1tto1st3trott3rutt3rütts1ptt2untu3antuf2etuff3tu2istul2at2um_3tun_3tune3tungt1up_tu2rätur1c3turntu2rotu4rutu2satu2sotu3ta3tüch3tür_tür1c3türe3türg4tütztwi4ety2pat2za2tz1agtz1altz1artz1aut3ze_t2zortz2thtz1wätz1witz1wuu1a2bu1a2cuad4ru1al_u1albu1alfu1alru1alsu1altua2luu1ansu3ar_u1arsua3saua2thuat2iubau1u3b4iu2bopub3räu2bübuch1auch1äu1cheu1chiuch3luch3much3nu1chuuch3üuch1wu2ckiu3d2au2donud3rau3druue2ckue2enu2elaue2leueli4ue2miue2näue2niue2nou2ereu3errue2tau3fahuf1akuf3aru3fasuf1au2ufe_uff4luffs4u2fobufo2ruf3säuf4sou2fumug1afug1akuga4sug1auug3d2ug3huu2g1lug3lou4gluu2g3nug1orug3roug3seug3siuh1lauh1läuh2liuhme4uhr1auh3riuhrt4uh2ruuh4rüui2chui1emu4igeu1in_u1is_u3käuu1k2lu1k4ruk2tauku2sul1abul1amula2sul1ämul2drule4nule2tu2lexul3f4uli2kul3kaul2knull2aull3sulo2iul1orul2sauls3z2ultaul3thult3sul2vrulz2wuma4rum2enum1irumm2aum2suum3t2um2un2una_1unabun3acun4alun3at1unda1undd1undf2undg1undn1undv1undzune2bune2hung5hun2idunik4un2imuni2r2unisunks23unkuunna2uno4run2os2uns_un3se1unsiun3skun3spun3taun3trunt3s2untuu1o2bu3or_u3orsu1os_uote2u1pe2uper1up2faup2plup2prupt1oup4tru2rabu2rar2u1räur1änurch1ur3diure4nurf3turi2cur1imurk2s4u1rou3roluro1sur4swur2zaur2zäur2ziur2zou4safu3sepus3klu4skous3ocu3sohus1ouus1peu2spou2spuus2thus3tru1stuus2uru2tärut1egute2lut2esut2etu4tevutfi4ut2heu2thiu2thuuto3cut4orutos4ut3rüut3teutts2ut2zo2u1u2uufe22u1v4u2ve_uz1weuz3z4übe3cüber3ü1cheüch3lüd3a4üd1o4üd3s2üdsa1üd3t4ü2f1aüfer2üf2flü2f1iüf2toü2g3lüg4stühla2ühl2eüh3moüh3neühn2süh1roühs2püh4thül2laül2loül2löü2n1aün2daün2dründ3sünen3ün2faün2frünn2sün3scün3seün3spün2zaüp2plür2flür2frür3scür3seür3spürt2hüse3hüse3lüse1süss2eüs2stü2t3rüt2s1üt2tr2v1abval2s2vang2varb2v1auve3arveit4ve3lave3leve3live3love3maven2cve3neve3nive3növer3averd2vere2verf4verg4ve3river3kvert2ver3uve3tavete1ve3trve3x22v1f4vi3arvi2elvi2ervima2vi4navin2svi3savise4vi2spvis2u2v1l22v1obvo3gavo2gu2v1opvo2r1vor3avor3dvor3evor3gvo3ri2v3rav4ree2v3rov1stav3s2zvu2et2vumfwa5gewa3gowai2b2walb2walmwa3nawa3sawa3sewa3sh2wängwäs2c2w1b2we2bawe2blweb3swe2e4weed3we2fl2weiewe3niwerd2we2röwer2s1wesewe4stwet2s2w1eywie3lwin2e2wing1wi4rwi2sp1wisswi3th1wo1c1wolfwor3aw3s2kwun2s4wur_wur2s2xa2b1x2adxa1fl1x2agx3a2mx2anz1x2asx1e4gx2er_x2erexers22x3euxich2xide2xie3lxil2axi2loxi2lux2is1xis2cxi2sexis3sxi2su2x1k22x3s2x2t1axt2asx2tänxtfi4xt3s2x3turx1u2n2y1aby1al_y1a2myan2gy1anky2chiych3nyen4ny2erey2es_yes2pye2thygie5yke3nyk3s2y4le_yli4nyl3s2y2l1uyma4tym3p4ympi1y2n1oyno4dyon4iy1ontyp3any4p3sy3r2eyri2ayri1ey3r4oys2any3s2cy3s2hy4s3lysme3ys2poys1prys3t4y3s2zy2te_y2tesy3to1yure3zab3lz1a2dza3de2z1afza3grzale32z1amza2na3zani2zarb2zarcz1arm3zaubz3aug3zaun2z1äc3z2äh2z1ämz1ärgz1ärm4z3b4zbü1b2z3d2zdan2zeik4zelu25zen_zen3nze2no3zentz2er_zerk2z2ernzers2ze2säze3sczes1ezes1ize2spze2tr2z1ex2z1f42z1g2z2henzhir3zi3arzid3rzil2ezin2ezi2o3zi3opzirk22z3k42z1l22z1m2zme2e2z3n42z1ob2z1ofzo2gl2z1oh2zopezo2ri2z3ot2zö2f2z3p42z3r24z1s2zt3hozt3s2zu4chzudi4zu2elzu3f4zu3gl2zumf2zumg2zumlzun2ezung42zuntz1urkzu3s4zu5t2zür1cz1wac4zwahz1war2zwas4zwäl2zweg2zwet4zwirz2wit2z1woz1wörz1wur2z1wüz3z4az3z2o",
        6: "_ab3ol_ab1or_akt2a_al3br_alt3s_ampe4_an3d2_angs4_ans2p_ans2t_an3th_ari1e_ark2a_ar2sc_as4ta_au2f3_au4s3_be3ra_boge2_da2r1_darm1_de2al_de1o2_des2e_de3sk_des2t_do2mo_do1pe_dorf1_ehe1i_ei3e2_ei4na_ei2sp_ei4st_ei4tr_el2bi_elb3s_em3m2_end3s_enns3_en2t3_en4tr_er2da_ere3c_es3ta_est2h_es3to_es5tr_eu3g4_eve4r_flug1_for2t_fu2sc_ge3ne_guss1_he3fe_he3ri_inn2e_kamp2_kle2i_kni4e_kopf1_le4ar_li4tu_ma3la_ma2st_mel2a_mi4t1_näs1c_no4th_oper4_oste2_ost3r_poka2_ram3s_reli1_ri2as_rom2a_rö2s1_se3ck_sen3s_ser2u_se2t1_si4te_ski1e_tal2e_ta2to_te3no_te4st_ti5ta_tite4_to4pl_tro2s_tu3ri_uf2e2_ufer1_un3a2_uni4t_uns4t_uro2p_ur3s2_wah4l4a1a2naa2r1aaar3f4aat4s3ab1aufab1eilabe2laab1erkab1erzab1ins1a2blaab5lag1a2bläab4le_3a2blö1a2bon2absarab3s2i2abst_ab3ste1abteia1chalach3auach1eia3cho_ach1orach3su4ach1wa1ckarack2ena2ckinack2seack3slacon4na3d2abad3amaa2d1an3a4dapade2aladefi4a2deina2deri4ade1sades4sadi3enad4resa2f1eca2fentaf1erlaf4fluaf3s2aaf3s2haf2t1aaf2teiaf2t3raf2tura2f3urag1a2da3gen_age4naage2saage4si3a2gitag4ne_a2g3rea2g3riag4samag4setag4spoag3staag3stea2gundahl3a2ahl3szah4n1aah3r2eahrta2ain3spai3s2e2a3kam1a2kazaken2nak3rauak5tan2aktikak2t3r2aktstal1ageal3amealami5al3ampal1anaal1ansal1anza3lar_a3lareal2armal3arral1asial1assal3augal2b1lalb3lial2bohalb3rualds2ta4l1eha2l1eia2l1ela2lengal1epoal1erl3alermal1etaal1etha2l1eua4leur3a2lexal2glial1insa2linvalk1ar1alkohalk3s2alks4tal2labal2laual3les1allgäal2lobalo2gaal1opeal1orc3alpe_al3sklal3sunal4takal3tamal2treal2trial2troalt2seal1umbame2n1amer2aa2meriame3rua4mesh2a3mirami3taami3ti2ammalam2meiam2minam3stram2t1aam2t1äam4tel2amtemam2t3ram4treanadi3an1algan3dacande2san2dexand2suand1uran3e2can2ei_an3eifan1e4kan1ethanft5san3f2uang1ar3angeb2angiean2gla4angs_an2i3d3a4nima4ninsan2keian4klöank3ra3an3naann2aban3n2ea2n1orans2enan2seuan3skrans1pa1anspran3s2z1antei1anthran2tro2anwet1anzeian2zwiar3abtara3d2a2r3al2a2rara2r1auar2bauar2bec2arbenar2bre2arbs2ar2droar1effar1ehra2reinar2erfa2reria2rerlar1intar2kalar2knear2korar4kriark1s4ark3saark3shar2lesar2nana2r1oparr3hear3s2har3staar3t2ear2thear3t2iartin2art3rear2z1was1alaa3schea3schia2schma3schua3s2hiasin2gaska3sa3skopas3s2aas3s2eas3s2ias2s1pass3tias3stras3stu2as3taas4tauas4tofast3räaswa2s3a2sylat1apfa2tausat3eiga2teliate2ru4athe1atil4sati2st4atmusatra4tat3romat4setat2s1pat4takat4tauat2teiatz1eratz3t2at2z1w2au1a2au2bliau2bloauf1an2aufe_2aufehauf1er2aufs_2auft_4augehaule2sau2malau2m1oaum3p2aum3s6au3n4aau2nio2au3r2au2sauau2spraus3s22auts4ava3t4äche1eäch2späch4stä2d1iaäft4s3äg3str2äh3t4äl2l1aämi3enäne2n1äng3seän2k3län2s1cänse3häp2s1cä2r3a2ä2r1eiär1intär2k3lärt2s3äse3g2äser2iäskop2ä3s2kräs6s1cä4s3t2äß1erkä4t1a2ät2e1iätein2ät2s1iät2s1pät2s3täum4s52ä3us_backs4b1a2drbah2nuba2k1iba2krabal3th3b2andban2drba3n2eban4klban2kr2b1ansbar3deba2reibar2enbar3zwba3s2abau3sp3b2ä1cbbens2bb3lerbbru2cbe2delbe2erkbe1erlbe1etabei1f4bei3k4bei3labe1indbei3scbeis2ebei1stbeit2sbe3lasbe3lecbe3leibe2letbel3label3szbel3t4ben3arbe3nei3ben3gbe3n2iben2sebenst4ben2su2bentbb2entib1ents2bentwben3unben3z2ber3ambe2ranbere4sber3nab1erntbe2robbe3ropbe3rumbe3slobes2pobess4ebes3szbe2tapbe3thabien3sbi2ke_bi2kes2b1inb2b1infbin3gl2b1intbi2solbi2s5tb2it2abla3b4b2lancb2latt2b3law3ble2a2b3legb3lein3ble4nb3leseble3sz2blich3blickbling43blitzbo3ch2bo2e3ibon2debo1r2abo2reibo4rigbo4s3pbot2st2b3radb4ra3k2b3refb3reif2b3repbri2er2b3rolbrust3bru2thb2s1adb3sandb3sel_bse2n1b3s2esb2s1ofb3s2pubst3acbst1akbs3tätbst3erb2stipb4stodbs4trib4stübb2s1unbu2chibul2la2b3umkbu3r4ibus1erbu2sinbu2s1pbu2s1ubzeit1carri1ca3t4hcha2ck2ch1akch2anb3chancch1ang4chanz4char_1characha2sc3chato4chatuch1ärm3chef_3chefi3chefsch1eimcher3ach1ess2cheta1ch1iachi3na4chind2chinf2chinhch1insch1int1chiruch1offch1orcchre3s1chron2chunt2ck3an4ckeffck1ehe4ck1eick1entcke2rack2ereck1erhck2ern2ckero2ck1id2ckunt2ck1upcon2nec1s4trcussi43d2abäda2ben3d2ablda2bredab4rüdach3ada2chodach1sdal3b2d1amma2d1amt2d1ana2dangedan4kldan2kr2d1ans2dantwd2anz_4danzida2r3a2darb2dar2mada3s2hdat4e2da3teidate4n4d3atl4daush2d1ämt2d1änd2d1ängde3a2tde4ca_de2cka2d1eff2d1ehrdein2ddein2sdel1ändel1ec2delek2delem2delfmdelle2de2lopde3lordel5scdel2sodel3t4dem2ar2d1empden3th2dentwdera2bde1radde2rapder2bl2derdbderer33derieder3m2de4ruhde4rumde3sacdesa2gde4samdes2äcde2sebde4sehde2seide4setde2sinde2sordes3s2de2sto2d1etwde1urlde2xisdha1s4di3e2ddi3enidie2thdige4sdil2s52d1imb2d1ind2d1inf2d1inh2d1ins2d1intdion3sdi4re_di2rendi2ris2d1irl2d1isrdi4t3rdle2ra2d1o2fdo2mardo5n4adoni1e2d1opfdor2fädor2fldor2fr2d1orgdo2riedor2tadö2s1c3d4ra_2d3rad2drahm3d4ramd3rand2d3rät2d3räud4rea_d4reas3d4rehd4reiv4d3ren2d3rep4d3rer4dres_d4resc3d4ria2d5ricd5riegd4rin_3d4rit4dritu2d3rod2d3rot2d3rovdrö2s13d4ruc2d3ruh2d5rutd2sau2d2s1efds2eigd2serhds1errd3s2had2s1imds2infd3skuld2s1opds1orids1pasd2sprods3tabd4stagd4stead3steid4stemds4tilds4tipds1umsds2zend4theidtran2du1alvdu2bli2d1ufe2d1umb2d3umkd2ums_2d1umvdund2a2d1unfdun3kedun2kl2d1url2dursadwest3ea3dereadli4e3aleiealti2eat4e2eater1eat3s2e3au2feau1ste3b2akebert4eb3lereb4leue3blieeb3reiebs3paeb3staeb3strebu2t12e3cheech1eie2cho_e2ch3rech3taech1uheck3seede2aledens1edi4aled2s1oed2s1pee2choeed3s2ee2lekee3lenee4nage1e2pie1erbtee3r2eeere2see4reteer2öse1ertree3r2uee4tateewa4re2f1adef1anae2fente3f4lu2e3f2oef3reaef3rolef3romef2tanege2raeg4saleg4stoegung4eh1ache3h2aleh2auseh1eff1e2hepehe1raeh1inteh1lameh2linehl2seehr1a2eh2reiehre3seh1ro2ehr1obehr1ofeh1stee2hunt2ei3a2ei2bareibu4tei2choei2d1aei3danei3dra4eien33eifrüeig2er2eigew2eigrueik2arei3kauei2lareilen1eil3f41eilzuei2moreim2plei2n1aei4nasein3dr2einduei4nelei2neu2einfoein3g2e1initein4szei2sa4eis2peeis4thei1stoei2sumei2tabei2tanei2tarei2troeit3umek1s4tek5triel3abiel2abte2l1akel4amiel4ampel1ansel1anze2l1apel3ariel1asiel1aspel2ast3elbiseld3s22e3lebe2l1el1e2leme3lem_el1empel1erdel1erfel1erkel1erl2eles2el1esse2l1ideli2neel1itael3lanel5le_el3linell3spel1opee2l1orelo2riel2sumelte2kel2t3re2l1umel3useel2zwae2m1ad3emanze3m2ene2m1imemi5naem1intemi3tiemma3uem2meiem3pflem2spren4amee4nanden3angen3areen2ascen3atte3nauee2n1ären4ce_en2dalend3siend3szend2umen1e2ce2neffe4neine2n1elene4lee2nerfe4nerhe4nerk4enerne4nerz1engad3engagen3g2ien3gloeng3see2n1inen3k2üeno2mae2n1openost3en1ö2den3sacen2sauen2sebens2el1ensemensen1en3skaens2po2enstoent4agen2teb1entfa3entgaen2thi3entlaenü1ste1o2b1e3p2f41episo1e2pocep2tale3rad_er3admeraf4aera1frer3aicer3alleran3de3raneer3anfe2ranher3anmer3apfe3rarie2rathe3ratie2ratme1rauber3aueerau2fer3augerb4sper3chl2erdece3recher1effer1eige2reiner1ele2e3reme3renae3renz4erer_e4rerl4ererne3reroer1errer1erse2rerter1erwer1esser1eul4erfür1ergolergs4t1erhabe2riat4e3ric4e3rieer1inber1inker1inter1ita1erklä2erkreern1oser1o2ber3onye4ro2rer3smoert2aker2thoerts2eeruf4ser1u4mer1underung4er1unses2aches3anze3s2ases3cape3schaes3evaes2haresi1eres3intes2kates4loges2ortes2sau4essemessi2aes2sofes2spues3stres3stuest1ake1stare1state3stele1stile2stipes4trie2s1umes3umse4teinet3haleti2tae4t1ofetons4e2treset4riget2tabet2teiet2t3ret4troett3szetwa4retze4seu2esceu4glae3um2seum4sceums1peum3steu4neie3un2geu2nioeun3ka3eu3roeu1staeu1stoeu1stre2velae2vent1e2xeme2x1inex2tinfa2benfa2chof1aderfa3l2afal2klfal3tefalt2sfan2gr2f1ankf1an3zfar2br2f3arcfarr3s3f4art2f3arzfa3s4afa2to32f1auff1ausb2f1ärmfä2ßerfeatu42f1eckfe1inifek2tafe2l1afel2drfe2lesfe2l1ofen3safer2anfe2rauferde3fer2erf1erfaf2erl_f4erpaf2ers_fest1afest3r2f1etafe4tagfeu4ruf2f3efffe1inf3f4räff3shoffs4trfi2kinfik1o2fi2kobfi2lesfi4linfil2ipfin3sp2f1intfi2s5tfit1o2fi2tor3f4läc2f5läd2f3läu2f3leb3f6limfli4ne2f5lon1f4lop1f4lot1f4lug4f3orgfo3rinfor4stfor2thfor3tu2f1o2xf3rand1f4ränfreik2frein42f3ricf4risc1f4ronfro2nafs1allfs4ammf2s1asf2sauff2sausf2sautfs1e2bf2s1emf2s1erf2si2df2s1o2f3spanfs1penf3s2plf2sprefs2prif2sprofs2pruf2stasf3steif2stipf3st4rf2s1unf2t1alft1e2hft1eigft1eisf4theif2t3rof2t3röf3t4ruft4samft3s2cft4sehfts3elfts2tift1url2f1unffun2klfun2ko2f1unmfu4re_fus2safus2stfzu4gaga2b5l2ga2dr2g1amtgan2gagan2grg3anla3g2ano2g1armga3r2og1arti2g1arzgas3eiga2sorga4spega4sprgas4taga4ste2g1auf2g1autg2d1aug2d1erge3g2l2g1eifge2in_gein2sge2intgein2vgei3shgelb1rge5lehgell2age3lorgels2tgel3szge3lumge4namge4nargen1ebge3necgen3szgen3th2gentwge2rabger2erger3noge1r2öge3r2ug1erwag2e1s23ge3scges4pige3steges3thge3t2a2getapge3t4ugge2ne3g2het3g2hiegi3alogi2e1igie1stgi2me_gi4mesgi2met2g1indgin2ga2g1insgi3t2ag2lade2g1lag3glanz2gläuf2g3leb4g5lerg3lese3g2lid3g2lie3g2lit3g2loa3g2lobg3loch3g4lok3g2lop3g2lotgne2tr4g3notgoa3li2gonis2g1ope2g1opfg2o1ragra2bigra2bl2gradl2g3rah2g3rak2g3räu2g5re_2g3recg4re2eg3reit2g3ric2g3röh2g3rui2g3rum3g4rup2g3rüc3g4rüng3s2ahg4saltgs3amags3augg4s3cegs4chig4s3crg3sel_gs3elig3selngs5erkg4setags4pieg4spingsrat4g3stang3starg4s3täg5stämg3stelg1steugst2heg3stirgs3tocg4stolgs3topgst4rig4sturgs4tücgu1an_gu1antgu4d3r2g1u2fgu1ins2g1unfg2ung_gunge2g2un4s2gunt22g1urlgurt3sgu2s3agus2spgus2stha2choha2delha4dinh1adle2h2al_ha2lauhal2bahalb3rhal2lahal2sthand3shan2krh4a3rah1arm_h2armehar2thh1arti2ha3sahat5t2h1aukthau2sahau2sc2hautohau2trhä3usphe1choh1echthe3ckehe2e3lhe2fanhe2f3lhe3friheim3phei4muheine2h1einkhe1ismhe1isthel1eche3lenhe4lof4h1emphend2she2nethenst2hen5trh1entshe2ral2heraphe3rasherb4she2relh1erfüh1erkeher3thher2zwhe1stahe2tapheter2he3t4she1x4ahfell1hi2angh1i4dihi3enshier1ihiers2hil2frh1induhin2enhi3n2ihin3n2hin3s22hi3rehl1anzh1lauth5len_hlen3ghl2ennhle2rahl1erghl1erwh4lerzh4lesihl1indh3listhlo2reh3losihl2sanhl2serhl3skuhl3slohme1inhmen2shme2rahn3eighn3einhne4n1hne4pfh3nerlh3nerzhn3s2khn1unfho2ch3ho2ckahock3tho2f3rhol1au4holdyhol3g4ho4lor3hol3sh1o2lyho2mecho2medho4seihotli42ho2w1h1raneh3rechh4rei_h3reich3r2enhr2erghr2erkhr2ermhr2erzh4rickh4rineh4rinhh4risth4romeh4romihr2sauhr2serhr4sethr2tabhr2tanhr2torhrt3rihr2trohrt2sahrt2sehr1umsh2s1ech3s2exh2s1ofhs2porh2spräh2sprohst2anh1stechst2heh1s2tih2storh1s4trhst3rih1stunhs2ungh3t2alht3aneh3tankh4tasyht3a2tht1e2ch2t1efhte2heh2teifh2temph2t1euh2t1exh4theihthe3uh2t1inh2tolyh2torgh4trefh2t3ruh2t3rühts2tihu2b1ahu2b3lhu4b3rhu2h1ahu2h1ihuk3t4hu2l3ahu2lerhu2lethu3m2ahung4shu3ni1hus4sahus2sphu2tabhu3t2hhühne4h2wallh1weibhy2pe_i4a3g2ia2l1ai3aleiial3laia2lorial3t4ial3z2ia2nali3and2ia3p2fi2a3spi3a4tai3at4hib2blii2beigi2beisibela2iben3aib3renib4stei2bunki2buntibu2s1ich1eii2chini3chloi2ch3ri3ck2eid2ab4i2d1au1i2deeidel2äide3soide3sp1i2dio1idol_i3d2scid2s1pie2breie2choie2fauief3f4ie2f3lie2froie4g5lie3g4nie2g3riegs3cie3lasiel3auiel1ecielo4biel3sziel3taiena2bi3e2näien1ebie3neri3en3gi3e2noien3scien3siiens2kien3szier3a2ie2rapie3resi3ereuierin3ier3k2i3ern_iers2tier3teies2spie1staie2t1aie4t1oie2triiet2seiet3zwifens2if1ergif1erhi1f4lai1frauif4reii1f4rüif2topift3szig2absig1artiga1s4ige4naig1erzi2g1imig3reiig4salig3sprig4stoig4stöig3strig3stüigung4i2h1ami2h1umi4i3a4ik1amtik1anzik1artik3atti2k1aui2k1eiike2l1ik1erfi2kindi3k4läi2k3raik2trei2l3abi2l1acil1a2di2l1akil1ansil1aspi2l1auil3ausild2eril2doril1e2cil1eheil1einil2f3lilf4s3ilie4ni2l1ipi3lip_i3lipsil3l2ail3l2iil2makil2mauil2mini2l1oril3t2hilung4i2manwima2tri2melei2melfi4meshi2metiim2meiim1orgim3pseim3staimt3s2in3a2ci4nacki2n1adin2arain2arsin4arti2n3auin2dalin2dan1indexind4riin3drü1indusin1ehein2erhi4neskine3un1info_1infosing1af1inhab2inhar2inhauin2i3dini3krini3sei3nitzin2nor1inntain3olsino1s4in1ö2dins2aminsch2in2seb2insenin3skr1insta1insufin3s2z1integin3t4rin5trii3n2umin3unzinvil4io2i3dio2naui3ons3ion4stiore4nipi3elipi3en1i2rakir2k3lirli4nir2makir2mauir2mumir2narirpla4irt2stiru2s1isage2is3arei2s1äni2schmi2s3crise3haise3hiise2n1is2endisen3si2serhiser2uis2hasi2s1idi2s1of3i2soti2sparis1picis2pitis2pori2sprois4sauis3stais3stoiss3tris3stuis2sumis4tabis4tamist2anis4teliste4nistes3is4tocis5törist4raist3reisum3piß1ersit1ab_ital1ait1altit2an_it1arti3tauci4t1axi2t1äsi2t1eii4teigit2eili4teinite2lai4tepoi2t1idit2innitmen2i2t1ofit3rafit3rasit3rauit3räuit3ricit3romit4ronit3runit2stoit2tebit4triitt2spi2t1umi2tunsit1urgitzes4it2z1wi2v1akiv1angi2v1eiiv1elti2v1urizei3ci2z1irjahr4sja3l2ajean2sjek2trje4s3tje2t1aje2t3hje2t3rjet3s2jugen2jut2e1kab2blka2ben2kabla2kabläka3b4r2k1abt2k3adaka1f4lkaf3t2kaken42kala_ka2lanka3leikal2kakal2krkal4trkan2alka2nau2kanda2k1angk2ans_k2anz_2k1apfka3r2i2k1armk2arp3kar2pfk2artaka2s3tka3tanka3t4hka4t3r4kaufrkau3t22kautok1ä2mikä2s1ckdamp22k1e1cke2he_kehr2s2k1eic2k1eig2keinhkel1acke3lagkel3b4ke2lenke2lerkell4e2k1empken3au2kenläkens2kken3szk2enteken3thk2entrk2entu2kentwke1radk2erkok1e2rok2ers_ke2selke4t1ake2t3h2k1e2xki1f4lki1f4r2k1intkis4to4k1lack4leidk3lem_2k3lerkle2ra2k3leukle3usk2lisc2klistklit2s2k3locklo2i3klost4klung42k1lüc2k5nerkno4bl2k5norkoh3lukol2k5ko3n2ekon3s4ko1r2a2k1orckot3s22k3radk3rats2kraum2k3rät2k3rec2kred_2k3refk3reick3reih2k3rick3ries3k4ronks1e2bk2s1emk2sentks1erlk2s1idk2s1ink2s1o2ks2pork1s2tik2stork2sträk2stumks2zenk2t1adkt1aktkta4rek2t1auk2tempk2tentkte3ruk2t1idkt1insk2t1ofkt1opekt4rankt3rask4trefktro1skt3runk2tuns2k1uhrku3l2eku3l2i2k3umlkum2s1kun4s4kunst32k1up_kur2blku2reikuri2ekur2spkur2stlab4ralab4ri2l3absla2ce_la2gio2la1hola2kesla2k1ila1k4lla3min1lammf2l1amtlamt4sla4munl1analla2nau3l2andlan2gl2lanhäl2anhe4lanli2l3ann4lansä2lantrlan2zwlap4pll3artila2saulast1ola4tel2l3athl2auf_lau2fol2aufz2lausl2lausr2lauto2l1ähnlä2s1cl4betal2b1idlb2latl4bre_lb3ritlbst3elb4stol2b3uflbzei2l3d2acl2d1akld1amml2da2rld3arild1arml2delel3der_ld1erpl2d1idl2d1iml2dranl3d4rul2d1umle2chile2gau3l2ei_lei2br4l1eigl2ein_l2eindl2eine2leinkl2eintl4eistlei2talekt2a2lektr3l2ela3lemesle4nad2lendul2e2nolen3szl1ents4lentzlen2zil2e1rale2ragle2raul1erfol2erfrl2erfül2erkal2erkol2erlel4ers_lers2klers2tl2ert_l2ertel2erzales2amle3serleste3le1stole2tat2le3thlet4tule3u2f2leurole2xislfang3l2f1ecl4feisl3f4läl3f4lulf3ramlgen2alge3ral2getilian2gli3chili2ckali3d2ali2deo2l1idolid3scli3enelien3slie2stli2grelik2spli3m2ali3n2alin3alli2nefli2nehli2nepli2nes2l1inflings52l1inh2l1injlink2sli2noll2ins_l2insal2insc2linsp2linst2l1intli3os_li2p3ali3s2a2l1islli2tallit1s2lit3szlizei3lk1alpl3k2anl3kar_lken3tl3k4lul2k3rol2k3rulk4ställ1abbl2labtll1affll1aktl3l2alll3amall2anwll1anzll1armll3augl2lausl2l1ämll1echlle3enl2l1efll1eiml3len_llen3gl3ler_lle2ral2lerzll1imbll1impll1insl2lobel2l1ofll1opfl3lor_l3lorel2l1oul2l3öfll3s2kll2sprllti2mllt5s2l2marclm1auslm1indlm1inslm3stelm3s2zln3are3l2ob_lo2berlob4ril1o2felo2gaulo3h2e2l1ohrlo2k3rl1o2lylo2minlo2n1olo3renlo4skelo2speloss2elo4stelo3thalo3thiloti4o2l3öfelpe2n3l2p1holrat4sl3s2all2sannl3sarel2s1ecl2s1emls1erels1ergl2serhls1erlls2logl3s2pil2sprol3s2pulstab6ls4tafl3stecl3steil3stell4stemls2tiel2stitls2zenlt1a2mlt3andlt1angl3tarblt1artl2t1aultbau1lt3elil5ten_lter3alt2erglt4erölte2thl2t1eul4theiltimo4l2t1ofl4t3ötltra3llt3räult4rielt3roclt3rosl2t3röl2t1umltu2ri4lu4b32l1ufelu2g1alu4g3llu2g3rlug3salug3splu1id_2l1una2l1unf2l1unilu2s1ulu2t1alu4teglu2toplu4t3rl2z3acl3z2anlz2erklz1indlz2wecm2ab4rma2d4rma4d2sma2ge_ma2gebma2gefma2gegma2gekma2gepma2getma2gevma2gew2m1aggma3g4n2m1agomai4se2m1aktmal1akma2lanma2lauma3lermali1emal3lo2malltma2nauman3d2ma2net2mansa2mansä2mansc2mantwmar3g2maro3dma3r2uma2tanma2telma5trimat3semat3sp2mausg4m1ändmä3t4rm2d1ummedie4mee2n12m1eif2m1eig3meistme3lamme2laume2lekme2lermelet42melf_mel2semel5t4mena2bme3nalmen3armen3aumen3glme3normen4skmen2somen3ta2mentnmer2er3merinme2sal4meser2me3shmes2stmeste2me1stome3t2amie3drmi2e1imien3smie2romie4timi2karmi3l2amilch1mild4s2m1impmin2enmin2eumin2ga3min2omi2t1rmit3s2mit5sami5tsumi2t1umk5re_m2m1akm2m1almm1angmm1anzm2m1aumme4namme2samm1inbmm1infmm1inhmm1insmm1intmmi3scmm3stamm3strmmüll1m4nesimode3smo2galmo2k1lmon2s3mon3su2m1opemo2rar2m1orcmor2drmo2rermos4tampf3limpf1ormp3strms3andm4s1efms1erwms1inims1orim2spedm2spotm2sprom4stagm3stelm3s2tims5träm3s2tumt3aremt1eltm2t1eum2t1immtmen2m2t3romt2sprmt1urtmu3cke4m3unfmu4s1amu2s1omut1aumut2stmvoll14n3absna2ch1nach3s4na2drna1f4rna2gemna2h1a3n2aldna2letnal3lanalmo2na2lopnal2phn2als_nal3t4n4amenna3m4n2n1amtnamt4sn1and24n1ang2n1ans2nantrnap2sina2r1an2arle4n3artna3r2unasyl2na3t4hnat4sanat4sc3n2aul4nausb4nausgn2auso4nauss4nausw2n1ä2mnär4s53nä1umnbe2inn2d1akn2danlnd1annnde2sendi2a3ndo2ben2d3ren2drobnd3rolnd3rosn2druind2sornd2spr2n1ebnne3ein4n1ehr3neigtnek3t42n1ele5neleb4nelek4nelemne3lennel4la3ne3lu2n1embn1e2mi2n3emp2n1emsnen3a2n1endgnen3einenen14nengb4nengs4nengtnens4enen3skn1entb4nentn5nentrn1ents4nentzne2n3u2n1epone2posne2ranne2rapne2raun1erbine2reb2nerfü3nergrn2erlin1ermän2ern_ne1rösn2ert_n1ertrne2rup2n1erzne3sanne3skane2s1pne1stanes3tine2tadne2tapn1etatne2taunet3han1e2tunet2zi2n1eupnfalt4nf5linnft4s3ng2absn2g1acn2g1akng2anfng1anzn2g1äln3g2enngen2an3gläsn2glicngrab6ng3ratng3rocngs3panich1s3n2id_nie4n3ni3eneni1eronifes3ni2grenig4spni2kalni2karni3ker4n1imp3n2in_n2in4a4n3ind4n1inhni2nor2n1insn2ins_4ninse4n1int2n1invni2s1eni3se_ni2s1pni3spinis3s4ni2s1uni3t4rni3tscnitts1n2k3adn2k1akn3k2aln2kansn2kausn2k1ärnk4ergnk1inhnk3lennk3lesn2klienk3lunn2k3ronks2eink3s2znk2taknk2tannkt1itnk4topnk2trunmen2snna2ben2nadan2n1annnen3gnn2erhnn2erknne2rönner2znnes1enne4stnn1o2rnn3s2pn2n1ufno2blano2leu3n2opano2radno1rakno3ral3n2os_no2s3pn2ostenost1r2nostvno3tabno2telno3t3hno4thano4thi2n1o2x4n1ö4lnräu3snre3sznrö2s1n2sangn2santn2sausn2s1änns1e2dns1entn2s1epns1erfns1ergn2serhns1ersnsfi4lnsho2fn2simpnsi4tensi2trns2kaln2s1opn4spatn3s2pins4piens3ponn4sprän4spronst1akn3starn3statns4tornstü1bn2s1unns2ungns4unrns4unsn4s3zint3absn3t2alnt1angnt2arbnt1arknt2armn2t1äunte3aunt1ebente3g6n2teignt4enent4ernnt4ersnt4ertnt2hern2t3hon3t4hunti3kln2tinfntini1nt2insn3ti1tnt4lemntmen2nto3ment3recn5trepnt4rign5tropn2t3rünt4saunt2sto3n4tu_ntu2ra2n3umb2n1ums2n3umz3nung_n3ungl2n1uninu4t3rn2z1aun2z1ännzdi1snzi2ganzig4snz1inin2zurkn2z1wan2z1wän2z1wuoa3cheoa3chioa4k1lo4a3lao4a3mi3oa3seo3b2al2o3b2äob3ein2o3b2iob3iteo2b3li2o3bloo2b3reob3s2hob2staocha2boche4boch1eioch3ö2och3teochu2fo2ckarock2erock3szodein3ode2n1odene4ode3sp2o3diaof1a2co2f1eiof2f1a1offizof2f5lof2f3r2o1f1rof4samof2speof2sprof2s1uof2teio2g1abog1alaog1ango2g1eiogi2erog1steohen3sohl3auoh3lecohl1eioh3lemoh3lenoh3lepohls2eoh2n1ooho2laoh1o2poh4rinoimmu4oka2laokale43o2kelok2s1po2l1akolars2ol1aufol4damol1eieol1eisol2fraoli3k4ol2kreol2lakol2lelolo3p2ol1ortol2strol2z1aol2zinom2anwom1arto2m1auo2m1eio3men_o2meruom1erzomiet1om1ingom1orgo4munto2narbon3ausone2n3onens2on1erbon1ergon1eröo3netton3g2lon2i3do4nikro4n1imon3ingonlo2con3n2eo2nokeon1orconsa2gon4samon2sebonse2lonst2hon3t2aoo2k3lo2p3adop3aktopa2leo1pe4nop2f3aop3fahopf3laop1flüopi5a4op5lago2p3le1op3t4or3a2bor4altor2ando2ranhor3arbor3attor1ändor2baror2dauor2deuor2ditor2dumore4aso2r1efor1eigo2reino2rerfor1ethor2fleorf3s42orgetor3g2h2orgiaorgi1eor3gle2o3ric4orie_o3rier4orin1or5ne_or3s4aor2täror2tefor2theor2torort3reo4r3un2o3s2ao3scheo2s1eio3s2hi2os2kl2os2koos3peco3s2poos2seios2s3oos4sonos2s3pos2s3tost1auos4teios2t3hos3tilost3räost3reost3ufo3s2zeo2ß1elota2goo5tarko3tarto2t1auot3augotei4not4em3otemp2ot5helo2t3hiot3hosot1opfoto2rao2t3reot3rinot4spaots2peot2sprot2t3rot4triou1f4lou4le_o3undsou3s2ioviso3owe2r11o2xidöbe2laöbe4liöh3l2eöl2k3löl2naröl2ungönizi1öp4s3tö2r3ecö2r1eiör2ergö2rerlör2f3lö2r1imörner2ör3s2kö2schaö2schlö2schwö2s1eiös2s1cöte4n3pa1f4rpa1k4lpak2topala3tpa2narpa3neipa2neu1pa2nopan3slpa5regpa5rek1park_par2klpar2kr1partn1partypar3z2pa3s2ppat4e2pa5t4rpa3unipä3ckepä2t3hpät3s4pekt4spe2letpe2lexpell2apell4epen3dape4nenpe2n1o3pensi1pensupen3z2per2anper4nape2robperwa4pes3s2p2f1akpf1ansp2fa4rpf3arepf3armp2f1au4p3fe_pf1eimpf1einp3fen_p2fentp3fer_pf2erwp3f2esp2f3läpf3leipf3lie2p1heiphen3dphen3sphi2ka2phthepi3as_pi3chlpiela2ping3s3pinsepi3onupi4pel3pirinpi3t2aplan3gpo2laupo4lorpo1o2bpo1ralpo1raupo4stapo4stäpo2stopos6trpo2t1upp3anlppe2n1p2p1f4p3p2hopp5lanp2p3rap2p3repre2e13preis2p3rer3p4res1prinz2prosspro1stp3steap3stelp3s2tipt3albp4t3ecp4t1eip4telept1in1pto3mept1urspul2sppu2s3t2r3aacra2barrab2blr2aber1r4abi2r3abwra2chura2dam2radapraf3arra2ferra3gle3r2ahmrail4l2r3airra2krera2kro2raktira2la2ral3abr3alar3r4aldral3larall2e2rallgr3alp_2ralper3al3trama3srambi2ra2mer1r2ami2r1amtramt4sr4andar4anderand3sr4aner1rangirani1eran2kr2r1anm2r1anpr2ans_r2ansp2rantr2r3anw3rareirar3f42r3arz2rato_rat2st3raub_rau2mi3rausc2rausgrau2spraut5srä2s1c3rätser2b1abrbal3arba3rerb1artrb1aufrb1echr4belärb1entr3b2larbla2dr2ble_rb3lerrb2linrb4seirb3skarb4stärb3strr1che_r1chenrch1s2rch3sprch3tar3d2acr2d1akr2d1alrdani1rd1antrd1anzrd2ei_rden3drde3rerde3sprdi3a2rdia4lrdo2berd3ratre2altre3at_re3atsre2b1are2b1lreb3ra4rechs2reck_2recki2reditre2hacre2h1ire2h1orei4bl4reifrrei3gareim2p4reingr3eink4reinr4re2ke2r1elbre3lei2r1elf2r1elt4rempfrena2bre3nal3rendiren3drren4gl2rengp2rengsr1ense2rentw3r4er_2r1erbr2erbr2r1erdr2erenr2erki2rerlö2r1ermre2robr2erse2rerspr2erte2rertr2r1erzrer5zer2erzy3r4es_ress2ere1stare2thyreu3g2re3uni2r1eurrewa4rrf1ältr2fentrf3licrf3linrf2s1ärf2s3trf3t4rr2g1ahr2g1akrge4anrge2blr2getor2glanr2gleur2g1obr2gregr2gresr2gretrg3rinrgs4tr3r4he_3r4henrho2i3rib2blri1cha2ridolrie2frriene4rien3srie2nuri1er_ri4ereri2f1ari2ferri2f1orim4scr2i3na2r1indri3n4erine1i2r1infrin2foring3lrin2gr2r1inh2rinitr1innu2r1insrin4sorin2sp2r1inv3risikri4s1pri3t2irit2trr3klaur2klisrk5nebr2k5nurk3räurk3rinrk2s1erk3shirk2tinrk2t3rrk3trark4trirk1unirlös3srl2s1prl3ster3m2agrma2larm1ansrm1anzrm1a2pr2maphr2m1efr2mider2m1imrm3starm3umsrn2andrn3anirn2a2rrn3arern3arirn3eifr4nerfr4nerkr4n1inr2n1opr2n1orrn3s2ärn3s2prn3s2zrn3t2ero2bei3rock_r2o3deroh3na3r2ohrro2madro2mer4ro1nyror3alro2ratro2reiro2r1oror3thro3s2iro3smoro3starost1rro4tagrote3iro2thoro4trirots2orot2taro3t2uro3untrö2b3lrpe2rerrer4srre2strr2n3ar2r3obrr3stur4samprs3anprs3antrsch2lr3schur3schwr2seinrse2n1rs2endrse4ners1erers1erörs1ersrs1erzrs1etars2kalrs2kanrs2kiers2kisr4s1opr4sordr2s3phrs2tecr3stier2stinr2stiprs4tobr4stotr3s4trr3s4türtals1rt1angrt1annrt1antrt1anzr2t1arrte1e2rt4eifr2telfr2temort1ersrt3holrt2humr2t1idr2tinfrto2rirt3recrt3rosrtrü2crt2spart2sprru2ckurude2aruf2s32r1uhrru1insru2m3ar2ums_2r1unar2unde2r1unf2runglrun2kr2r1unl2r1unm4r3untru2r1erus4stru3staru4teiru2t3rrü1benrwun3srz1a2cr5zenerz1engr3z2ofrzug2u3sabetsa3blesach3t2s1ada2s3affsa1f4r3s2al_sal2se2s1alt3s2alz4s1amnsam2tos2an2cs4and_3sang_2s3anh2s3anl2s3anssan4sk2s3anw3s4ar_3s2ara4s3arb3s2ard3s2ars4sartisa4ru24s3ath4s3atlsauri1s3ausw2s1änd3sänge2schak2schao3sche_2schefsch2en3sches4schexschi4es4chim3schis2schmö2schn_2schoxschs2e4sch3tscht2ascht4rsch2up3s4cop3sco4rsda3mese3at_s1echtsee3igseein2se1er_se1erö2s1effse2galse4helse2hinseh3rese2hüb2s1ei_2s1eie2s1eig2seinb4seing2seinh4seink2seinl2seinn4seinr2seinw4s1eis3s2eitse2l1ase3ladsela2gse3lamsel1ec4selem2self_s3elixse2l3ösel3szsel3trs4e3ma2s1emp3s2en_se4nagsen3gl3s2enise4nob3s2enss2ent_s2enti2sentw2sentzse2n3use5refser2ers2erfrs3erfüs2ergr2serhöse2robs2ers_2sersas4ert_s2ertase3rum3s4ervse2selse1stase2tatse1u2n3s2ha_4s3hansho4resi2achsi3enesi1errsi3gnusi2g3rsig4stsi2k1äsik3t42s1immsi3n4a2s1ind2s1infsing1asin3ghsin2gr4s1inhsini1e2s1inq2s1ins2s1int4s1invsi2s1esi2s1osi2s1psi2tausi2tra3skala4skanz3s2ki_3s2kik3skulpsla2vesler3s3s4lipsli4tuslo3be4s5not2s1o2bs1o2he4sohng2s1ohr4so2lyson3auson3säso1ral2s3ordso2rei4s1ostso3unt2s1ö2l2spala2spara4sparo3sparuspe3p4s1peri2sperl2speros2perr4spers3s2pez4spi4p3s2plis3p4lu4s3poss2potts2pracs2pran4sprax2spräm4spräs2spred2spres2sprob4sprüfsrat2ssrö2s1ssa3bos2sanos4sansss2antss3attsse3hass1erös3s2essse3tass1offs2s1opss1oris2spros3stelss4tipss2turss1ums2stabb3s4tad3staff2stale2stalkst1almst1alpst1ami4stan_sta4na3stand2stani2stans2stanws4tar_4staris4tarsst1asis3tat_2stauf2staum3staur2staus4stälts4tänd5stätts3täus4s5te_3s2tegste2gr3s4tehs2te2i3steig4steil1s2tel2stel_2steln2stels4stem_s5ten_st4ens4stermste4sts4teti3s2teu1steue4steufs2t3ho2stie_s2tiegs2tiel2stien3s2tif3s4tims4tinfs3tinnst1ins1stitu2sto3d4stod_s4toffs4t3om2stopo2stor_2store2storg2storis3tort2stose4stote2stöch2strad2strag4strai4strak2stral5straß2strua2strug3struk2strup2st3t43s4tud2stumt2stun_4stunn2stuntstu3rest3url2sturn2s3tus2stüch2stür_2stüre2stürg2stürs3s2tyl3su2b3su2cha2s1u2fsu1it_su2marsu2mau3s2umesu2mels3umfesum1o2su2mors3umsas3umst2s1uni2s1urlsüden24s3zeis2zena4szent4s3zet2ß1e2gße2l1aß2ers_2ßerseßge2bl2t1abb3tabel2taben3table2t3abn2t3abtta3d2s3taf2et1af4rta2ga24ta3gltag4sttah3leta3i2kta1insta1ir_t1a2kata2krotak6ta3taktb3t2al_ta3lagta3lakt1alb_t1albk3t4aletal2löta2mert1amplt1a2na4t2andt3ankl2tanwa2tanwät2anz_t1anzat1anzuta2pe_ta2pes2t1armt1artitar2to2t1arz4t1aspta2tanta2tautat3eita2temtat3heta2tom4tatue2t1auf4taufg4taufnt1ausb3tausct2auset1ausk4tausltaxi1s2t1ältt1ängs3t4ebbte3cha3technteck2ete2ckite2en3te1erwteg3ret3eifr2t1ein4teinf4teinnt3eis_t3eisb3te3letel1eb2telemtel1ente4leute2littell2ete2l1ö3telt4tel3tatel3thte2min2temme2tempfte4m1utena2bte4naste4nauten3dat6endit6endote2nefte2nettens2et4entat3entb4tentdt4ente4tentnten3zwt3e2pi3t4er_tera2bte1rafter3am4terbs4terbtte2relt4erfrte3ria3termi2ternct4ers_terst4ter3zatesa2cte2santesä2cte2selte2sprtes3s2te2tat3teur_2t1exz3t4ha_3thal_4t3hau1t2he_2t3heit4heint4henet4heni2therr3these2t3hil2t3himth4mag2t3hoc2t3hoht4hol_2t3hot1th2r2ti3a2mtiden2ti2deo3tief_3ti2erti2kamti2karti2kinti2kräti2larti2leiti2lel4t1imp3t2in_4t1indti3n2eting3lting3s2t1inj2t1int4t1invti2seiti1sta2ti3tuti2vanti2velti2v1oti2v3rtlung4tnes4s3tochtto4d1utom1e2to2mento2nauto2nehto2pakto2patto2rauto4ränto2relt3orga3torint1ort_3tost4to1sta3to3teto2thotouil44tractt3rad_6trahm5t4rai2trand3trankt3rann3transt3raset3rasi3träne4t5re_tre2brt3recht4reck6t3red5t4ree4trefe4trefot4rei_4treic2treift3reigt3reint3reis6treitt3reiz6t3relt4ren_3trendt3rent2trepe2trepot4reprt4res_3treuh5trieb2triegtri4er5triggt3rind4tringtri3ni4trinn4tripttrizi13t4roitro2ke4trom_tro2mi4troml2t3roo3tropf2t3röttrums15t4ruptru2thtrü1betrü1bu2t3rüct4sa4bt3s2act2s1aht4s3art2s1änts4cort3seiltse2n1t2s1erts1init2s1irt1slalt3spalts1parts2pedt3spekt3s2pit4stagts3takts4talt2stipt4stitts3tocts3tort2strits3türtta2bet2t1adtt2anttt1arttt1ebett1eiftt1eistte2lattel1otte2satte2sätt2häut2t3hott4roctt2sentt2sortt2spett2sprtt2stitu1almtu2chitu3fent3u2kr3t2ume2t3umf2t3umg2t3umk2t3umrtum2situm2so2t3umt2t3umz2t1una2t1und2t3unft3unga2tunif2t3unttu2re_tu2reitu2resturin1tück2s3tür3s3tütentze4n1tz2enetz1erltze2rotz2erst3ze2stzgel2tz1indtz1inttz2tinua2lauu3aletual2mau3a2louara2bu2be2cub3licu2b3luub2sanub2s1oub2spau1cha_uch1eiu3chesuch1iluch1inu2ch3ruch2souchst4u2ckemuder2eudert4udi3enuditi4ue2neruenge4uen2zuue2r3aue2r1äu3erehu3ereru3erexuer3g2uer2neue2r3ouer3scuer3t2u3erumue4teku2f1äsu2f1eiu2f1emu3fen_u2fentuf2ernuf2frouf1oriuf4sinuf2spouft3s2u2g1apu2g1eiug3ladu3g2löug4serug3spaug4sprug4spuug5stäug3strug3stüuhe3s6uh2reruh4rinuisi4nui4s5tukle1iuk2t3ruld2seu2l1elul1erful1erhul1erwule2saul1etaul1insul2lesul2p1hul4samuls2thul4trium1allum1anzu2maut1um3d2umer2aum1ins3umsatum4serum2simu2m1uru3n2amu2n3an2un2asun4dabun4deiun2didun2dorun2d3r4unds_und3spund3stun2ei_un3einunen2tun4es41unget1ungew1unglüun2g1rung3raung3riung4saun3ide1u2nifun3islu3n2it3u2nivun2keiun3n2eunvol2u1or3cu2pf2eu2pf1iu3rabaura2beur2anbur2anhu2r1auur3b2aur1effu2releu4r1epur1erhur1erwur2griurg3s4ur1iniur3insur1int1urlauur3sacur2sanur2sauur2serur4sinurst4rur2z1wus4annu2s1ecu2s1eiu3seiduse1rau2serpu2s1opu2spatus1picus2porus4sezus2sofu1stalus3tauust2inu2stunu2sturut1altut3a2mu2t1apu2t1arute4geut1ei_ut1eieutel1eute2n1u2tentu4t1exu2t3hout1opfu2topsut3reaut3s2aut2s1äut2spaut5t4lutu4reutu5ruut2z1wuve3räüb2s3tücht4eü3ckenück1erü3den_üden4güdwes2ü2f1eiü2h1eiühl1acüh3r2eühr3taü2mentün2fliün2g3lün3strü2r1eiü3r2o1ü2schlüs2s1cü2t1alva2teiva2t3hvatik2va2t3rvat3s4va2t1uveits32ve3muve3nalve3radve3rasver3b2ve4rekve4rinver3stver5te2ve3scves3tivi4a3tvie2w1vi2l1avi4leh2v1i2m2v1intvi3s2ovoll1avol2livo5rigv1steuwab2blwa3chewaffe2wa2g3nwah2liwal4dawal2tawal2towang4s1war2eware1iwart4ewass4e4webebwe2g1awe2g3lwe2g3rweg3s4wei4blwei2gawei3k4wei4trwel2t1wel4trwen3a4we2r3awer2bl1werbu1werduwerer2wer2fl1werk_wer2ka1werkewer2klwer2kuwer2tawer2to1wertswe2s1pwest1awes2thwest3rwes4tuwett3swi3ckawien2ewie2stwim2mawin2drwi3s2e1witzlwo2chawoche4woh2lewo2r3iwo4r3uwört2hwul3sewur2fa1wurstwus3te1wu4t1xe3lei3x2em_xen3s2x1i2doxin3s2xi2so2xis4täx1i2tuxtblo4x2t1eix4tentx2t3evy3chisyloni1y2p1iny1s4tyy2s1u22z3a2b2z3a2k2z1all2z3anf2z3anlz1artizar2tr2z1arzza1st42z3at3z1au2fzbübe32zecho2z1eck2z1effzei3lazeile42z1einzei3s4zeist4zei2trze2lenzell2azel3sz2z1empzens2ezent3sze2r3a2zerhöz2erl_2zerlö2z1erq2z1erzze3skuzes2spzes2stze2s3tze3sta2zettszger2azi3alozi1erhziers1zi1es_2z1impzin4er2z1inf2z1inhzin1itzin2sa2z1invzirk6szi3s2zzi1t2hzor4ne2z1oszz2t1auz4tehezt1inszt3reczu3ckezug1un2z1uhr2z1um_zumen22z1umszup2fizu3r2a2z1url2z1urs2z1urtz2wangz2weigz1weis2z1wel2z1wen2z1werz2werg2z1weszzi1s4",
        7: "_al4tei_amt4s3_and4ri_an3gli_angst3_an4si__an4tag_ausch3_be3erb_be3r2e_berg3a_bo4s3k_bu4ser_da4rin_da4te__da4tes_de4in__dien4e_ebe2r1_en2d3r_en4tei_er4dan_er4dar_er4dei_er4der_es5t4e_fer4no_fi3est_fi4le__fi4len_ge5nar_ge3r2a_ge3r2e_ger4in_hau2t1_her3an_ho4met_ima4ge_ka2b5l_li4ve__lo3ver_lus4tr_men3t4_orts3e_pa4r1e_reb3s2_re3cha_rein4t_reli3e_res6tr_sali3e_sim3p4_sto4re_tage4s_ti4me__ti4mes_to4nin_tri3es_ul4mei_urin4s_ur3o2m_ve5n2e_wei4ta_wor4tu_zin4stab1er2raber4ziaber4zoab3essea4cherfa4cherka4cheröach1o2bach2t1oach1u2fa3d2ar3ade1r2aade3s2pade5str2ad3recaf4t5reage4neba4gentuage4ralage4selage2s3pag3esseags4toca2h1erhah4l1eiahner4eahre4s3ahr6tria3isch_ajekt4o1a2k4adak5t4riala5ch2a2l1angalb3einalb3eisal4berh3a2l1efa4l3einal3endsa2l1erfa2l1erha2l1ert3a2lerza2l1eskali4eneali4nalal3lenda2l1o2balt3eigalt3ricalt4stüalzer4zamen4seamp2fa2am4schlana4lin2ana1s4and4artandel4san2d3rüand4sasand3stean2f5laan2g1eian4gerwan2g3raan2k1anan2k3noan2k3rä3antennan3t4heant3rina3ra3lia2r1anga2r1ansa2r1anza2r3appar2b3unaren4seare3r2aa2r1erhar2f3raari3e4nari3erdari3ergarin3itark3amtar2k1arark3aueark3lagark4trear4merkar3m2ora2r1o2dar2r3adarre4n3ar4schla4schecasch3laa2s3e2ma2s1o2fas4s3eia1s4tasas6t3rea2t1aktater3s2ato4mana2t1ortat4schnatt3angat3t4häat2t3räat4zerkat4zerwat2z1inau2b1alauch3taau4ferkaup4terau2s1ahau4schmau4schoaus3erp3aussagaus4se_aus5triau2t1äuä3isch_äl4schlän3n4e2ä2r1eneär4mentäser4eiäse4renäskopf3ät4schlät4schräu4schmäus2s1cba2k1erban2k1aba2r1ambau3s2k2b1eierbei4ge_2b1eimebe1in2hbe2l1enben3dorben4spaben4sprben5t4rber4ei_be4rerkber4in_ber3issbe2s1erb3esst_be3s4ze4b1illubis2s1cb2i3tusbjek4to2b3leidbo2l1anbor2d1ibor2d3rbor2t3rbra1st42b3rat_2b3riemb4schanb6schefb4s1erfb4s1ersbst1a2bb2s3träbs3treubtast3rbu4schlbu4schmbu4schwbügel3eca3s2a3ch3a2bich3anst3chartache4fer4chelemche4ler4chents4chentwche3rei2ch1e4x3chines2ch1invch3leinch4sper2ch1unf4ckense4ckentw4ckerhö4ckerke2ck1err4ckerze2ck1eseck4stro2ck1um3com4te_comtes4cre4mes2d1alar2d1ammädan4ce_dan5kladan2k1odar2m1i2d1au2f2d1aus3delei4gde3leindel4lebdel4leide2l1obdel4sandel2s5edel2s1p4denergden4sende2re2bde4reckder3ediderer4tderin4f4derklä4derneuder3taudert4rades3eltde2sen1de4stredes4tumdeten4tdge4t1edie4nebdi3ens_die2s3cdi2s5tedi4tengd2o3r4ador2f1a2d3rast2d3rauc3d4reck2d3reic3d4riscdrunge3drü5cked4s1amtds3assid4schind2s1e2bd4seinsd2s1engd2s1entd2s1erfd2s1erkd2s1erzd4s1etad3s2kand2s1pard3stell2d1un3ddu4schndu4schrdu4schwe4aler_e3at5t4ebens3eebet2s3eb4scheeb4stätebs3temebs3t2hech1o2bede3n2eeden4seeden4speder3t2ed2s1esed2s3treein4see2f1e2be2f1i2de2f1insege4strehen6t3ehe3strehl3eineh4lenteh5l2erehr1e2cehr3erleienge44eigeno1ei2g3nei3k4laei4leineil3inseim3allei4nengein4fo_ein4fosein4hab3einkomei2n1o23einsate4inverekt4antekt3erfekt3ergela4bene2l3a2me2l1a2re2l1eine3leinee4leing2e3len_e4lensee2l1ente2l1erge2l1errell3ebeell3eiseller4nelt3eng3elternelt3s2kelt3s2pe2m3anfe2m1ansem2d3a2e2m1erw1e2metiem2p3leena3l2ien3d2acend4ortend3romend3s2pene4bene4n1enten4entr4e3ner_e2n1erd1e2nerge2n1erle2n1erre2n1erse2n1erte2n3erue2n1erwe4n3essenge3raeni3er_e2n1i4me2n1o2benob4lee2n1o2ren4terb3entspr4entwetenz3erte4ratemerd3erwer3echser1e2ckere4dite2r1e2h4e3rei_4e3ren_e4rensee4rentne2r3erfe2r1erher3e4tiere4vid3ergebn4ergehäe3ri3k44e3rin_e2r1ini3erlebnermen4serm3erse2r1o2pers4toder4tersert3ins3erweck6erweise4s3atoe2s3einese4lere3s2peke3s2pore3s4praess3erges2s1paestab4be4starb1e2stase1s2tecest3ories3tropeße3r2eeten3d2eter4höeter4tre4traume6t3recetsch3wet2t3auette4n1et4t1umeu3ereieu3g2ereve5r2iewinde3e2z1ennfa4chebfa2ch1ifäh2r1ufeh4lei2f1eing4f1einh2f1einw2fe2lekfe2l1erfel4sohfe4rangfer3erz4ferneufest3eifet2t3afeuer3effel2d1f2f3emifi1er2ffi2l1anfisch3o2f3leinflu4gerfor4teifor2t3r2f5raucf4schanf4scheff4s1ehrf2s1entf4s1etaf3s2kief2s1pasf3s2porf4stechf3s4telf3sternft1a2bef4t1entft4scheft4s3täft4stri2f1u2nifun2k3rfus2s1pfu2ß1er4gangeb2g3ankugas5tangebe4amge4lanzge4lessgel3stegel3t2agen4auggen2d1rgen3eidgen3erngen4samgen4ta_2g1entfge4renggerin4fgerin4tger4satger4stoges3aufges3eltge2s3erges3s2tgien2e12g3isel3g2laub2g1lauf4g3lein4g3lisc2gni2s13g2num_2g3rede2g3reic2g3rein2g3renng3riese2g3ringg4s3a2kg4schefg3s2eilg3s2pekg3s2porgst3entgst3errg4s3torgs4trat4gungew2g1unglguschi5gus4serhaf3f4lhalan4chal4beihal4t3rhar4mes2h1aufmhau4spahäu2s1chba2r3ahe4b1eihe5ch2ehe2f1eihef3ermheiler4heit4s3he2l3auh3e2lekhel3ershel4meihe4n3a2hen3endhen3erg2h3entwher3a2bhe4reck4hereighe4rerwh1er2foherin4fherin4sh3erlauhe2s5trhie4rinhif3f4rhi2l3a4hin4t1ahir4nerhlags4ohle3runhner3eih3nungeho2l1ei2hot3s2hrei4bah4r3eigh3re2s1h2r1etah3rieslhr2s1achr2s3anhr3schlhr2s1enhr4s1inhr4s1ofh2s1achh4schanhse4lerh2s1erlh2s1ingh2s1parhst3alth2s3tauh3steinh5stellhst3ranh3taktsh4t3alth4t3a2mh4t3assh2t1eimh2t1eish4tentfht3erfoht3erfüh2t1erhh4terklht3erscht3ersth2t1erzh4t1eseh4t1esshte3stah4t3rakht3randh2t3rath4t5rinh2t3rolh2t3rosh4t1rösht3spriht4stabhts4tieht4stürh2t1urshu2b3eihu2b1enhu2l3eihu4lenthu2l1inhut4zeni3alenti3alerfi3alerhi3a2leti3a4liai1ät3s4i2b1aufich4speich2t3rieb4stoieb4strie2f1akie2f1anie3g4rai2e2l1aien4erfienge4fien3s2eie3r2erie4rerfi2er5niier4sehier3staier3steies2s3tie2t3hoie4t1ö4i2f3armift3erkif4t3riift3s2pi2g1angi4gefari3g4neuig3steiig4strei2k1a4ki2k1anoi4kanzei2k1erhi2ker2li2k1etaik4leriik2o3p4ikt3erki2l3a2mi4lentsi2l1erfi2l1ergi2l1erril2f3reilig1a2ili4gabi2l1indil3l2eril4mangil2m3atil2z1arilz3erki2m1armimat5scima4turi2m1erfi2m1erzi2m1infi2m1insindes4ii2n1engin3erbei4nerbiiner4löing4sam3inkarninma4leinn4stains3ertin3skanin3stelin4s3umional3aion4spiir2m1eii4s1amtisch3ari3s2chei4schefi4schini2sch1lisch3leisch3obisch3reisch3rui4schwai4schwoisch3wuise3infi4seinti2s1ermi2s1essis4s1aci1s4tati1s4teui1s4tilit3a4reiten3s2iti4kaniti3k2ei2t1in1i2t3ranits1a2git2s1e4its3er1it2s1peit4stafi2v1enei2v1enti2z1enejek4terjektor4je2t1u2jugend3jung3s42k1a2bo2k3a2drka3len_ka4lenskal3eri2k1annakari3es2k1artikau2f1okauf4spke1in2d2k1eiseke4leim2ke2lek2ke3letkel3s2kk3enten2k1ents4kerfahk4erfamk3ergebk3er4hökerin4tker4kenker4neuker4zeu2k1i2dekie2l3o2ki3l2aki3n4o32k1inse4k1lastkle3ari4k3leit2k1o2fekop4fenkot4tak2k3räum2k3redekreier4k4s1amtk2s1ersk2s1erwk3stat4k2t3a2rk2t1erhk2t1ingkti4terk4torgakt3oriek2u3n2akuri4erku4schl4l3aben4l1a2bl2l1a2drla2g1oblan2d3rlang3s4l1a2po2la2r1anla2r1eila4rene3l2ar3glar3ini2l1ar3t3lasserla2t3ralat4tanlat2t3rlau2b3rlaub4se2l1ausslär2m1al2b1edel2b1insld3a2b1ld3a2ckl2d1a2dl2d3a2nld4arm_lecht4ele2g1asleh3r2elein4dulei4ßerleit3s22le2lekle2m1o24lendet4lenerg2l1ennilen4sem2l3entwlent4wäle2r3asler3engle4rers3lergehl3ergen2l1ergilerin4s2l1er2ö3l2erra2l1esellgeräu33lichem3licherliebe4slie2s3clik4ter2l1indulingst4lin2k1ali4schu2l1i4solkor2b1ll1a2bel2l1a2mlle4n3all3endul4lentsl4lerfol4lergoll3erntll3ertrl2l1indl2l1o2rll1ö4sellus5t6l2m3a2blm3einsl2m1e2pl2m1erz2l1o2bllos3t4r2l1ö4l3l2s1a2dl4s1ambl4schinl4schmül2s1e2bl2s1ersl2s1erwl2s1impls3ohnel4t3amel2t3atol2t1eislt4stablt4stocltu4ranluf2t1aluf2t1eluf2t5rlung4sclus4s3alus2s1cluss3erlus2s1olus2s1plus2s3tlus4stälus4t1alust3relut1o2fmach4trma4ges_ma4laktma4l3atma2l3ut2m1analman4ce_man3ers2m1angr4ma3r2oma3s2pa4m1aspemassen3mas4telma1s4trma2ta2b2m1au2fmäu2s1cmbast3emedien3mein4dame1i4so2m1e2miment4spme2r3apme4rensmerin4dmerin4tmerz4en4m1essames2s1omes2s1pme4t3römierer4mil4cheminde4sming3s4mi4schami4schnmi4schwmis2s1cmi2s5tem2m1ansmme4linm4mentwmme2ra2mme4recmmi1s4tmo4n1ermor2d3amoster4mpf3erpmpf3errms5trenm2t1erfm4t1ergm2t1erlm2t1ersm2t1ertm4t1etam2t1insmt3s2kamun2d1amül4lenmütter3na3chenna2l1a2na4lent4n1a2nana4schw4n1a2synauf4frn4austenbe3r2en3ce2n3n2d1anznde4al_nde4lännde4robn2d3ratn4d3runnd4stabnds3taune2e2i22ne2he_2nehen44n3eing4n3eink3ne3l2o4n1endb4n1endd4n1endf4n1endh4n1endk4n1endp4n1endt4n1endwne4nenenen4ge_nen4gen4n1entl4n3entwne2ra2bne3r4alne2r3am4nerbe_4nerben4n5erfonerfor42n3erhö2n1erlöner4mit4n1ernt3n2ers_2n3ersa4n3essine2t1akne2t1annett4scnfi4le_n2g3a2mn2g1andn2g1einnge4ramnge4zänn2g1i2dn3g2locngs5trinie3l2a3n2ing4ni4schwnitt4san4k3algn2k1insn2k1ortnk2s1aln4n1alln4nentsn2n1unfn2o3ble2n1ob2s2n3o2fenor2d5rno4t3eino2t3inno2t1opn2s1a2dn2s1alln2s1äusn6schefn4schronsen4spn2s1erkn2s1erön2s1erwn2s1erzn4s1etan2s1inin4sperin4stat_nst3eifn3stemmns4tentnst4erön4stracn4strien3t2a3cn4tanzan2t1eisn4t1essn2t1inhnton2s1nt3reifnt3riegntu4re_ntu4res1n2ung4n2z1a2gn4zensen4zentwn4zentznz3erwe2o3b4enoben3d4oben3seobe4riso2ch1ecocher4ko3d2e1iof2f1inoge2l1io2h1eiso2h1erto2h1erzoh4lergoh4lerwo3isch_ol2l3auoll1e2col2l1eiol4lerkoma4nero3m2eiso2m1indo2m1into2n1erdon3n2anont3antont3erwon4t3riop4ferdopi3er_o2r3almor2d3amor2d1irord3s2to4rientor2k3aror4mansor4mentor3n2o1oro3n2aor2t1akor4t1anor2t1auort3eigort3erfor2t3evort3insor4trauort3ricor2t1umo4sentsoss3andost1a2bos4t3amost3angos3tarros4ta4soster3eos4t1obost3ranost3roto2ß1enzo2ß1ereo2ß1erfo3t2e1iote2l1aote4leio2t1erwo2t1i2mot4terkoun4ge_our4ne_ozen4taöchs4tuögen2s1öl2f1eiö2r1e2lö3r2erzö2r1uneö2sch3mpa2r3afpar3akt2par2erpar4kampar4kaupe2l1a2pe3li4npe3n2alper2r1a2ph1erspil4zerpingen4pi2z1in3ple5n4po2p3akpo2p3arpor4tinpor4trepor6tripo2s3tepost3eipost3rap2p3a2bppe4lerp4t1entpt3ereip4t1erwp4t1erz2r1acetra4chebra4chinracht3rr3a2d3r3ra1k4l2r3alm_r4alt2hram4manram4m3uram2p3lran4dep4r3aneiran4spara2r1inra4schl2r3asph2r3attarau3e2nrau4man2raus5srbe3r2erchst4rr2d1elbrden4glrder4err2d1innre3alerrech3ar3reigewrei3l2arei3l2irei3necre1in2v2re2lek2r1entl2r1ents4r3entzr4ergen2r1ernä4r3erns4r3ernt3r2ers_2r1ersare2s2tu2r3evid2r3e2x1rfi4le_rfolg4srf4s1idrf2s3prr2g1a2drge4ralrge4taprgi4selr2g3ralrg5s2turi2d3anri3ers_ri3estiri2f1eirif4terri4generin4dexrin4diz4rinnta3r4ins_r4inspirin4tegrin4t5rri4schori4schwr3i2talr2k3reark4stecrkt3ersrk2t1o2rl2s3tor2m1aldr2n1anzr4n3eisr4n1enern3enser4n1ergrn4erhir4n1ertrol4lanro4nerbron4tanros2s1crre4aler2s1a2dr4s1amtr2s3angr3sch2er4stantrs4temprs4terbrst3ingrst3ranr2t1almrt3a4rer2t3attrtei3lartei1s4rten3s2rt3ereir4terfar4terfor4t3erhr2t1erkrter4rerte3s2kr2t1imar4t3rakr4treisrt4s1ehr2t1urtru3a2r3ruch3strun2d1arund3er2r1u2ni4r3uniorus2s1pru2t1o2rve4n1er2z1erfr2z1ergr2z1erkr2z1erwrz2t3ror3z2wecsa2cho22s1a2drsa4gentsa3i2k1sa2l1ids3ameri6s1amma2s3a2nasan4dri4s3antr4s3a2sy2s3aufb2s3ausb3s2ausesbe3r2es4ch2al4schanc4schangsch3ei_4schemp4schess4schiru4schle_sch6lit4schre_4schrinsch3rom4schrousch3s2k4schunt4schwetsch4wilsdien4e2s1echo2s1e2ckse2e1i4se2h1a2se4h1eise4herk5s4ein_sein4dusei3n2esein4fos4eins_4seinsp4seinstsel3ers2s1endl4s1entf2s3entg2s1entsser3a2dse2r3als3erbe_s3ereig2s1erfo4serfül4serken2s3ernt4s3eröf4sersehse4r1ufse3rund4se4tap4s1e2thsi3ach_siege4ssi2g1a2si2k1absik3erlsin3g4lsing3sasi4schuska4te_4skategska4tes4s3klassni3er_sni3ersso4l3eisol4lerson2s1o2s1orga5s2orgeso2r1o24s1o2ve4spensi3s2pi4e4spier43s4prec3sprosssrat4scss1a2cks4s1alas4s1albs4s3amts4s3angs4s3anzs3sa1s2s2s1egasse3infss3ersessquet4s3ta3li4s3tann3staus_st3a2ve4stechn3steilhstei4naste4mar6s5ter_3sterncs4t3ese3s4tett1s2ti2rst1i4sosto3s2t1s4trah4strans3s4tras4straum4s5träg4sträne4s5tref4streibst3renn2s4trig2s5trisst3rollstro4ma4st3run2s4t3s42stum2sstum4sc3s4tunds2t3uni2s3tuns2st3urtsuch4st3s4zene2ß1estrßi2g1a2ta2b1anta4bend2t1a2drta2g1eitahl3sk3t2aktuta4lensta2l1optan4gar2t1anme4t1anna3t2ans_4t3ansi4t3anspta4rens3t4a3rita2ta2bta2t3erta2t1um4t3ausg4t3auss4t1auswtbauer4tbe3r2e4teilhet3einget3einlate2l3abte2l1acte2l1autele4bete4l1ecte4l1ehte4leinte4lerd4t3elf_te2l1inte4losttel3s2kte2m1ei3temperte4na2dte4na2g4t3endf4t1endl4t3endpten3d4rten3eidten3ens4tenerg4t1eng_ten4glate4n3in4tensem4t3entw4t3entzte3ran_te2re2bter3endte4rengte4rerkterer4z4terfol4terfül3ter3g2t6ergru4terklä2t1erlöter4mert3erneuter4re_ter4sert4erst_t4erstit4erstute4r1ufter4wäh2t3erzbtes3tantest3eitestes4teu3ereteu3eriteu2r3a2t3e2xe2t1e2xi4thrin_4thrinsti4dendti3e4n3tie4recti4gerzti2ma2gtim2m1atin2g1at1in1ittin2k1l3t2ins_4t1inseti4que_ti4schatisch3w3ti3t2etle2r3atmen6t3tmo4desto2d1ertor3inttra3chatra4demtra4far2t3rams3t4ran_tre4ale3t4reib2t3reih4trenditre2t3r2t3rund3t4runkt3s2chat4schart3sch2et4schefts4chemtsch4lit4schrot2s1e2bt4seindt2s1engt2s1entt2s1i2dts4paret3s2pont3s2port4spreits3tätit2s3tepts3tradt4strants3traut2s3trät4streut4stropt2s3trütte4lebtte4lent3u2fertums5trtung4s5tu2r1ertu4schlt2z1e2ct2z1eiet2z1eistz3entsubal3l2ubi3os_u2b3rituch4spruch4toruch2t3ru4ckentu3ck2eruden3s2ue3reigue4rergue4rerku4erinnuer4neru3erunfu3eruntu2f1ä2ßu2f1erhu4ferleufs3temuf2t1ebu4gabteu2g1erfu2g1erlugge4stu2g3rüsu3isch_u3ischsuk2t1inulm3einu2m3a2ku2m1artu2m1ausument4su2m1ergu2m1erlu2m1erwumpf4lium2p3leum2s1peun2d1umun2k1a2unk4titunk2t3run2n3aduns4t1runte4riunvoll3up4t3a2upt3ergu2r3a2mu2r1anau2r1angurgros4ur3s2zeu2s1eseusi3er_us3partu2s1pasu3s2peku5s4pizust3abeu5strasus6trisute4leiuter4eruto4berut4schlut4schmut4schöutz3engut2z1inüch2s1cück3eriü4ckersück4speü3d2ensü2f1ergü2h1engü2h1erkü2h1erzühr3ei_ül2l1eiün2f1eiü2r1entüste3neva2t3a4va4t1inve4l1auvenen4dve3rand2ve3s2evid3s2tvie2h3avie4recvi2l1invollen4vormen4waffel3wah4lerwalt4stwar3stewa4schawä3schewe3cke_we3ckeswei3strwer4gelwe4r3iowest3eiwest1o2wim4m3uwolf4s3wol4lerwor2t3rxi2d1emx2t1e2dxtra3b4x2t3rany2l3a2myl4antezei2t1aze2l1a2ze2l1erze2l1inzel3t2hze4n3aczen4semzen4zerze2re2b2z1ergäz3erhalzerin4tzer4neb2z1ersazert1a2zert4anzer4tin4zerwei3z2erzazessen4zger4s1zin4ser4zinsufzon4terz3t2herzu2g1arzu4gentzwan2d1",
        8: "_al1e2r1_al5l4en_anden6k_ar4m3ac_ar4t3ei_ber6gab_ber4g3r_de3r4en_einen6g_en4d3er_en5der__er4zen4_ka4t3io_lo4g3in_mode6ra_ost5end_oste6re_par3t4h_richt6e_sucher6_tan4k3la2ch1e2ca4ch3erwacht5ergach6tritack3sta43a2er2o1af4t3erlage4s3tiah4l3erhal4b3erw3a2l1e2bal2l3a4rall5erfaalli5er_al4t3erfam4t3ernand6spas3a4n1erban4g3erfan4g3erlan4g3erzang4s3poani5ers_an2t3a4ran2z1i4nar4t3ramau5ereinau4s3erwauster6mau4ten4gau4t3erhäs4s3erkbach7t4ebal4l3ehbe4r3eiwber6gan_ber3st4abe6steinbe4s3tolbote3n4ebst5einbbu4s3chach3e4ben6chergebcher6zie6ckergeb4d3achse2d1an3d22d1e4ben3d2e1i2mde2l1a2gde4l3augdel5sterde4n3endden4k3li4den4semde4r3eisde3r4erbde3r4erfde4r3ero4d3erhöh4d3ersatdest5altdest5ratdienst5r2d1in1it4d3innerdi4t3erldi4t3ermdi4t3ersd4s3tätid3s4tern2d1u2m1edu4sch3le3a4reneech3t4eiege4n3a2eg4se4r1ehr6erleei4b3uteei4d3errei2m1a2gein6karnein6stalei6schwuei4s3erwek4t3erzeld5erstel4d3erwe4ler4fae4ler4lae4l3ernäe4l3e4taelgi5er_elgi5ersel4l3einemen4t3he6mentspen4d3esse4n3ermoeni5ers_en5sch4eenst5alten4s3täten4t3rolen4z3erfen4z3ergen4z3erke2r3a4sie4r3eis_e4r3entferi3e4n3er6tereier4t3erfess4e3rees4t3enges4t3erhes4t3essestmo6deet4z3enteue6reifeut6schnfacher5ffal6schafal6schmfe4r3anzfrach6trf4s3tätif4s3tresf4s3tütef4t1e4tift4s3tanfzeiten6gas4t3el2g1eise2gel4b3ragel4b3rogel6dersge4l3ers4g3ereigge4ren4sge4r3entge4s3terglei4t5rgrammen6gros6selg3s4tatigs4t3rosgu4t3erhhaft4s3phal6lerfhau3f4lihau5steihau6terkhe4f3inghel4l3auhe2n1e2bhe4r3eishe4r3o4bhfel6lerhich6terho6ckerlhol6zeneh6rerlebh3s4terbh3t4akt_h4teil4zh4t3elith4t3entsht5erkenh6terneuh4t3erreh6terstaht6ersteht6raumeht4s3turhu4l3enghut4z3eria4l3ermie4n3a2gie4n3ergienst5räie4r3erziesen3s4ie4t3erhie4t3ertiker6fahi3l4aufbim4m3enti2n1e2bei4ner4trin2g1a2gin4n3ermin4s3tätir4m3untir4sch3wi4sch3eii5schingi6schwiri4s3etatiso6nendis4s3cheit4z3ergjah4r3eika4n1a4s6kantennkehr4s3o4ken4gagken5steiker6gebnkerin6stk3er4lauk3er4lebk6erlebe2k1er2zikeu6schlkor6dergkre1i2e4k4s3tanzk4t3erfolan2d3a22lat2t1alat4t3inl2d1e2seleben4s3lei6nerble4n3end5lentwet4l3ereigle4r3eim3l4ergew6lerwerbli4g3ers2l1in1itl6lergebl6lergen2l1or3g2l4s3ort_l4s3tätils6ternels6ternsl4te4leml4t1e4skl2t1o2rilu2g1e2blus6serflus6serklus6serslu4t3ergl2z1u4femagi5er_magi5ersmar6schmmar6schrma4t3erdmen6tanz4m3entwi4m3ergänmes6sergmp4f3ergmp4f3erz4m3ungebmu4r1u2fnacht6ra4n3a2mernavi5er_navi5ersn4d3entsnder5stene2n1e2bn4g3erseng4s3e4h2n3i2gelni4k3ingn4k3erfanseh5eren4s3ort_n4s3prien4s3tatens6terbenst5opfenten6te_nt4s3parober3in4ode6rat_ode6rateoh4l3erholl5endsoll5erweol4z3ernonderer5on4t3endopf5erdeopi5ers_or4d3engo2r1e2ckorsch5lior4t3entor4t3ereor4t3offor4t3räuos4s3enzo2ß1en2kö4sch3eipargel6dpä4t1e2hpä4t3entpe4l3inkp2f1in3spos4t3agrach6trärali5er_rali5ersran4d3errau4m3agräu5scher2b1a2der4b3lastrch6terwrderin6sr4d3erntrege4l3äre4h3entreister6re4n3end4r3erken4r3erlaurge4l3errgen4z3w4r3innerrkstati6rk4t3engrk4t3erfrk6terscrk4t3erwr2m1o2rirn3e4benrol3l4enrpe4r3inr6scherlr4s3ort_r6strangr4t3erler4t3ernäru6ckerlrun6derlrun6dersrun6derwr4z3entssa4l3erbsat4z3en6schlein2s1e2bense4l3erl4s1e2pos6sereignse4r3eimse4r3enk2s1i2deoson5ende2s1o2riesrücker6sse3in4tstel4l3äs4t3endss4t3engls4t3entfste6rersstes6se_5st4reif1s4tri2ksun6derhtan6zerhta4r3eretau3f4litau6schrtau6schwtblock5e4t1e2bentein3e4cte2m1o2rte2n1e2bte3n4ei_ten4t3riten6zerh4t3erde_te4r3eif6tergreiter4n3art6erscha6terwerbtes6terkti4v3erlto6ckenttrücker6t4s1amt4t4s3esset3s4terotta6gess2t1u2niotu2r1a2gtu2r1e4tu2ch1e4cu3erin4tuern3s4tu4g3reisun4d3erfund5erhau2r1an5sur3a4renu6schentusch5werusi5ers_u4t3ersaüge6leiswach6stuwach4t4rwahl5entwandels6we5cken_wein4s3aweis4s3pwel6schlwel6schrwel4t3a2wen4k3ri5werdensxpor6terx2t1er2fx2t1il2l2z1e2benzeit5endzei4t3er4z3ergebzer4n3ei4z3erstezer4t3agzer6terezer6trau",
        9: "_char8me__er8stein_he6r5inn_men8schl_men8schw_os5t6alg_rü6cker6_wort5en6_wor8tendach8traumalli7ers_allkon8tral5s6terbausan8ne_äh4l3e4be6b5rechtebs3e4r3inchner8ei_dampf8erfden6s5taue6ch5erziee4r3en4ge6l5eier_erg3el4s3fal6l5erk6fel6ternfor4m3a4gforni7er_fzei8tendgot6t5erggrab8schegren6z5eihä6s5chenhe6rin6nuherin8terh6l3er4näh6t5erspaieler8gebi2k1e2r2eil4d3en4ti4sch3e4hkamp8ferfke6rin6nulan6d5erwlan6d5erzleis6s5erlepositi86mel6ternmorgen5s65n2en3t2aner8schlenich8tersn4n3er4wano6t5entrnsch7werdn5s6ternen5s6ternsos4s3en4kpapieren8ram6m5ersr8blasserres6s5erw6r5innenmris6t5ersr6st5eingrs4t3er4wr4t3er4lasfal6l5erspani7er_sse6r5atts4s3e4strsu6m5ents4t3a4genttblocken8tes6ter6gür4g3en4gvati8ons_vol6l5endwer6t5ermwin4d3e4czes6s5end",
        10: "_er8brecht_os8ten8deder6t5en6deren8z7endgram8m7endhrei6b5e6cos6t5er6werein8s7trewel6t5en6dwin8n7ersczge8rin8nu",
        11: "_er8stritt__spiege8leiach8träume_lei8t7er8scpapie8r7endpiegelei8en",
        12: "ach8träumen_7sprechende_",
        13: "_er8stritten_"
    },
    charSubstitution: {
        'ſ': 's'
    },
    patternChars: "_abcdefghijklmnopqrstuvwxyzßäöü",
    patternArrayLength: 257332,
    valueStoreLength: 56157
};

Hyphenator.config({
	useCSS3hyphenation : true
});

Hyphenator.run();