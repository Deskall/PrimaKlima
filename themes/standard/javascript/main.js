/*!
 * jQuery JavaScript Library v3.2.1
 * https://jquery.com/
 *
 * Includes Sizzle.js
 * https://sizzlejs.com/
 *
 * Copyright JS Foundation and other contributors
 * Released under the MIT license
 * https://jquery.org/license
 *
 * Date: 2017-03-20T18:59Z
 */
( function( global, factory ) {

	"use strict";

	if ( typeof module === "object" && typeof module.exports === "object" ) {

		// For CommonJS and CommonJS-like environments where a proper `window`
		// is present, execute the factory and get jQuery.
		// For environments that do not have a `window` with a `document`
		// (such as Node.js), expose a factory as module.exports.
		// This accentuates the need for the creation of a real `window`.
		// e.g. var jQuery = require("jquery")(window);
		// See ticket #14549 for more info.
		module.exports = global.document ?
			factory( global, true ) :
			function( w ) {
				if ( !w.document ) {
					throw new Error( "jQuery requires a window with a document" );
				}
				return factory( w );
			};
	} else {
		factory( global );
	}

// Pass this if window is not defined yet
} )( typeof window !== "undefined" ? window : this, function( window, noGlobal ) {

// Edge <= 12 - 13+, Firefox <=18 - 45+, IE 10 - 11, Safari 5.1 - 9+, iOS 6 - 9.1
// throw exceptions when non-strict code (e.g., ASP.NET 4.5) accesses strict mode
// arguments.callee.caller (trac-13335). But as of jQuery 3.0 (2016), strict mode should be common
// enough that all such attempts are guarded in a try block.
"use strict";

var arr = [];

var document = window.document;

var getProto = Object.getPrototypeOf;

var slice = arr.slice;

var concat = arr.concat;

var push = arr.push;

var indexOf = arr.indexOf;

var class2type = {};

var toString = class2type.toString;

var hasOwn = class2type.hasOwnProperty;

var fnToString = hasOwn.toString;

var ObjectFunctionString = fnToString.call( Object );

var support = {};



	function DOMEval( code, doc ) {
		doc = doc || document;

		var script = doc.createElement( "script" );

		script.text = code;
		doc.head.appendChild( script ).parentNode.removeChild( script );
	}
/* global Symbol */
// Defining this global in .eslintrc.json would create a danger of using the global
// unguarded in another place, it seems safer to define global only for this module



var
	version = "3.2.1",

	// Define a local copy of jQuery
	jQuery = function( selector, context ) {

		// The jQuery object is actually just the init constructor 'enhanced'
		// Need init if jQuery is called (just allow error to be thrown if not included)
		return new jQuery.fn.init( selector, context );
	},

	// Support: Android <=4.0 only
	// Make sure we trim BOM and NBSP
	rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g,

	// Matches dashed string for camelizing
	rmsPrefix = /^-ms-/,
	rdashAlpha = /-([a-z])/g,

	// Used by jQuery.camelCase as callback to replace()
	fcamelCase = function( all, letter ) {
		return letter.toUpperCase();
	};

jQuery.fn = jQuery.prototype = {

	// The current version of jQuery being used
	jquery: version,

	constructor: jQuery,

	// The default length of a jQuery object is 0
	length: 0,

	toArray: function() {
		return slice.call( this );
	},

	// Get the Nth element in the matched element set OR
	// Get the whole matched element set as a clean array
	get: function( num ) {

		// Return all the elements in a clean array
		if ( num == null ) {
			return slice.call( this );
		}

		// Return just the one element from the set
		return num < 0 ? this[ num + this.length ] : this[ num ];
	},

	// Take an array of elements and push it onto the stack
	// (returning the new matched element set)
	pushStack: function( elems ) {

		// Build a new jQuery matched element set
		var ret = jQuery.merge( this.constructor(), elems );

		// Add the old object onto the stack (as a reference)
		ret.prevObject = this;

		// Return the newly-formed element set
		return ret;
	},

	// Execute a callback for every element in the matched set.
	each: function( callback ) {
		return jQuery.each( this, callback );
	},

	map: function( callback ) {
		return this.pushStack( jQuery.map( this, function( elem, i ) {
			return callback.call( elem, i, elem );
		} ) );
	},

	slice: function() {
		return this.pushStack( slice.apply( this, arguments ) );
	},

	first: function() {
		return this.eq( 0 );
	},

	last: function() {
		return this.eq( -1 );
	},

	eq: function( i ) {
		var len = this.length,
			j = +i + ( i < 0 ? len : 0 );
		return this.pushStack( j >= 0 && j < len ? [ this[ j ] ] : [] );
	},

	end: function() {
		return this.prevObject || this.constructor();
	},

	// For internal use only.
	// Behaves like an Array's method, not like a jQuery method.
	push: push,
	sort: arr.sort,
	splice: arr.splice
};

jQuery.extend = jQuery.fn.extend = function() {
	var options, name, src, copy, copyIsArray, clone,
		target = arguments[ 0 ] || {},
		i = 1,
		length = arguments.length,
		deep = false;

	// Handle a deep copy situation
	if ( typeof target === "boolean" ) {
		deep = target;

		// Skip the boolean and the target
		target = arguments[ i ] || {};
		i++;
	}

	// Handle case when target is a string or something (possible in deep copy)
	if ( typeof target !== "object" && !jQuery.isFunction( target ) ) {
		target = {};
	}

	// Extend jQuery itself if only one argument is passed
	if ( i === length ) {
		target = this;
		i--;
	}

	for ( ; i < length; i++ ) {

		// Only deal with non-null/undefined values
		if ( ( options = arguments[ i ] ) != null ) {

			// Extend the base object
			for ( name in options ) {
				src = target[ name ];
				copy = options[ name ];

				// Prevent never-ending loop
				if ( target === copy ) {
					continue;
				}

				// Recurse if we're merging plain objects or arrays
				if ( deep && copy && ( jQuery.isPlainObject( copy ) ||
					( copyIsArray = Array.isArray( copy ) ) ) ) {

					if ( copyIsArray ) {
						copyIsArray = false;
						clone = src && Array.isArray( src ) ? src : [];

					} else {
						clone = src && jQuery.isPlainObject( src ) ? src : {};
					}

					// Never move original objects, clone them
					target[ name ] = jQuery.extend( deep, clone, copy );

				// Don't bring in undefined values
				} else if ( copy !== undefined ) {
					target[ name ] = copy;
				}
			}
		}
	}

	// Return the modified object
	return target;
};

jQuery.extend( {

	// Unique for each copy of jQuery on the page
	expando: "jQuery" + ( version + Math.random() ).replace( /\D/g, "" ),

	// Assume jQuery is ready without the ready module
	isReady: true,

	error: function( msg ) {
		throw new Error( msg );
	},

	noop: function() {},

	isFunction: function( obj ) {
		return jQuery.type( obj ) === "function";
	},

	isWindow: function( obj ) {
		return obj != null && obj === obj.window;
	},

	isNumeric: function( obj ) {

		// As of jQuery 3.0, isNumeric is limited to
		// strings and numbers (primitives or objects)
		// that can be coerced to finite numbers (gh-2662)
		var type = jQuery.type( obj );
		return ( type === "number" || type === "string" ) &&

			// parseFloat NaNs numeric-cast false positives ("")
			// ...but misinterprets leading-number strings, particularly hex literals ("0x...")
			// subtraction forces infinities to NaN
			!isNaN( obj - parseFloat( obj ) );
	},

	isPlainObject: function( obj ) {
		var proto, Ctor;

		// Detect obvious negatives
		// Use toString instead of jQuery.type to catch host objects
		if ( !obj || toString.call( obj ) !== "[object Object]" ) {
			return false;
		}

		proto = getProto( obj );

		// Objects with no prototype (e.g., `Object.create( null )`) are plain
		if ( !proto ) {
			return true;
		}

		// Objects with prototype are plain iff they were constructed by a global Object function
		Ctor = hasOwn.call( proto, "constructor" ) && proto.constructor;
		return typeof Ctor === "function" && fnToString.call( Ctor ) === ObjectFunctionString;
	},

	isEmptyObject: function( obj ) {

		/* eslint-disable no-unused-vars */
		// See https://github.com/eslint/eslint/issues/6125
		var name;

		for ( name in obj ) {
			return false;
		}
		return true;
	},

	type: function( obj ) {
		if ( obj == null ) {
			return obj + "";
		}

		// Support: Android <=2.3 only (functionish RegExp)
		return typeof obj === "object" || typeof obj === "function" ?
			class2type[ toString.call( obj ) ] || "object" :
			typeof obj;
	},

	// Evaluates a script in a global context
	globalEval: function( code ) {
		DOMEval( code );
	},

	// Convert dashed to camelCase; used by the css and data modules
	// Support: IE <=9 - 11, Edge 12 - 13
	// Microsoft forgot to hump their vendor prefix (#9572)
	camelCase: function( string ) {
		return string.replace( rmsPrefix, "ms-" ).replace( rdashAlpha, fcamelCase );
	},

	each: function( obj, callback ) {
		var length, i = 0;

		if ( isArrayLike( obj ) ) {
			length = obj.length;
			for ( ; i < length; i++ ) {
				if ( callback.call( obj[ i ], i, obj[ i ] ) === false ) {
					break;
				}
			}
		} else {
			for ( i in obj ) {
				if ( callback.call( obj[ i ], i, obj[ i ] ) === false ) {
					break;
				}
			}
		}

		return obj;
	},

	// Support: Android <=4.0 only
	trim: function( text ) {
		return text == null ?
			"" :
			( text + "" ).replace( rtrim, "" );
	},

	// results is for internal usage only
	makeArray: function( arr, results ) {
		var ret = results || [];

		if ( arr != null ) {
			if ( isArrayLike( Object( arr ) ) ) {
				jQuery.merge( ret,
					typeof arr === "string" ?
					[ arr ] : arr
				);
			} else {
				push.call( ret, arr );
			}
		}

		return ret;
	},

	inArray: function( elem, arr, i ) {
		return arr == null ? -1 : indexOf.call( arr, elem, i );
	},

	// Support: Android <=4.0 only, PhantomJS 1 only
	// push.apply(_, arraylike) throws on ancient WebKit
	merge: function( first, second ) {
		var len = +second.length,
			j = 0,
			i = first.length;

		for ( ; j < len; j++ ) {
			first[ i++ ] = second[ j ];
		}

		first.length = i;

		return first;
	},

	grep: function( elems, callback, invert ) {
		var callbackInverse,
			matches = [],
			i = 0,
			length = elems.length,
			callbackExpect = !invert;

		// Go through the array, only saving the items
		// that pass the validator function
		for ( ; i < length; i++ ) {
			callbackInverse = !callback( elems[ i ], i );
			if ( callbackInverse !== callbackExpect ) {
				matches.push( elems[ i ] );
			}
		}

		return matches;
	},

	// arg is for internal usage only
	map: function( elems, callback, arg ) {
		var length, value,
			i = 0,
			ret = [];

		// Go through the array, translating each of the items to their new values
		if ( isArrayLike( elems ) ) {
			length = elems.length;
			for ( ; i < length; i++ ) {
				value = callback( elems[ i ], i, arg );

				if ( value != null ) {
					ret.push( value );
				}
			}

		// Go through every key on the object,
		} else {
			for ( i in elems ) {
				value = callback( elems[ i ], i, arg );

				if ( value != null ) {
					ret.push( value );
				}
			}
		}

		// Flatten any nested arrays
		return concat.apply( [], ret );
	},

	// A global GUID counter for objects
	guid: 1,

	// Bind a function to a context, optionally partially applying any
	// arguments.
	proxy: function( fn, context ) {
		var tmp, args, proxy;

		if ( typeof context === "string" ) {
			tmp = fn[ context ];
			context = fn;
			fn = tmp;
		}

		// Quick check to determine if target is callable, in the spec
		// this throws a TypeError, but we will just return undefined.
		if ( !jQuery.isFunction( fn ) ) {
			return undefined;
		}

		// Simulated bind
		args = slice.call( arguments, 2 );
		proxy = function() {
			return fn.apply( context || this, args.concat( slice.call( arguments ) ) );
		};

		// Set the guid of unique handler to the same of original handler, so it can be removed
		proxy.guid = fn.guid = fn.guid || jQuery.guid++;

		return proxy;
	},

	now: Date.now,

	// jQuery.support is not used in Core but other projects attach their
	// properties to it so it needs to exist.
	support: support
} );

if ( typeof Symbol === "function" ) {
	jQuery.fn[ Symbol.iterator ] = arr[ Symbol.iterator ];
}

// Populate the class2type map
jQuery.each( "Boolean Number String Function Array Date RegExp Object Error Symbol".split( " " ),
function( i, name ) {
	class2type[ "[object " + name + "]" ] = name.toLowerCase();
} );

function isArrayLike( obj ) {

	// Support: real iOS 8.2 only (not reproducible in simulator)
	// `in` check used to prevent JIT error (gh-2145)
	// hasOwn isn't used here due to false negatives
	// regarding Nodelist length in IE
	var length = !!obj && "length" in obj && obj.length,
		type = jQuery.type( obj );

	if ( type === "function" || jQuery.isWindow( obj ) ) {
		return false;
	}

	return type === "array" || length === 0 ||
		typeof length === "number" && length > 0 && ( length - 1 ) in obj;
}
var Sizzle =
/*!
 * Sizzle CSS Selector Engine v2.3.3
 * https://sizzlejs.com/
 *
 * Copyright jQuery Foundation and other contributors
 * Released under the MIT license
 * http://jquery.org/license
 *
 * Date: 2016-08-08
 */
(function( window ) {

var i,
	support,
	Expr,
	getText,
	isXML,
	tokenize,
	compile,
	select,
	outermostContext,
	sortInput,
	hasDuplicate,

	// Local document vars
	setDocument,
	document,
	docElem,
	documentIsHTML,
	rbuggyQSA,
	rbuggyMatches,
	matches,
	contains,

	// Instance-specific data
	expando = "sizzle" + 1 * new Date(),
	preferredDoc = window.document,
	dirruns = 0,
	done = 0,
	classCache = createCache(),
	tokenCache = createCache(),
	compilerCache = createCache(),
	sortOrder = function( a, b ) {
		if ( a === b ) {
			hasDuplicate = true;
		}
		return 0;
	},

	// Instance methods
	hasOwn = ({}).hasOwnProperty,
	arr = [],
	pop = arr.pop,
	push_native = arr.push,
	push = arr.push,
	slice = arr.slice,
	// Use a stripped-down indexOf as it's faster than native
	// https://jsperf.com/thor-indexof-vs-for/5
	indexOf = function( list, elem ) {
		var i = 0,
			len = list.length;
		for ( ; i < len; i++ ) {
			if ( list[i] === elem ) {
				return i;
			}
		}
		return -1;
	},

	booleans = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",

	// Regular expressions

	// http://www.w3.org/TR/css3-selectors/#whitespace
	whitespace = "[\\x20\\t\\r\\n\\f]",

	// http://www.w3.org/TR/CSS21/syndata.html#value-def-identifier
	identifier = "(?:\\\\.|[\\w-]|[^\0-\\xa0])+",

	// Attribute selectors: http://www.w3.org/TR/selectors/#attribute-selectors
	attributes = "\\[" + whitespace + "*(" + identifier + ")(?:" + whitespace +
		// Operator (capture 2)
		"*([*^$|!~]?=)" + whitespace +
		// "Attribute values must be CSS identifiers [capture 5] or strings [capture 3 or capture 4]"
		"*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" + identifier + "))|)" + whitespace +
		"*\\]",

	pseudos = ":(" + identifier + ")(?:\\((" +
		// To reduce the number of selectors needing tokenize in the preFilter, prefer arguments:
		// 1. quoted (capture 3; capture 4 or capture 5)
		"('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|" +
		// 2. simple (capture 6)
		"((?:\\\\.|[^\\\\()[\\]]|" + attributes + ")*)|" +
		// 3. anything else (capture 2)
		".*" +
		")\\)|)",

	// Leading and non-escaped trailing whitespace, capturing some non-whitespace characters preceding the latter
	rwhitespace = new RegExp( whitespace + "+", "g" ),
	rtrim = new RegExp( "^" + whitespace + "+|((?:^|[^\\\\])(?:\\\\.)*)" + whitespace + "+$", "g" ),

	rcomma = new RegExp( "^" + whitespace + "*," + whitespace + "*" ),
	rcombinators = new RegExp( "^" + whitespace + "*([>+~]|" + whitespace + ")" + whitespace + "*" ),

	rattributeQuotes = new RegExp( "=" + whitespace + "*([^\\]'\"]*?)" + whitespace + "*\\]", "g" ),

	rpseudo = new RegExp( pseudos ),
	ridentifier = new RegExp( "^" + identifier + "$" ),

	matchExpr = {
		"ID": new RegExp( "^#(" + identifier + ")" ),
		"CLASS": new RegExp( "^\\.(" + identifier + ")" ),
		"TAG": new RegExp( "^(" + identifier + "|[*])" ),
		"ATTR": new RegExp( "^" + attributes ),
		"PSEUDO": new RegExp( "^" + pseudos ),
		"CHILD": new RegExp( "^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\(" + whitespace +
			"*(even|odd|(([+-]|)(\\d*)n|)" + whitespace + "*(?:([+-]|)" + whitespace +
			"*(\\d+)|))" + whitespace + "*\\)|)", "i" ),
		"bool": new RegExp( "^(?:" + booleans + ")$", "i" ),
		// For use in libraries implementing .is()
		// We use this for POS matching in `select`
		"needsContext": new RegExp( "^" + whitespace + "*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\(" +
			whitespace + "*((?:-\\d)?\\d*)" + whitespace + "*\\)|)(?=[^-]|$)", "i" )
	},

	rinputs = /^(?:input|select|textarea|button)$/i,
	rheader = /^h\d$/i,

	rnative = /^[^{]+\{\s*\[native \w/,

	// Easily-parseable/retrievable ID or TAG or CLASS selectors
	rquickExpr = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,

	rsibling = /[+~]/,

	// CSS escapes
	// http://www.w3.org/TR/CSS21/syndata.html#escaped-characters
	runescape = new RegExp( "\\\\([\\da-f]{1,6}" + whitespace + "?|(" + whitespace + ")|.)", "ig" ),
	funescape = function( _, escaped, escapedWhitespace ) {
		var high = "0x" + escaped - 0x10000;
		// NaN means non-codepoint
		// Support: Firefox<24
		// Workaround erroneous numeric interpretation of +"0x"
		return high !== high || escapedWhitespace ?
			escaped :
			high < 0 ?
				// BMP codepoint
				String.fromCharCode( high + 0x10000 ) :
				// Supplemental Plane codepoint (surrogate pair)
				String.fromCharCode( high >> 10 | 0xD800, high & 0x3FF | 0xDC00 );
	},

	// CSS string/identifier serialization
	// https://drafts.csswg.org/cssom/#common-serializing-idioms
	rcssescape = /([\0-\x1f\x7f]|^-?\d)|^-$|[^\0-\x1f\x7f-\uFFFF\w-]/g,
	fcssescape = function( ch, asCodePoint ) {
		if ( asCodePoint ) {

			// U+0000 NULL becomes U+FFFD REPLACEMENT CHARACTER
			if ( ch === "\0" ) {
				return "\uFFFD";
			}

			// Control characters and (dependent upon position) numbers get escaped as code points
			return ch.slice( 0, -1 ) + "\\" + ch.charCodeAt( ch.length - 1 ).toString( 16 ) + " ";
		}

		// Other potentially-special ASCII characters get backslash-escaped
		return "\\" + ch;
	},

	// Used for iframes
	// See setDocument()
	// Removing the function wrapper causes a "Permission Denied"
	// error in IE
	unloadHandler = function() {
		setDocument();
	},

	disabledAncestor = addCombinator(
		function( elem ) {
			return elem.disabled === true && ("form" in elem || "label" in elem);
		},
		{ dir: "parentNode", next: "legend" }
	);

// Optimize for push.apply( _, NodeList )
try {
	push.apply(
		(arr = slice.call( preferredDoc.childNodes )),
		preferredDoc.childNodes
	);
	// Support: Android<4.0
	// Detect silently failing push.apply
	arr[ preferredDoc.childNodes.length ].nodeType;
} catch ( e ) {
	push = { apply: arr.length ?

		// Leverage slice if possible
		function( target, els ) {
			push_native.apply( target, slice.call(els) );
		} :

		// Support: IE<9
		// Otherwise append directly
		function( target, els ) {
			var j = target.length,
				i = 0;
			// Can't trust NodeList.length
			while ( (target[j++] = els[i++]) ) {}
			target.length = j - 1;
		}
	};
}

function Sizzle( selector, context, results, seed ) {
	var m, i, elem, nid, match, groups, newSelector,
		newContext = context && context.ownerDocument,

		// nodeType defaults to 9, since context defaults to document
		nodeType = context ? context.nodeType : 9;

	results = results || [];

	// Return early from calls with invalid selector or context
	if ( typeof selector !== "string" || !selector ||
		nodeType !== 1 && nodeType !== 9 && nodeType !== 11 ) {

		return results;
	}

	// Try to shortcut find operations (as opposed to filters) in HTML documents
	if ( !seed ) {

		if ( ( context ? context.ownerDocument || context : preferredDoc ) !== document ) {
			setDocument( context );
		}
		context = context || document;

		if ( documentIsHTML ) {

			// If the selector is sufficiently simple, try using a "get*By*" DOM method
			// (excepting DocumentFragment context, where the methods don't exist)
			if ( nodeType !== 11 && (match = rquickExpr.exec( selector )) ) {

				// ID selector
				if ( (m = match[1]) ) {

					// Document context
					if ( nodeType === 9 ) {
						if ( (elem = context.getElementById( m )) ) {

							// Support: IE, Opera, Webkit
							// TODO: identify versions
							// getElementById can match elements by name instead of ID
							if ( elem.id === m ) {
								results.push( elem );
								return results;
							}
						} else {
							return results;
						}

					// Element context
					} else {

						// Support: IE, Opera, Webkit
						// TODO: identify versions
						// getElementById can match elements by name instead of ID
						if ( newContext && (elem = newContext.getElementById( m )) &&
							contains( context, elem ) &&
							elem.id === m ) {

							results.push( elem );
							return results;
						}
					}

				// Type selector
				} else if ( match[2] ) {
					push.apply( results, context.getElementsByTagName( selector ) );
					return results;

				// Class selector
				} else if ( (m = match[3]) && support.getElementsByClassName &&
					context.getElementsByClassName ) {

					push.apply( results, context.getElementsByClassName( m ) );
					return results;
				}
			}

			// Take advantage of querySelectorAll
			if ( support.qsa &&
				!compilerCache[ selector + " " ] &&
				(!rbuggyQSA || !rbuggyQSA.test( selector )) ) {

				if ( nodeType !== 1 ) {
					newContext = context;
					newSelector = selector;

				// qSA looks outside Element context, which is not what we want
				// Thanks to Andrew Dupont for this workaround technique
				// Support: IE <=8
				// Exclude object elements
				} else if ( context.nodeName.toLowerCase() !== "object" ) {

					// Capture the context ID, setting it first if necessary
					if ( (nid = context.getAttribute( "id" )) ) {
						nid = nid.replace( rcssescape, fcssescape );
					} else {
						context.setAttribute( "id", (nid = expando) );
					}

					// Prefix every selector in the list
					groups = tokenize( selector );
					i = groups.length;
					while ( i-- ) {
						groups[i] = "#" + nid + " " + toSelector( groups[i] );
					}
					newSelector = groups.join( "," );

					// Expand context for sibling selectors
					newContext = rsibling.test( selector ) && testContext( context.parentNode ) ||
						context;
				}

				if ( newSelector ) {
					try {
						push.apply( results,
							newContext.querySelectorAll( newSelector )
						);
						return results;
					} catch ( qsaError ) {
					} finally {
						if ( nid === expando ) {
							context.removeAttribute( "id" );
						}
					}
				}
			}
		}
	}

	// All others
	return select( selector.replace( rtrim, "$1" ), context, results, seed );
}

/**
 * Create key-value caches of limited size
 * @returns {function(string, object)} Returns the Object data after storing it on itself with
 *	property name the (space-suffixed) string and (if the cache is larger than Expr.cacheLength)
 *	deleting the oldest entry
 */
function createCache() {
	var keys = [];

	function cache( key, value ) {
		// Use (key + " ") to avoid collision with native prototype properties (see Issue #157)
		if ( keys.push( key + " " ) > Expr.cacheLength ) {
			// Only keep the most recent entries
			delete cache[ keys.shift() ];
		}
		return (cache[ key + " " ] = value);
	}
	return cache;
}

/**
 * Mark a function for special use by Sizzle
 * @param {Function} fn The function to mark
 */
function markFunction( fn ) {
	fn[ expando ] = true;
	return fn;
}

/**
 * Support testing using an element
 * @param {Function} fn Passed the created element and returns a boolean result
 */
function assert( fn ) {
	var el = document.createElement("fieldset");

	try {
		return !!fn( el );
	} catch (e) {
		return false;
	} finally {
		// Remove from its parent by default
		if ( el.parentNode ) {
			el.parentNode.removeChild( el );
		}
		// release memory in IE
		el = null;
	}
}

/**
 * Adds the same handler for all of the specified attrs
 * @param {String} attrs Pipe-separated list of attributes
 * @param {Function} handler The method that will be applied
 */
function addHandle( attrs, handler ) {
	var arr = attrs.split("|"),
		i = arr.length;

	while ( i-- ) {
		Expr.attrHandle[ arr[i] ] = handler;
	}
}

/**
 * Checks document order of two siblings
 * @param {Element} a
 * @param {Element} b
 * @returns {Number} Returns less than 0 if a precedes b, greater than 0 if a follows b
 */
function siblingCheck( a, b ) {
	var cur = b && a,
		diff = cur && a.nodeType === 1 && b.nodeType === 1 &&
			a.sourceIndex - b.sourceIndex;

	// Use IE sourceIndex if available on both nodes
	if ( diff ) {
		return diff;
	}

	// Check if b follows a
	if ( cur ) {
		while ( (cur = cur.nextSibling) ) {
			if ( cur === b ) {
				return -1;
			}
		}
	}

	return a ? 1 : -1;
}

/**
 * Returns a function to use in pseudos for input types
 * @param {String} type
 */
function createInputPseudo( type ) {
	return function( elem ) {
		var name = elem.nodeName.toLowerCase();
		return name === "input" && elem.type === type;
	};
}

/**
 * Returns a function to use in pseudos for buttons
 * @param {String} type
 */
function createButtonPseudo( type ) {
	return function( elem ) {
		var name = elem.nodeName.toLowerCase();
		return (name === "input" || name === "button") && elem.type === type;
	};
}

/**
 * Returns a function to use in pseudos for :enabled/:disabled
 * @param {Boolean} disabled true for :disabled; false for :enabled
 */
function createDisabledPseudo( disabled ) {

	// Known :disabled false positives: fieldset[disabled] > legend:nth-of-type(n+2) :can-disable
	return function( elem ) {

		// Only certain elements can match :enabled or :disabled
		// https://html.spec.whatwg.org/multipage/scripting.html#selector-enabled
		// https://html.spec.whatwg.org/multipage/scripting.html#selector-disabled
		if ( "form" in elem ) {

			// Check for inherited disabledness on relevant non-disabled elements:
			// * listed form-associated elements in a disabled fieldset
			//   https://html.spec.whatwg.org/multipage/forms.html#category-listed
			//   https://html.spec.whatwg.org/multipage/forms.html#concept-fe-disabled
			// * option elements in a disabled optgroup
			//   https://html.spec.whatwg.org/multipage/forms.html#concept-option-disabled
			// All such elements have a "form" property.
			if ( elem.parentNode && elem.disabled === false ) {

				// Option elements defer to a parent optgroup if present
				if ( "label" in elem ) {
					if ( "label" in elem.parentNode ) {
						return elem.parentNode.disabled === disabled;
					} else {
						return elem.disabled === disabled;
					}
				}

				// Support: IE 6 - 11
				// Use the isDisabled shortcut property to check for disabled fieldset ancestors
				return elem.isDisabled === disabled ||

					// Where there is no isDisabled, check manually
					/* jshint -W018 */
					elem.isDisabled !== !disabled &&
						disabledAncestor( elem ) === disabled;
			}

			return elem.disabled === disabled;

		// Try to winnow out elements that can't be disabled before trusting the disabled property.
		// Some victims get caught in our net (label, legend, menu, track), but it shouldn't
		// even exist on them, let alone have a boolean value.
		} else if ( "label" in elem ) {
			return elem.disabled === disabled;
		}

		// Remaining elements are neither :enabled nor :disabled
		return false;
	};
}

/**
 * Returns a function to use in pseudos for positionals
 * @param {Function} fn
 */
function createPositionalPseudo( fn ) {
	return markFunction(function( argument ) {
		argument = +argument;
		return markFunction(function( seed, matches ) {
			var j,
				matchIndexes = fn( [], seed.length, argument ),
				i = matchIndexes.length;

			// Match elements found at the specified indexes
			while ( i-- ) {
				if ( seed[ (j = matchIndexes[i]) ] ) {
					seed[j] = !(matches[j] = seed[j]);
				}
			}
		});
	});
}

/**
 * Checks a node for validity as a Sizzle context
 * @param {Element|Object=} context
 * @returns {Element|Object|Boolean} The input node if acceptable, otherwise a falsy value
 */
function testContext( context ) {
	return context && typeof context.getElementsByTagName !== "undefined" && context;
}

// Expose support vars for convenience
support = Sizzle.support = {};

/**
 * Detects XML nodes
 * @param {Element|Object} elem An element or a document
 * @returns {Boolean} True iff elem is a non-HTML XML node
 */
isXML = Sizzle.isXML = function( elem ) {
	// documentElement is verified for cases where it doesn't yet exist
	// (such as loading iframes in IE - #4833)
	var documentElement = elem && (elem.ownerDocument || elem).documentElement;
	return documentElement ? documentElement.nodeName !== "HTML" : false;
};

/**
 * Sets document-related variables once based on the current document
 * @param {Element|Object} [doc] An element or document object to use to set the document
 * @returns {Object} Returns the current document
 */
setDocument = Sizzle.setDocument = function( node ) {
	var hasCompare, subWindow,
		doc = node ? node.ownerDocument || node : preferredDoc;

	// Return early if doc is invalid or already selected
	if ( doc === document || doc.nodeType !== 9 || !doc.documentElement ) {
		return document;
	}

	// Update global variables
	document = doc;
	docElem = document.documentElement;
	documentIsHTML = !isXML( document );

	// Support: IE 9-11, Edge
	// Accessing iframe documents after unload throws "permission denied" errors (jQuery #13936)
	if ( preferredDoc !== document &&
		(subWindow = document.defaultView) && subWindow.top !== subWindow ) {

		// Support: IE 11, Edge
		if ( subWindow.addEventListener ) {
			subWindow.addEventListener( "unload", unloadHandler, false );

		// Support: IE 9 - 10 only
		} else if ( subWindow.attachEvent ) {
			subWindow.attachEvent( "onunload", unloadHandler );
		}
	}

	/* Attributes
	---------------------------------------------------------------------- */

	// Support: IE<8
	// Verify that getAttribute really returns attributes and not properties
	// (excepting IE8 booleans)
	support.attributes = assert(function( el ) {
		el.className = "i";
		return !el.getAttribute("className");
	});

	/* getElement(s)By*
	---------------------------------------------------------------------- */

	// Check if getElementsByTagName("*") returns only elements
	support.getElementsByTagName = assert(function( el ) {
		el.appendChild( document.createComment("") );
		return !el.getElementsByTagName("*").length;
	});

	// Support: IE<9
	support.getElementsByClassName = rnative.test( document.getElementsByClassName );

	// Support: IE<10
	// Check if getElementById returns elements by name
	// The broken getElementById methods don't pick up programmatically-set names,
	// so use a roundabout getElementsByName test
	support.getById = assert(function( el ) {
		docElem.appendChild( el ).id = expando;
		return !document.getElementsByName || !document.getElementsByName( expando ).length;
	});

	// ID filter and find
	if ( support.getById ) {
		Expr.filter["ID"] = function( id ) {
			var attrId = id.replace( runescape, funescape );
			return function( elem ) {
				return elem.getAttribute("id") === attrId;
			};
		};
		Expr.find["ID"] = function( id, context ) {
			if ( typeof context.getElementById !== "undefined" && documentIsHTML ) {
				var elem = context.getElementById( id );
				return elem ? [ elem ] : [];
			}
		};
	} else {
		Expr.filter["ID"] =  function( id ) {
			var attrId = id.replace( runescape, funescape );
			return function( elem ) {
				var node = typeof elem.getAttributeNode !== "undefined" &&
					elem.getAttributeNode("id");
				return node && node.value === attrId;
			};
		};

		// Support: IE 6 - 7 only
		// getElementById is not reliable as a find shortcut
		Expr.find["ID"] = function( id, context ) {
			if ( typeof context.getElementById !== "undefined" && documentIsHTML ) {
				var node, i, elems,
					elem = context.getElementById( id );

				if ( elem ) {

					// Verify the id attribute
					node = elem.getAttributeNode("id");
					if ( node && node.value === id ) {
						return [ elem ];
					}

					// Fall back on getElementsByName
					elems = context.getElementsByName( id );
					i = 0;
					while ( (elem = elems[i++]) ) {
						node = elem.getAttributeNode("id");
						if ( node && node.value === id ) {
							return [ elem ];
						}
					}
				}

				return [];
			}
		};
	}

	// Tag
	Expr.find["TAG"] = support.getElementsByTagName ?
		function( tag, context ) {
			if ( typeof context.getElementsByTagName !== "undefined" ) {
				return context.getElementsByTagName( tag );

			// DocumentFragment nodes don't have gEBTN
			} else if ( support.qsa ) {
				return context.querySelectorAll( tag );
			}
		} :

		function( tag, context ) {
			var elem,
				tmp = [],
				i = 0,
				// By happy coincidence, a (broken) gEBTN appears on DocumentFragment nodes too
				results = context.getElementsByTagName( tag );

			// Filter out possible comments
			if ( tag === "*" ) {
				while ( (elem = results[i++]) ) {
					if ( elem.nodeType === 1 ) {
						tmp.push( elem );
					}
				}

				return tmp;
			}
			return results;
		};

	// Class
	Expr.find["CLASS"] = support.getElementsByClassName && function( className, context ) {
		if ( typeof context.getElementsByClassName !== "undefined" && documentIsHTML ) {
			return context.getElementsByClassName( className );
		}
	};

	/* QSA/matchesSelector
	---------------------------------------------------------------------- */

	// QSA and matchesSelector support

	// matchesSelector(:active) reports false when true (IE9/Opera 11.5)
	rbuggyMatches = [];

	// qSa(:focus) reports false when true (Chrome 21)
	// We allow this because of a bug in IE8/9 that throws an error
	// whenever `document.activeElement` is accessed on an iframe
	// So, we allow :focus to pass through QSA all the time to avoid the IE error
	// See https://bugs.jquery.com/ticket/13378
	rbuggyQSA = [];

	if ( (support.qsa = rnative.test( document.querySelectorAll )) ) {
		// Build QSA regex
		// Regex strategy adopted from Diego Perini
		assert(function( el ) {
			// Select is set to empty string on purpose
			// This is to test IE's treatment of not explicitly
			// setting a boolean content attribute,
			// since its presence should be enough
			// https://bugs.jquery.com/ticket/12359
			docElem.appendChild( el ).innerHTML = "<a id='" + expando + "'></a>" +
				"<select id='" + expando + "-\r\\' msallowcapture=''>" +
				"<option selected=''></option></select>";

			// Support: IE8, Opera 11-12.16
			// Nothing should be selected when empty strings follow ^= or $= or *=
			// The test attribute must be unknown in Opera but "safe" for WinRT
			// https://msdn.microsoft.com/en-us/library/ie/hh465388.aspx#attribute_section
			if ( el.querySelectorAll("[msallowcapture^='']").length ) {
				rbuggyQSA.push( "[*^$]=" + whitespace + "*(?:''|\"\")" );
			}

			// Support: IE8
			// Boolean attributes and "value" are not treated correctly
			if ( !el.querySelectorAll("[selected]").length ) {
				rbuggyQSA.push( "\\[" + whitespace + "*(?:value|" + booleans + ")" );
			}

			// Support: Chrome<29, Android<4.4, Safari<7.0+, iOS<7.0+, PhantomJS<1.9.8+
			if ( !el.querySelectorAll( "[id~=" + expando + "-]" ).length ) {
				rbuggyQSA.push("~=");
			}

			// Webkit/Opera - :checked should return selected option elements
			// http://www.w3.org/TR/2011/REC-css3-selectors-20110929/#checked
			// IE8 throws error here and will not see later tests
			if ( !el.querySelectorAll(":checked").length ) {
				rbuggyQSA.push(":checked");
			}

			// Support: Safari 8+, iOS 8+
			// https://bugs.webkit.org/show_bug.cgi?id=136851
			// In-page `selector#id sibling-combinator selector` fails
			if ( !el.querySelectorAll( "a#" + expando + "+*" ).length ) {
				rbuggyQSA.push(".#.+[+~]");
			}
		});

		assert(function( el ) {
			el.innerHTML = "<a href='' disabled='disabled'></a>" +
				"<select disabled='disabled'><option/></select>";

			// Support: Windows 8 Native Apps
			// The type and name attributes are restricted during .innerHTML assignment
			var input = document.createElement("input");
			input.setAttribute( "type", "hidden" );
			el.appendChild( input ).setAttribute( "name", "D" );

			// Support: IE8
			// Enforce case-sensitivity of name attribute
			if ( el.querySelectorAll("[name=d]").length ) {
				rbuggyQSA.push( "name" + whitespace + "*[*^$|!~]?=" );
			}

			// FF 3.5 - :enabled/:disabled and hidden elements (hidden elements are still enabled)
			// IE8 throws error here and will not see later tests
			if ( el.querySelectorAll(":enabled").length !== 2 ) {
				rbuggyQSA.push( ":enabled", ":disabled" );
			}

			// Support: IE9-11+
			// IE's :disabled selector does not pick up the children of disabled fieldsets
			docElem.appendChild( el ).disabled = true;
			if ( el.querySelectorAll(":disabled").length !== 2 ) {
				rbuggyQSA.push( ":enabled", ":disabled" );
			}

			// Opera 10-11 does not throw on post-comma invalid pseudos
			el.querySelectorAll("*,:x");
			rbuggyQSA.push(",.*:");
		});
	}

	if ( (support.matchesSelector = rnative.test( (matches = docElem.matches ||
		docElem.webkitMatchesSelector ||
		docElem.mozMatchesSelector ||
		docElem.oMatchesSelector ||
		docElem.msMatchesSelector) )) ) {

		assert(function( el ) {
			// Check to see if it's possible to do matchesSelector
			// on a disconnected node (IE 9)
			support.disconnectedMatch = matches.call( el, "*" );

			// This should fail with an exception
			// Gecko does not error, returns false instead
			matches.call( el, "[s!='']:x" );
			rbuggyMatches.push( "!=", pseudos );
		});
	}

	rbuggyQSA = rbuggyQSA.length && new RegExp( rbuggyQSA.join("|") );
	rbuggyMatches = rbuggyMatches.length && new RegExp( rbuggyMatches.join("|") );

	/* Contains
	---------------------------------------------------------------------- */
	hasCompare = rnative.test( docElem.compareDocumentPosition );

	// Element contains another
	// Purposefully self-exclusive
	// As in, an element does not contain itself
	contains = hasCompare || rnative.test( docElem.contains ) ?
		function( a, b ) {
			var adown = a.nodeType === 9 ? a.documentElement : a,
				bup = b && b.parentNode;
			return a === bup || !!( bup && bup.nodeType === 1 && (
				adown.contains ?
					adown.contains( bup ) :
					a.compareDocumentPosition && a.compareDocumentPosition( bup ) & 16
			));
		} :
		function( a, b ) {
			if ( b ) {
				while ( (b = b.parentNode) ) {
					if ( b === a ) {
						return true;
					}
				}
			}
			return false;
		};

	/* Sorting
	---------------------------------------------------------------------- */

	// Document order sorting
	sortOrder = hasCompare ?
	function( a, b ) {

		// Flag for duplicate removal
		if ( a === b ) {
			hasDuplicate = true;
			return 0;
		}

		// Sort on method existence if only one input has compareDocumentPosition
		var compare = !a.compareDocumentPosition - !b.compareDocumentPosition;
		if ( compare ) {
			return compare;
		}

		// Calculate position if both inputs belong to the same document
		compare = ( a.ownerDocument || a ) === ( b.ownerDocument || b ) ?
			a.compareDocumentPosition( b ) :

			// Otherwise we know they are disconnected
			1;

		// Disconnected nodes
		if ( compare & 1 ||
			(!support.sortDetached && b.compareDocumentPosition( a ) === compare) ) {

			// Choose the first element that is related to our preferred document
			if ( a === document || a.ownerDocument === preferredDoc && contains(preferredDoc, a) ) {
				return -1;
			}
			if ( b === document || b.ownerDocument === preferredDoc && contains(preferredDoc, b) ) {
				return 1;
			}

			// Maintain original order
			return sortInput ?
				( indexOf( sortInput, a ) - indexOf( sortInput, b ) ) :
				0;
		}

		return compare & 4 ? -1 : 1;
	} :
	function( a, b ) {
		// Exit early if the nodes are identical
		if ( a === b ) {
			hasDuplicate = true;
			return 0;
		}

		var cur,
			i = 0,
			aup = a.parentNode,
			bup = b.parentNode,
			ap = [ a ],
			bp = [ b ];

		// Parentless nodes are either documents or disconnected
		if ( !aup || !bup ) {
			return a === document ? -1 :
				b === document ? 1 :
				aup ? -1 :
				bup ? 1 :
				sortInput ?
				( indexOf( sortInput, a ) - indexOf( sortInput, b ) ) :
				0;

		// If the nodes are siblings, we can do a quick check
		} else if ( aup === bup ) {
			return siblingCheck( a, b );
		}

		// Otherwise we need full lists of their ancestors for comparison
		cur = a;
		while ( (cur = cur.parentNode) ) {
			ap.unshift( cur );
		}
		cur = b;
		while ( (cur = cur.parentNode) ) {
			bp.unshift( cur );
		}

		// Walk down the tree looking for a discrepancy
		while ( ap[i] === bp[i] ) {
			i++;
		}

		return i ?
			// Do a sibling check if the nodes have a common ancestor
			siblingCheck( ap[i], bp[i] ) :

			// Otherwise nodes in our document sort first
			ap[i] === preferredDoc ? -1 :
			bp[i] === preferredDoc ? 1 :
			0;
	};

	return document;
};

Sizzle.matches = function( expr, elements ) {
	return Sizzle( expr, null, null, elements );
};

Sizzle.matchesSelector = function( elem, expr ) {
	// Set document vars if needed
	if ( ( elem.ownerDocument || elem ) !== document ) {
		setDocument( elem );
	}

	// Make sure that attribute selectors are quoted
	expr = expr.replace( rattributeQuotes, "='$1']" );

	if ( support.matchesSelector && documentIsHTML &&
		!compilerCache[ expr + " " ] &&
		( !rbuggyMatches || !rbuggyMatches.test( expr ) ) &&
		( !rbuggyQSA     || !rbuggyQSA.test( expr ) ) ) {

		try {
			var ret = matches.call( elem, expr );

			// IE 9's matchesSelector returns false on disconnected nodes
			if ( ret || support.disconnectedMatch ||
					// As well, disconnected nodes are said to be in a document
					// fragment in IE 9
					elem.document && elem.document.nodeType !== 11 ) {
				return ret;
			}
		} catch (e) {}
	}

	return Sizzle( expr, document, null, [ elem ] ).length > 0;
};

Sizzle.contains = function( context, elem ) {
	// Set document vars if needed
	if ( ( context.ownerDocument || context ) !== document ) {
		setDocument( context );
	}
	return contains( context, elem );
};

Sizzle.attr = function( elem, name ) {
	// Set document vars if needed
	if ( ( elem.ownerDocument || elem ) !== document ) {
		setDocument( elem );
	}

	var fn = Expr.attrHandle[ name.toLowerCase() ],
		// Don't get fooled by Object.prototype properties (jQuery #13807)
		val = fn && hasOwn.call( Expr.attrHandle, name.toLowerCase() ) ?
			fn( elem, name, !documentIsHTML ) :
			undefined;

	return val !== undefined ?
		val :
		support.attributes || !documentIsHTML ?
			elem.getAttribute( name ) :
			(val = elem.getAttributeNode(name)) && val.specified ?
				val.value :
				null;
};

Sizzle.escape = function( sel ) {
	return (sel + "").replace( rcssescape, fcssescape );
};

Sizzle.error = function( msg ) {
	throw new Error( "Syntax error, unrecognized expression: " + msg );
};

/**
 * Document sorting and removing duplicates
 * @param {ArrayLike} results
 */
Sizzle.uniqueSort = function( results ) {
	var elem,
		duplicates = [],
		j = 0,
		i = 0;

	// Unless we *know* we can detect duplicates, assume their presence
	hasDuplicate = !support.detectDuplicates;
	sortInput = !support.sortStable && results.slice( 0 );
	results.sort( sortOrder );

	if ( hasDuplicate ) {
		while ( (elem = results[i++]) ) {
			if ( elem === results[ i ] ) {
				j = duplicates.push( i );
			}
		}
		while ( j-- ) {
			results.splice( duplicates[ j ], 1 );
		}
	}

	// Clear input after sorting to release objects
	// See https://github.com/jquery/sizzle/pull/225
	sortInput = null;

	return results;
};

/**
 * Utility function for retrieving the text value of an array of DOM nodes
 * @param {Array|Element} elem
 */
getText = Sizzle.getText = function( elem ) {
	var node,
		ret = "",
		i = 0,
		nodeType = elem.nodeType;

	if ( !nodeType ) {
		// If no nodeType, this is expected to be an array
		while ( (node = elem[i++]) ) {
			// Do not traverse comment nodes
			ret += getText( node );
		}
	} else if ( nodeType === 1 || nodeType === 9 || nodeType === 11 ) {
		// Use textContent for elements
		// innerText usage removed for consistency of new lines (jQuery #11153)
		if ( typeof elem.textContent === "string" ) {
			return elem.textContent;
		} else {
			// Traverse its children
			for ( elem = elem.firstChild; elem; elem = elem.nextSibling ) {
				ret += getText( elem );
			}
		}
	} else if ( nodeType === 3 || nodeType === 4 ) {
		return elem.nodeValue;
	}
	// Do not include comment or processing instruction nodes

	return ret;
};

Expr = Sizzle.selectors = {

	// Can be adjusted by the user
	cacheLength: 50,

	createPseudo: markFunction,

	match: matchExpr,

	attrHandle: {},

	find: {},

	relative: {
		">": { dir: "parentNode", first: true },
		" ": { dir: "parentNode" },
		"+": { dir: "previousSibling", first: true },
		"~": { dir: "previousSibling" }
	},

	preFilter: {
		"ATTR": function( match ) {
			match[1] = match[1].replace( runescape, funescape );

			// Move the given value to match[3] whether quoted or unquoted
			match[3] = ( match[3] || match[4] || match[5] || "" ).replace( runescape, funescape );

			if ( match[2] === "~=" ) {
				match[3] = " " + match[3] + " ";
			}

			return match.slice( 0, 4 );
		},

		"CHILD": function( match ) {
			/* matches from matchExpr["CHILD"]
				1 type (only|nth|...)
				2 what (child|of-type)
				3 argument (even|odd|\d*|\d*n([+-]\d+)?|...)
				4 xn-component of xn+y argument ([+-]?\d*n|)
				5 sign of xn-component
				6 x of xn-component
				7 sign of y-component
				8 y of y-component
			*/
			match[1] = match[1].toLowerCase();

			if ( match[1].slice( 0, 3 ) === "nth" ) {
				// nth-* requires argument
				if ( !match[3] ) {
					Sizzle.error( match[0] );
				}

				// numeric x and y parameters for Expr.filter.CHILD
				// remember that false/true cast respectively to 0/1
				match[4] = +( match[4] ? match[5] + (match[6] || 1) : 2 * ( match[3] === "even" || match[3] === "odd" ) );
				match[5] = +( ( match[7] + match[8] ) || match[3] === "odd" );

			// other types prohibit arguments
			} else if ( match[3] ) {
				Sizzle.error( match[0] );
			}

			return match;
		},

		"PSEUDO": function( match ) {
			var excess,
				unquoted = !match[6] && match[2];

			if ( matchExpr["CHILD"].test( match[0] ) ) {
				return null;
			}

			// Accept quoted arguments as-is
			if ( match[3] ) {
				match[2] = match[4] || match[5] || "";

			// Strip excess characters from unquoted arguments
			} else if ( unquoted && rpseudo.test( unquoted ) &&
				// Get excess from tokenize (recursively)
				(excess = tokenize( unquoted, true )) &&
				// advance to the next closing parenthesis
				(excess = unquoted.indexOf( ")", unquoted.length - excess ) - unquoted.length) ) {

				// excess is a negative index
				match[0] = match[0].slice( 0, excess );
				match[2] = unquoted.slice( 0, excess );
			}

			// Return only captures needed by the pseudo filter method (type and argument)
			return match.slice( 0, 3 );
		}
	},

	filter: {

		"TAG": function( nodeNameSelector ) {
			var nodeName = nodeNameSelector.replace( runescape, funescape ).toLowerCase();
			return nodeNameSelector === "*" ?
				function() { return true; } :
				function( elem ) {
					return elem.nodeName && elem.nodeName.toLowerCase() === nodeName;
				};
		},

		"CLASS": function( className ) {
			var pattern = classCache[ className + " " ];

			return pattern ||
				(pattern = new RegExp( "(^|" + whitespace + ")" + className + "(" + whitespace + "|$)" )) &&
				classCache( className, function( elem ) {
					return pattern.test( typeof elem.className === "string" && elem.className || typeof elem.getAttribute !== "undefined" && elem.getAttribute("class") || "" );
				});
		},

		"ATTR": function( name, operator, check ) {
			return function( elem ) {
				var result = Sizzle.attr( elem, name );

				if ( result == null ) {
					return operator === "!=";
				}
				if ( !operator ) {
					return true;
				}

				result += "";

				return operator === "=" ? result === check :
					operator === "!=" ? result !== check :
					operator === "^=" ? check && result.indexOf( check ) === 0 :
					operator === "*=" ? check && result.indexOf( check ) > -1 :
					operator === "$=" ? check && result.slice( -check.length ) === check :
					operator === "~=" ? ( " " + result.replace( rwhitespace, " " ) + " " ).indexOf( check ) > -1 :
					operator === "|=" ? result === check || result.slice( 0, check.length + 1 ) === check + "-" :
					false;
			};
		},

		"CHILD": function( type, what, argument, first, last ) {
			var simple = type.slice( 0, 3 ) !== "nth",
				forward = type.slice( -4 ) !== "last",
				ofType = what === "of-type";

			return first === 1 && last === 0 ?

				// Shortcut for :nth-*(n)
				function( elem ) {
					return !!elem.parentNode;
				} :

				function( elem, context, xml ) {
					var cache, uniqueCache, outerCache, node, nodeIndex, start,
						dir = simple !== forward ? "nextSibling" : "previousSibling",
						parent = elem.parentNode,
						name = ofType && elem.nodeName.toLowerCase(),
						useCache = !xml && !ofType,
						diff = false;

					if ( parent ) {

						// :(first|last|only)-(child|of-type)
						if ( simple ) {
							while ( dir ) {
								node = elem;
								while ( (node = node[ dir ]) ) {
									if ( ofType ?
										node.nodeName.toLowerCase() === name :
										node.nodeType === 1 ) {

										return false;
									}
								}
								// Reverse direction for :only-* (if we haven't yet done so)
								start = dir = type === "only" && !start && "nextSibling";
							}
							return true;
						}

						start = [ forward ? parent.firstChild : parent.lastChild ];

						// non-xml :nth-child(...) stores cache data on `parent`
						if ( forward && useCache ) {

							// Seek `elem` from a previously-cached index

							// ...in a gzip-friendly way
							node = parent;
							outerCache = node[ expando ] || (node[ expando ] = {});

							// Support: IE <9 only
							// Defend against cloned attroperties (jQuery gh-1709)
							uniqueCache = outerCache[ node.uniqueID ] ||
								(outerCache[ node.uniqueID ] = {});

							cache = uniqueCache[ type ] || [];
							nodeIndex = cache[ 0 ] === dirruns && cache[ 1 ];
							diff = nodeIndex && cache[ 2 ];
							node = nodeIndex && parent.childNodes[ nodeIndex ];

							while ( (node = ++nodeIndex && node && node[ dir ] ||

								// Fallback to seeking `elem` from the start
								(diff = nodeIndex = 0) || start.pop()) ) {

								// When found, cache indexes on `parent` and break
								if ( node.nodeType === 1 && ++diff && node === elem ) {
									uniqueCache[ type ] = [ dirruns, nodeIndex, diff ];
									break;
								}
							}

						} else {
							// Use previously-cached element index if available
							if ( useCache ) {
								// ...in a gzip-friendly way
								node = elem;
								outerCache = node[ expando ] || (node[ expando ] = {});

								// Support: IE <9 only
								// Defend against cloned attroperties (jQuery gh-1709)
								uniqueCache = outerCache[ node.uniqueID ] ||
									(outerCache[ node.uniqueID ] = {});

								cache = uniqueCache[ type ] || [];
								nodeIndex = cache[ 0 ] === dirruns && cache[ 1 ];
								diff = nodeIndex;
							}

							// xml :nth-child(...)
							// or :nth-last-child(...) or :nth(-last)?-of-type(...)
							if ( diff === false ) {
								// Use the same loop as above to seek `elem` from the start
								while ( (node = ++nodeIndex && node && node[ dir ] ||
									(diff = nodeIndex = 0) || start.pop()) ) {

									if ( ( ofType ?
										node.nodeName.toLowerCase() === name :
										node.nodeType === 1 ) &&
										++diff ) {

										// Cache the index of each encountered element
										if ( useCache ) {
											outerCache = node[ expando ] || (node[ expando ] = {});

											// Support: IE <9 only
											// Defend against cloned attroperties (jQuery gh-1709)
											uniqueCache = outerCache[ node.uniqueID ] ||
												(outerCache[ node.uniqueID ] = {});

											uniqueCache[ type ] = [ dirruns, diff ];
										}

										if ( node === elem ) {
											break;
										}
									}
								}
							}
						}

						// Incorporate the offset, then check against cycle size
						diff -= last;
						return diff === first || ( diff % first === 0 && diff / first >= 0 );
					}
				};
		},

		"PSEUDO": function( pseudo, argument ) {
			// pseudo-class names are case-insensitive
			// http://www.w3.org/TR/selectors/#pseudo-classes
			// Prioritize by case sensitivity in case custom pseudos are added with uppercase letters
			// Remember that setFilters inherits from pseudos
			var args,
				fn = Expr.pseudos[ pseudo ] || Expr.setFilters[ pseudo.toLowerCase() ] ||
					Sizzle.error( "unsupported pseudo: " + pseudo );

			// The user may use createPseudo to indicate that
			// arguments are needed to create the filter function
			// just as Sizzle does
			if ( fn[ expando ] ) {
				return fn( argument );
			}

			// But maintain support for old signatures
			if ( fn.length > 1 ) {
				args = [ pseudo, pseudo, "", argument ];
				return Expr.setFilters.hasOwnProperty( pseudo.toLowerCase() ) ?
					markFunction(function( seed, matches ) {
						var idx,
							matched = fn( seed, argument ),
							i = matched.length;
						while ( i-- ) {
							idx = indexOf( seed, matched[i] );
							seed[ idx ] = !( matches[ idx ] = matched[i] );
						}
					}) :
					function( elem ) {
						return fn( elem, 0, args );
					};
			}

			return fn;
		}
	},

	pseudos: {
		// Potentially complex pseudos
		"not": markFunction(function( selector ) {
			// Trim the selector passed to compile
			// to avoid treating leading and trailing
			// spaces as combinators
			var input = [],
				results = [],
				matcher = compile( selector.replace( rtrim, "$1" ) );

			return matcher[ expando ] ?
				markFunction(function( seed, matches, context, xml ) {
					var elem,
						unmatched = matcher( seed, null, xml, [] ),
						i = seed.length;

					// Match elements unmatched by `matcher`
					while ( i-- ) {
						if ( (elem = unmatched[i]) ) {
							seed[i] = !(matches[i] = elem);
						}
					}
				}) :
				function( elem, context, xml ) {
					input[0] = elem;
					matcher( input, null, xml, results );
					// Don't keep the element (issue #299)
					input[0] = null;
					return !results.pop();
				};
		}),

		"has": markFunction(function( selector ) {
			return function( elem ) {
				return Sizzle( selector, elem ).length > 0;
			};
		}),

		"contains": markFunction(function( text ) {
			text = text.replace( runescape, funescape );
			return function( elem ) {
				return ( elem.textContent || elem.innerText || getText( elem ) ).indexOf( text ) > -1;
			};
		}),

		// "Whether an element is represented by a :lang() selector
		// is based solely on the element's language value
		// being equal to the identifier C,
		// or beginning with the identifier C immediately followed by "-".
		// The matching of C against the element's language value is performed case-insensitively.
		// The identifier C does not have to be a valid language name."
		// http://www.w3.org/TR/selectors/#lang-pseudo
		"lang": markFunction( function( lang ) {
			// lang value must be a valid identifier
			if ( !ridentifier.test(lang || "") ) {
				Sizzle.error( "unsupported lang: " + lang );
			}
			lang = lang.replace( runescape, funescape ).toLowerCase();
			return function( elem ) {
				var elemLang;
				do {
					if ( (elemLang = documentIsHTML ?
						elem.lang :
						elem.getAttribute("xml:lang") || elem.getAttribute("lang")) ) {

						elemLang = elemLang.toLowerCase();
						return elemLang === lang || elemLang.indexOf( lang + "-" ) === 0;
					}
				} while ( (elem = elem.parentNode) && elem.nodeType === 1 );
				return false;
			};
		}),

		// Miscellaneous
		"target": function( elem ) {
			var hash = window.location && window.location.hash;
			return hash && hash.slice( 1 ) === elem.id;
		},

		"root": function( elem ) {
			return elem === docElem;
		},

		"focus": function( elem ) {
			return elem === document.activeElement && (!document.hasFocus || document.hasFocus()) && !!(elem.type || elem.href || ~elem.tabIndex);
		},

		// Boolean properties
		"enabled": createDisabledPseudo( false ),
		"disabled": createDisabledPseudo( true ),

		"checked": function( elem ) {
			// In CSS3, :checked should return both checked and selected elements
			// http://www.w3.org/TR/2011/REC-css3-selectors-20110929/#checked
			var nodeName = elem.nodeName.toLowerCase();
			return (nodeName === "input" && !!elem.checked) || (nodeName === "option" && !!elem.selected);
		},

		"selected": function( elem ) {
			// Accessing this property makes selected-by-default
			// options in Safari work properly
			if ( elem.parentNode ) {
				elem.parentNode.selectedIndex;
			}

			return elem.selected === true;
		},

		// Contents
		"empty": function( elem ) {
			// http://www.w3.org/TR/selectors/#empty-pseudo
			// :empty is negated by element (1) or content nodes (text: 3; cdata: 4; entity ref: 5),
			//   but not by others (comment: 8; processing instruction: 7; etc.)
			// nodeType < 6 works because attributes (2) do not appear as children
			for ( elem = elem.firstChild; elem; elem = elem.nextSibling ) {
				if ( elem.nodeType < 6 ) {
					return false;
				}
			}
			return true;
		},

		"parent": function( elem ) {
			return !Expr.pseudos["empty"]( elem );
		},

		// Element/input types
		"header": function( elem ) {
			return rheader.test( elem.nodeName );
		},

		"input": function( elem ) {
			return rinputs.test( elem.nodeName );
		},

		"button": function( elem ) {
			var name = elem.nodeName.toLowerCase();
			return name === "input" && elem.type === "button" || name === "button";
		},

		"text": function( elem ) {
			var attr;
			return elem.nodeName.toLowerCase() === "input" &&
				elem.type === "text" &&

				// Support: IE<8
				// New HTML5 attribute values (e.g., "search") appear with elem.type === "text"
				( (attr = elem.getAttribute("type")) == null || attr.toLowerCase() === "text" );
		},

		// Position-in-collection
		"first": createPositionalPseudo(function() {
			return [ 0 ];
		}),

		"last": createPositionalPseudo(function( matchIndexes, length ) {
			return [ length - 1 ];
		}),

		"eq": createPositionalPseudo(function( matchIndexes, length, argument ) {
			return [ argument < 0 ? argument + length : argument ];
		}),

		"even": createPositionalPseudo(function( matchIndexes, length ) {
			var i = 0;
			for ( ; i < length; i += 2 ) {
				matchIndexes.push( i );
			}
			return matchIndexes;
		}),

		"odd": createPositionalPseudo(function( matchIndexes, length ) {
			var i = 1;
			for ( ; i < length; i += 2 ) {
				matchIndexes.push( i );
			}
			return matchIndexes;
		}),

		"lt": createPositionalPseudo(function( matchIndexes, length, argument ) {
			var i = argument < 0 ? argument + length : argument;
			for ( ; --i >= 0; ) {
				matchIndexes.push( i );
			}
			return matchIndexes;
		}),

		"gt": createPositionalPseudo(function( matchIndexes, length, argument ) {
			var i = argument < 0 ? argument + length : argument;
			for ( ; ++i < length; ) {
				matchIndexes.push( i );
			}
			return matchIndexes;
		})
	}
};

Expr.pseudos["nth"] = Expr.pseudos["eq"];

// Add button/input type pseudos
for ( i in { radio: true, checkbox: true, file: true, password: true, image: true } ) {
	Expr.pseudos[ i ] = createInputPseudo( i );
}
for ( i in { submit: true, reset: true } ) {
	Expr.pseudos[ i ] = createButtonPseudo( i );
}

// Easy API for creating new setFilters
function setFilters() {}
setFilters.prototype = Expr.filters = Expr.pseudos;
Expr.setFilters = new setFilters();

tokenize = Sizzle.tokenize = function( selector, parseOnly ) {
	var matched, match, tokens, type,
		soFar, groups, preFilters,
		cached = tokenCache[ selector + " " ];

	if ( cached ) {
		return parseOnly ? 0 : cached.slice( 0 );
	}

	soFar = selector;
	groups = [];
	preFilters = Expr.preFilter;

	while ( soFar ) {

		// Comma and first run
		if ( !matched || (match = rcomma.exec( soFar )) ) {
			if ( match ) {
				// Don't consume trailing commas as valid
				soFar = soFar.slice( match[0].length ) || soFar;
			}
			groups.push( (tokens = []) );
		}

		matched = false;

		// Combinators
		if ( (match = rcombinators.exec( soFar )) ) {
			matched = match.shift();
			tokens.push({
				value: matched,
				// Cast descendant combinators to space
				type: match[0].replace( rtrim, " " )
			});
			soFar = soFar.slice( matched.length );
		}

		// Filters
		for ( type in Expr.filter ) {
			if ( (match = matchExpr[ type ].exec( soFar )) && (!preFilters[ type ] ||
				(match = preFilters[ type ]( match ))) ) {
				matched = match.shift();
				tokens.push({
					value: matched,
					type: type,
					matches: match
				});
				soFar = soFar.slice( matched.length );
			}
		}

		if ( !matched ) {
			break;
		}
	}

	// Return the length of the invalid excess
	// if we're just parsing
	// Otherwise, throw an error or return tokens
	return parseOnly ?
		soFar.length :
		soFar ?
			Sizzle.error( selector ) :
			// Cache the tokens
			tokenCache( selector, groups ).slice( 0 );
};

function toSelector( tokens ) {
	var i = 0,
		len = tokens.length,
		selector = "";
	for ( ; i < len; i++ ) {
		selector += tokens[i].value;
	}
	return selector;
}

function addCombinator( matcher, combinator, base ) {
	var dir = combinator.dir,
		skip = combinator.next,
		key = skip || dir,
		checkNonElements = base && key === "parentNode",
		doneName = done++;

	return combinator.first ?
		// Check against closest ancestor/preceding element
		function( elem, context, xml ) {
			while ( (elem = elem[ dir ]) ) {
				if ( elem.nodeType === 1 || checkNonElements ) {
					return matcher( elem, context, xml );
				}
			}
			return false;
		} :

		// Check against all ancestor/preceding elements
		function( elem, context, xml ) {
			var oldCache, uniqueCache, outerCache,
				newCache = [ dirruns, doneName ];

			// We can't set arbitrary data on XML nodes, so they don't benefit from combinator caching
			if ( xml ) {
				while ( (elem = elem[ dir ]) ) {
					if ( elem.nodeType === 1 || checkNonElements ) {
						if ( matcher( elem, context, xml ) ) {
							return true;
						}
					}
				}
			} else {
				while ( (elem = elem[ dir ]) ) {
					if ( elem.nodeType === 1 || checkNonElements ) {
						outerCache = elem[ expando ] || (elem[ expando ] = {});

						// Support: IE <9 only
						// Defend against cloned attroperties (jQuery gh-1709)
						uniqueCache = outerCache[ elem.uniqueID ] || (outerCache[ elem.uniqueID ] = {});

						if ( skip && skip === elem.nodeName.toLowerCase() ) {
							elem = elem[ dir ] || elem;
						} else if ( (oldCache = uniqueCache[ key ]) &&
							oldCache[ 0 ] === dirruns && oldCache[ 1 ] === doneName ) {

							// Assign to newCache so results back-propagate to previous elements
							return (newCache[ 2 ] = oldCache[ 2 ]);
						} else {
							// Reuse newcache so results back-propagate to previous elements
							uniqueCache[ key ] = newCache;

							// A match means we're done; a fail means we have to keep checking
							if ( (newCache[ 2 ] = matcher( elem, context, xml )) ) {
								return true;
							}
						}
					}
				}
			}
			return false;
		};
}

function elementMatcher( matchers ) {
	return matchers.length > 1 ?
		function( elem, context, xml ) {
			var i = matchers.length;
			while ( i-- ) {
				if ( !matchers[i]( elem, context, xml ) ) {
					return false;
				}
			}
			return true;
		} :
		matchers[0];
}

function multipleContexts( selector, contexts, results ) {
	var i = 0,
		len = contexts.length;
	for ( ; i < len; i++ ) {
		Sizzle( selector, contexts[i], results );
	}
	return results;
}

function condense( unmatched, map, filter, context, xml ) {
	var elem,
		newUnmatched = [],
		i = 0,
		len = unmatched.length,
		mapped = map != null;

	for ( ; i < len; i++ ) {
		if ( (elem = unmatched[i]) ) {
			if ( !filter || filter( elem, context, xml ) ) {
				newUnmatched.push( elem );
				if ( mapped ) {
					map.push( i );
				}
			}
		}
	}

	return newUnmatched;
}

function setMatcher( preFilter, selector, matcher, postFilter, postFinder, postSelector ) {
	if ( postFilter && !postFilter[ expando ] ) {
		postFilter = setMatcher( postFilter );
	}
	if ( postFinder && !postFinder[ expando ] ) {
		postFinder = setMatcher( postFinder, postSelector );
	}
	return markFunction(function( seed, results, context, xml ) {
		var temp, i, elem,
			preMap = [],
			postMap = [],
			preexisting = results.length,

			// Get initial elements from seed or context
			elems = seed || multipleContexts( selector || "*", context.nodeType ? [ context ] : context, [] ),

			// Prefilter to get matcher input, preserving a map for seed-results synchronization
			matcherIn = preFilter && ( seed || !selector ) ?
				condense( elems, preMap, preFilter, context, xml ) :
				elems,

			matcherOut = matcher ?
				// If we have a postFinder, or filtered seed, or non-seed postFilter or preexisting results,
				postFinder || ( seed ? preFilter : preexisting || postFilter ) ?

					// ...intermediate processing is necessary
					[] :

					// ...otherwise use results directly
					results :
				matcherIn;

		// Find primary matches
		if ( matcher ) {
			matcher( matcherIn, matcherOut, context, xml );
		}

		// Apply postFilter
		if ( postFilter ) {
			temp = condense( matcherOut, postMap );
			postFilter( temp, [], context, xml );

			// Un-match failing elements by moving them back to matcherIn
			i = temp.length;
			while ( i-- ) {
				if ( (elem = temp[i]) ) {
					matcherOut[ postMap[i] ] = !(matcherIn[ postMap[i] ] = elem);
				}
			}
		}

		if ( seed ) {
			if ( postFinder || preFilter ) {
				if ( postFinder ) {
					// Get the final matcherOut by condensing this intermediate into postFinder contexts
					temp = [];
					i = matcherOut.length;
					while ( i-- ) {
						if ( (elem = matcherOut[i]) ) {
							// Restore matcherIn since elem is not yet a final match
							temp.push( (matcherIn[i] = elem) );
						}
					}
					postFinder( null, (matcherOut = []), temp, xml );
				}

				// Move matched elements from seed to results to keep them synchronized
				i = matcherOut.length;
				while ( i-- ) {
					if ( (elem = matcherOut[i]) &&
						(temp = postFinder ? indexOf( seed, elem ) : preMap[i]) > -1 ) {

						seed[temp] = !(results[temp] = elem);
					}
				}
			}

		// Add elements to results, through postFinder if defined
		} else {
			matcherOut = condense(
				matcherOut === results ?
					matcherOut.splice( preexisting, matcherOut.length ) :
					matcherOut
			);
			if ( postFinder ) {
				postFinder( null, results, matcherOut, xml );
			} else {
				push.apply( results, matcherOut );
			}
		}
	});
}

function matcherFromTokens( tokens ) {
	var checkContext, matcher, j,
		len = tokens.length,
		leadingRelative = Expr.relative[ tokens[0].type ],
		implicitRelative = leadingRelative || Expr.relative[" "],
		i = leadingRelative ? 1 : 0,

		// The foundational matcher ensures that elements are reachable from top-level context(s)
		matchContext = addCombinator( function( elem ) {
			return elem === checkContext;
		}, implicitRelative, true ),
		matchAnyContext = addCombinator( function( elem ) {
			return indexOf( checkContext, elem ) > -1;
		}, implicitRelative, true ),
		matchers = [ function( elem, context, xml ) {
			var ret = ( !leadingRelative && ( xml || context !== outermostContext ) ) || (
				(checkContext = context).nodeType ?
					matchContext( elem, context, xml ) :
					matchAnyContext( elem, context, xml ) );
			// Avoid hanging onto element (issue #299)
			checkContext = null;
			return ret;
		} ];

	for ( ; i < len; i++ ) {
		if ( (matcher = Expr.relative[ tokens[i].type ]) ) {
			matchers = [ addCombinator(elementMatcher( matchers ), matcher) ];
		} else {
			matcher = Expr.filter[ tokens[i].type ].apply( null, tokens[i].matches );

			// Return special upon seeing a positional matcher
			if ( matcher[ expando ] ) {
				// Find the next relative operator (if any) for proper handling
				j = ++i;
				for ( ; j < len; j++ ) {
					if ( Expr.relative[ tokens[j].type ] ) {
						break;
					}
				}
				return setMatcher(
					i > 1 && elementMatcher( matchers ),
					i > 1 && toSelector(
						// If the preceding token was a descendant combinator, insert an implicit any-element `*`
						tokens.slice( 0, i - 1 ).concat({ value: tokens[ i - 2 ].type === " " ? "*" : "" })
					).replace( rtrim, "$1" ),
					matcher,
					i < j && matcherFromTokens( tokens.slice( i, j ) ),
					j < len && matcherFromTokens( (tokens = tokens.slice( j )) ),
					j < len && toSelector( tokens )
				);
			}
			matchers.push( matcher );
		}
	}

	return elementMatcher( matchers );
}

function matcherFromGroupMatchers( elementMatchers, setMatchers ) {
	var bySet = setMatchers.length > 0,
		byElement = elementMatchers.length > 0,
		superMatcher = function( seed, context, xml, results, outermost ) {
			var elem, j, matcher,
				matchedCount = 0,
				i = "0",
				unmatched = seed && [],
				setMatched = [],
				contextBackup = outermostContext,
				// We must always have either seed elements or outermost context
				elems = seed || byElement && Expr.find["TAG"]( "*", outermost ),
				// Use integer dirruns iff this is the outermost matcher
				dirrunsUnique = (dirruns += contextBackup == null ? 1 : Math.random() || 0.1),
				len = elems.length;

			if ( outermost ) {
				outermostContext = context === document || context || outermost;
			}

			// Add elements passing elementMatchers directly to results
			// Support: IE<9, Safari
			// Tolerate NodeList properties (IE: "length"; Safari: <number>) matching elements by id
			for ( ; i !== len && (elem = elems[i]) != null; i++ ) {
				if ( byElement && elem ) {
					j = 0;
					if ( !context && elem.ownerDocument !== document ) {
						setDocument( elem );
						xml = !documentIsHTML;
					}
					while ( (matcher = elementMatchers[j++]) ) {
						if ( matcher( elem, context || document, xml) ) {
							results.push( elem );
							break;
						}
					}
					if ( outermost ) {
						dirruns = dirrunsUnique;
					}
				}

				// Track unmatched elements for set filters
				if ( bySet ) {
					// They will have gone through all possible matchers
					if ( (elem = !matcher && elem) ) {
						matchedCount--;
					}

					// Lengthen the array for every element, matched or not
					if ( seed ) {
						unmatched.push( elem );
					}
				}
			}

			// `i` is now the count of elements visited above, and adding it to `matchedCount`
			// makes the latter nonnegative.
			matchedCount += i;

			// Apply set filters to unmatched elements
			// NOTE: This can be skipped if there are no unmatched elements (i.e., `matchedCount`
			// equals `i`), unless we didn't visit _any_ elements in the above loop because we have
			// no element matchers and no seed.
			// Incrementing an initially-string "0" `i` allows `i` to remain a string only in that
			// case, which will result in a "00" `matchedCount` that differs from `i` but is also
			// numerically zero.
			if ( bySet && i !== matchedCount ) {
				j = 0;
				while ( (matcher = setMatchers[j++]) ) {
					matcher( unmatched, setMatched, context, xml );
				}

				if ( seed ) {
					// Reintegrate element matches to eliminate the need for sorting
					if ( matchedCount > 0 ) {
						while ( i-- ) {
							if ( !(unmatched[i] || setMatched[i]) ) {
								setMatched[i] = pop.call( results );
							}
						}
					}

					// Discard index placeholder values to get only actual matches
					setMatched = condense( setMatched );
				}

				// Add matches to results
				push.apply( results, setMatched );

				// Seedless set matches succeeding multiple successful matchers stipulate sorting
				if ( outermost && !seed && setMatched.length > 0 &&
					( matchedCount + setMatchers.length ) > 1 ) {

					Sizzle.uniqueSort( results );
				}
			}

			// Override manipulation of globals by nested matchers
			if ( outermost ) {
				dirruns = dirrunsUnique;
				outermostContext = contextBackup;
			}

			return unmatched;
		};

	return bySet ?
		markFunction( superMatcher ) :
		superMatcher;
}

compile = Sizzle.compile = function( selector, match /* Internal Use Only */ ) {
	var i,
		setMatchers = [],
		elementMatchers = [],
		cached = compilerCache[ selector + " " ];

	if ( !cached ) {
		// Generate a function of recursive functions that can be used to check each element
		if ( !match ) {
			match = tokenize( selector );
		}
		i = match.length;
		while ( i-- ) {
			cached = matcherFromTokens( match[i] );
			if ( cached[ expando ] ) {
				setMatchers.push( cached );
			} else {
				elementMatchers.push( cached );
			}
		}

		// Cache the compiled function
		cached = compilerCache( selector, matcherFromGroupMatchers( elementMatchers, setMatchers ) );

		// Save selector and tokenization
		cached.selector = selector;
	}
	return cached;
};

/**
 * A low-level selection function that works with Sizzle's compiled
 *  selector functions
 * @param {String|Function} selector A selector or a pre-compiled
 *  selector function built with Sizzle.compile
 * @param {Element} context
 * @param {Array} [results]
 * @param {Array} [seed] A set of elements to match against
 */
select = Sizzle.select = function( selector, context, results, seed ) {
	var i, tokens, token, type, find,
		compiled = typeof selector === "function" && selector,
		match = !seed && tokenize( (selector = compiled.selector || selector) );

	results = results || [];

	// Try to minimize operations if there is only one selector in the list and no seed
	// (the latter of which guarantees us context)
	if ( match.length === 1 ) {

		// Reduce context if the leading compound selector is an ID
		tokens = match[0] = match[0].slice( 0 );
		if ( tokens.length > 2 && (token = tokens[0]).type === "ID" &&
				context.nodeType === 9 && documentIsHTML && Expr.relative[ tokens[1].type ] ) {

			context = ( Expr.find["ID"]( token.matches[0].replace(runescape, funescape), context ) || [] )[0];
			if ( !context ) {
				return results;

			// Precompiled matchers will still verify ancestry, so step up a level
			} else if ( compiled ) {
				context = context.parentNode;
			}

			selector = selector.slice( tokens.shift().value.length );
		}

		// Fetch a seed set for right-to-left matching
		i = matchExpr["needsContext"].test( selector ) ? 0 : tokens.length;
		while ( i-- ) {
			token = tokens[i];

			// Abort if we hit a combinator
			if ( Expr.relative[ (type = token.type) ] ) {
				break;
			}
			if ( (find = Expr.find[ type ]) ) {
				// Search, expanding context for leading sibling combinators
				if ( (seed = find(
					token.matches[0].replace( runescape, funescape ),
					rsibling.test( tokens[0].type ) && testContext( context.parentNode ) || context
				)) ) {

					// If seed is empty or no tokens remain, we can return early
					tokens.splice( i, 1 );
					selector = seed.length && toSelector( tokens );
					if ( !selector ) {
						push.apply( results, seed );
						return results;
					}

					break;
				}
			}
		}
	}

	// Compile and execute a filtering function if one is not provided
	// Provide `match` to avoid retokenization if we modified the selector above
	( compiled || compile( selector, match ) )(
		seed,
		context,
		!documentIsHTML,
		results,
		!context || rsibling.test( selector ) && testContext( context.parentNode ) || context
	);
	return results;
};

// One-time assignments

// Sort stability
support.sortStable = expando.split("").sort( sortOrder ).join("") === expando;

// Support: Chrome 14-35+
// Always assume duplicates if they aren't passed to the comparison function
support.detectDuplicates = !!hasDuplicate;

// Initialize against the default document
setDocument();

// Support: Webkit<537.32 - Safari 6.0.3/Chrome 25 (fixed in Chrome 27)
// Detached nodes confoundingly follow *each other*
support.sortDetached = assert(function( el ) {
	// Should return 1, but returns 4 (following)
	return el.compareDocumentPosition( document.createElement("fieldset") ) & 1;
});

// Support: IE<8
// Prevent attribute/property "interpolation"
// https://msdn.microsoft.com/en-us/library/ms536429%28VS.85%29.aspx
if ( !assert(function( el ) {
	el.innerHTML = "<a href='#'></a>";
	return el.firstChild.getAttribute("href") === "#" ;
}) ) {
	addHandle( "type|href|height|width", function( elem, name, isXML ) {
		if ( !isXML ) {
			return elem.getAttribute( name, name.toLowerCase() === "type" ? 1 : 2 );
		}
	});
}

// Support: IE<9
// Use defaultValue in place of getAttribute("value")
if ( !support.attributes || !assert(function( el ) {
	el.innerHTML = "<input/>";
	el.firstChild.setAttribute( "value", "" );
	return el.firstChild.getAttribute( "value" ) === "";
}) ) {
	addHandle( "value", function( elem, name, isXML ) {
		if ( !isXML && elem.nodeName.toLowerCase() === "input" ) {
			return elem.defaultValue;
		}
	});
}

// Support: IE<9
// Use getAttributeNode to fetch booleans when getAttribute lies
if ( !assert(function( el ) {
	return el.getAttribute("disabled") == null;
}) ) {
	addHandle( booleans, function( elem, name, isXML ) {
		var val;
		if ( !isXML ) {
			return elem[ name ] === true ? name.toLowerCase() :
					(val = elem.getAttributeNode( name )) && val.specified ?
					val.value :
				null;
		}
	});
}

return Sizzle;

})( window );



jQuery.find = Sizzle;
jQuery.expr = Sizzle.selectors;

// Deprecated
jQuery.expr[ ":" ] = jQuery.expr.pseudos;
jQuery.uniqueSort = jQuery.unique = Sizzle.uniqueSort;
jQuery.text = Sizzle.getText;
jQuery.isXMLDoc = Sizzle.isXML;
jQuery.contains = Sizzle.contains;
jQuery.escapeSelector = Sizzle.escape;




var dir = function( elem, dir, until ) {
	var matched = [],
		truncate = until !== undefined;

	while ( ( elem = elem[ dir ] ) && elem.nodeType !== 9 ) {
		if ( elem.nodeType === 1 ) {
			if ( truncate && jQuery( elem ).is( until ) ) {
				break;
			}
			matched.push( elem );
		}
	}
	return matched;
};


var siblings = function( n, elem ) {
	var matched = [];

	for ( ; n; n = n.nextSibling ) {
		if ( n.nodeType === 1 && n !== elem ) {
			matched.push( n );
		}
	}

	return matched;
};


var rneedsContext = jQuery.expr.match.needsContext;



function nodeName( elem, name ) {

  return elem.nodeName && elem.nodeName.toLowerCase() === name.toLowerCase();

};
var rsingleTag = ( /^<([a-z][^\/\0>:\x20\t\r\n\f]*)[\x20\t\r\n\f]*\/?>(?:<\/\1>|)$/i );



var risSimple = /^.[^:#\[\.,]*$/;

// Implement the identical functionality for filter and not
function winnow( elements, qualifier, not ) {
	if ( jQuery.isFunction( qualifier ) ) {
		return jQuery.grep( elements, function( elem, i ) {
			return !!qualifier.call( elem, i, elem ) !== not;
		} );
	}

	// Single element
	if ( qualifier.nodeType ) {
		return jQuery.grep( elements, function( elem ) {
			return ( elem === qualifier ) !== not;
		} );
	}

	// Arraylike of elements (jQuery, arguments, Array)
	if ( typeof qualifier !== "string" ) {
		return jQuery.grep( elements, function( elem ) {
			return ( indexOf.call( qualifier, elem ) > -1 ) !== not;
		} );
	}

	// Simple selector that can be filtered directly, removing non-Elements
	if ( risSimple.test( qualifier ) ) {
		return jQuery.filter( qualifier, elements, not );
	}

	// Complex selector, compare the two sets, removing non-Elements
	qualifier = jQuery.filter( qualifier, elements );
	return jQuery.grep( elements, function( elem ) {
		return ( indexOf.call( qualifier, elem ) > -1 ) !== not && elem.nodeType === 1;
	} );
}

jQuery.filter = function( expr, elems, not ) {
	var elem = elems[ 0 ];

	if ( not ) {
		expr = ":not(" + expr + ")";
	}

	if ( elems.length === 1 && elem.nodeType === 1 ) {
		return jQuery.find.matchesSelector( elem, expr ) ? [ elem ] : [];
	}

	return jQuery.find.matches( expr, jQuery.grep( elems, function( elem ) {
		return elem.nodeType === 1;
	} ) );
};

jQuery.fn.extend( {
	find: function( selector ) {
		var i, ret,
			len = this.length,
			self = this;

		if ( typeof selector !== "string" ) {
			return this.pushStack( jQuery( selector ).filter( function() {
				for ( i = 0; i < len; i++ ) {
					if ( jQuery.contains( self[ i ], this ) ) {
						return true;
					}
				}
			} ) );
		}

		ret = this.pushStack( [] );

		for ( i = 0; i < len; i++ ) {
			jQuery.find( selector, self[ i ], ret );
		}

		return len > 1 ? jQuery.uniqueSort( ret ) : ret;
	},
	filter: function( selector ) {
		return this.pushStack( winnow( this, selector || [], false ) );
	},
	not: function( selector ) {
		return this.pushStack( winnow( this, selector || [], true ) );
	},
	is: function( selector ) {
		return !!winnow(
			this,

			// If this is a positional/relative selector, check membership in the returned set
			// so $("p:first").is("p:last") won't return true for a doc with two "p".
			typeof selector === "string" && rneedsContext.test( selector ) ?
				jQuery( selector ) :
				selector || [],
			false
		).length;
	}
} );


// Initialize a jQuery object


// A central reference to the root jQuery(document)
var rootjQuery,

	// A simple way to check for HTML strings
	// Prioritize #id over <tag> to avoid XSS via location.hash (#9521)
	// Strict HTML recognition (#11290: must start with <)
	// Shortcut simple #id case for speed
	rquickExpr = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]+))$/,

	init = jQuery.fn.init = function( selector, context, root ) {
		var match, elem;

		// HANDLE: $(""), $(null), $(undefined), $(false)
		if ( !selector ) {
			return this;
		}

		// Method init() accepts an alternate rootjQuery
		// so migrate can support jQuery.sub (gh-2101)
		root = root || rootjQuery;

		// Handle HTML strings
		if ( typeof selector === "string" ) {
			if ( selector[ 0 ] === "<" &&
				selector[ selector.length - 1 ] === ">" &&
				selector.length >= 3 ) {

				// Assume that strings that start and end with <> are HTML and skip the regex check
				match = [ null, selector, null ];

			} else {
				match = rquickExpr.exec( selector );
			}

			// Match html or make sure no context is specified for #id
			if ( match && ( match[ 1 ] || !context ) ) {

				// HANDLE: $(html) -> $(array)
				if ( match[ 1 ] ) {
					context = context instanceof jQuery ? context[ 0 ] : context;

					// Option to run scripts is true for back-compat
					// Intentionally let the error be thrown if parseHTML is not present
					jQuery.merge( this, jQuery.parseHTML(
						match[ 1 ],
						context && context.nodeType ? context.ownerDocument || context : document,
						true
					) );

					// HANDLE: $(html, props)
					if ( rsingleTag.test( match[ 1 ] ) && jQuery.isPlainObject( context ) ) {
						for ( match in context ) {

							// Properties of context are called as methods if possible
							if ( jQuery.isFunction( this[ match ] ) ) {
								this[ match ]( context[ match ] );

							// ...and otherwise set as attributes
							} else {
								this.attr( match, context[ match ] );
							}
						}
					}

					return this;

				// HANDLE: $(#id)
				} else {
					elem = document.getElementById( match[ 2 ] );

					if ( elem ) {

						// Inject the element directly into the jQuery object
						this[ 0 ] = elem;
						this.length = 1;
					}
					return this;
				}

			// HANDLE: $(expr, $(...))
			} else if ( !context || context.jquery ) {
				return ( context || root ).find( selector );

			// HANDLE: $(expr, context)
			// (which is just equivalent to: $(context).find(expr)
			} else {
				return this.constructor( context ).find( selector );
			}

		// HANDLE: $(DOMElement)
		} else if ( selector.nodeType ) {
			this[ 0 ] = selector;
			this.length = 1;
			return this;

		// HANDLE: $(function)
		// Shortcut for document ready
		} else if ( jQuery.isFunction( selector ) ) {
			return root.ready !== undefined ?
				root.ready( selector ) :

				// Execute immediately if ready is not present
				selector( jQuery );
		}

		return jQuery.makeArray( selector, this );
	};

// Give the init function the jQuery prototype for later instantiation
init.prototype = jQuery.fn;

// Initialize central reference
rootjQuery = jQuery( document );


var rparentsprev = /^(?:parents|prev(?:Until|All))/,

	// Methods guaranteed to produce a unique set when starting from a unique set
	guaranteedUnique = {
		children: true,
		contents: true,
		next: true,
		prev: true
	};

jQuery.fn.extend( {
	has: function( target ) {
		var targets = jQuery( target, this ),
			l = targets.length;

		return this.filter( function() {
			var i = 0;
			for ( ; i < l; i++ ) {
				if ( jQuery.contains( this, targets[ i ] ) ) {
					return true;
				}
			}
		} );
	},

	closest: function( selectors, context ) {
		var cur,
			i = 0,
			l = this.length,
			matched = [],
			targets = typeof selectors !== "string" && jQuery( selectors );

		// Positional selectors never match, since there's no _selection_ context
		if ( !rneedsContext.test( selectors ) ) {
			for ( ; i < l; i++ ) {
				for ( cur = this[ i ]; cur && cur !== context; cur = cur.parentNode ) {

					// Always skip document fragments
					if ( cur.nodeType < 11 && ( targets ?
						targets.index( cur ) > -1 :

						// Don't pass non-elements to Sizzle
						cur.nodeType === 1 &&
							jQuery.find.matchesSelector( cur, selectors ) ) ) {

						matched.push( cur );
						break;
					}
				}
			}
		}

		return this.pushStack( matched.length > 1 ? jQuery.uniqueSort( matched ) : matched );
	},

	// Determine the position of an element within the set
	index: function( elem ) {

		// No argument, return index in parent
		if ( !elem ) {
			return ( this[ 0 ] && this[ 0 ].parentNode ) ? this.first().prevAll().length : -1;
		}

		// Index in selector
		if ( typeof elem === "string" ) {
			return indexOf.call( jQuery( elem ), this[ 0 ] );
		}

		// Locate the position of the desired element
		return indexOf.call( this,

			// If it receives a jQuery object, the first element is used
			elem.jquery ? elem[ 0 ] : elem
		);
	},

	add: function( selector, context ) {
		return this.pushStack(
			jQuery.uniqueSort(
				jQuery.merge( this.get(), jQuery( selector, context ) )
			)
		);
	},

	addBack: function( selector ) {
		return this.add( selector == null ?
			this.prevObject : this.prevObject.filter( selector )
		);
	}
} );

function sibling( cur, dir ) {
	while ( ( cur = cur[ dir ] ) && cur.nodeType !== 1 ) {}
	return cur;
}

jQuery.each( {
	parent: function( elem ) {
		var parent = elem.parentNode;
		return parent && parent.nodeType !== 11 ? parent : null;
	},
	parents: function( elem ) {
		return dir( elem, "parentNode" );
	},
	parentsUntil: function( elem, i, until ) {
		return dir( elem, "parentNode", until );
	},
	next: function( elem ) {
		return sibling( elem, "nextSibling" );
	},
	prev: function( elem ) {
		return sibling( elem, "previousSibling" );
	},
	nextAll: function( elem ) {
		return dir( elem, "nextSibling" );
	},
	prevAll: function( elem ) {
		return dir( elem, "previousSibling" );
	},
	nextUntil: function( elem, i, until ) {
		return dir( elem, "nextSibling", until );
	},
	prevUntil: function( elem, i, until ) {
		return dir( elem, "previousSibling", until );
	},
	siblings: function( elem ) {
		return siblings( ( elem.parentNode || {} ).firstChild, elem );
	},
	children: function( elem ) {
		return siblings( elem.firstChild );
	},
	contents: function( elem ) {
        if ( nodeName( elem, "iframe" ) ) {
            return elem.contentDocument;
        }

        // Support: IE 9 - 11 only, iOS 7 only, Android Browser <=4.3 only
        // Treat the template element as a regular one in browsers that
        // don't support it.
        if ( nodeName( elem, "template" ) ) {
            elem = elem.content || elem;
        }

        return jQuery.merge( [], elem.childNodes );
	}
}, function( name, fn ) {
	jQuery.fn[ name ] = function( until, selector ) {
		var matched = jQuery.map( this, fn, until );

		if ( name.slice( -5 ) !== "Until" ) {
			selector = until;
		}

		if ( selector && typeof selector === "string" ) {
			matched = jQuery.filter( selector, matched );
		}

		if ( this.length > 1 ) {

			// Remove duplicates
			if ( !guaranteedUnique[ name ] ) {
				jQuery.uniqueSort( matched );
			}

			// Reverse order for parents* and prev-derivatives
			if ( rparentsprev.test( name ) ) {
				matched.reverse();
			}
		}

		return this.pushStack( matched );
	};
} );
var rnothtmlwhite = ( /[^\x20\t\r\n\f]+/g );



// Convert String-formatted options into Object-formatted ones
function createOptions( options ) {
	var object = {};
	jQuery.each( options.match( rnothtmlwhite ) || [], function( _, flag ) {
		object[ flag ] = true;
	} );
	return object;
}

/*
 * Create a callback list using the following parameters:
 *
 *	options: an optional list of space-separated options that will change how
 *			the callback list behaves or a more traditional option object
 *
 * By default a callback list will act like an event callback list and can be
 * "fired" multiple times.
 *
 * Possible options:
 *
 *	once:			will ensure the callback list can only be fired once (like a Deferred)
 *
 *	memory:			will keep track of previous values and will call any callback added
 *					after the list has been fired right away with the latest "memorized"
 *					values (like a Deferred)
 *
 *	unique:			will ensure a callback can only be added once (no duplicate in the list)
 *
 *	stopOnFalse:	interrupt callings when a callback returns false
 *
 */
jQuery.Callbacks = function( options ) {

	// Convert options from String-formatted to Object-formatted if needed
	// (we check in cache first)
	options = typeof options === "string" ?
		createOptions( options ) :
		jQuery.extend( {}, options );

	var // Flag to know if list is currently firing
		firing,

		// Last fire value for non-forgettable lists
		memory,

		// Flag to know if list was already fired
		fired,

		// Flag to prevent firing
		locked,

		// Actual callback list
		list = [],

		// Queue of execution data for repeatable lists
		queue = [],

		// Index of currently firing callback (modified by add/remove as needed)
		firingIndex = -1,

		// Fire callbacks
		fire = function() {

			// Enforce single-firing
			locked = locked || options.once;

			// Execute callbacks for all pending executions,
			// respecting firingIndex overrides and runtime changes
			fired = firing = true;
			for ( ; queue.length; firingIndex = -1 ) {
				memory = queue.shift();
				while ( ++firingIndex < list.length ) {

					// Run callback and check for early termination
					if ( list[ firingIndex ].apply( memory[ 0 ], memory[ 1 ] ) === false &&
						options.stopOnFalse ) {

						// Jump to end and forget the data so .add doesn't re-fire
						firingIndex = list.length;
						memory = false;
					}
				}
			}

			// Forget the data if we're done with it
			if ( !options.memory ) {
				memory = false;
			}

			firing = false;

			// Clean up if we're done firing for good
			if ( locked ) {

				// Keep an empty list if we have data for future add calls
				if ( memory ) {
					list = [];

				// Otherwise, this object is spent
				} else {
					list = "";
				}
			}
		},

		// Actual Callbacks object
		self = {

			// Add a callback or a collection of callbacks to the list
			add: function() {
				if ( list ) {

					// If we have memory from a past run, we should fire after adding
					if ( memory && !firing ) {
						firingIndex = list.length - 1;
						queue.push( memory );
					}

					( function add( args ) {
						jQuery.each( args, function( _, arg ) {
							if ( jQuery.isFunction( arg ) ) {
								if ( !options.unique || !self.has( arg ) ) {
									list.push( arg );
								}
							} else if ( arg && arg.length && jQuery.type( arg ) !== "string" ) {

								// Inspect recursively
								add( arg );
							}
						} );
					} )( arguments );

					if ( memory && !firing ) {
						fire();
					}
				}
				return this;
			},

			// Remove a callback from the list
			remove: function() {
				jQuery.each( arguments, function( _, arg ) {
					var index;
					while ( ( index = jQuery.inArray( arg, list, index ) ) > -1 ) {
						list.splice( index, 1 );

						// Handle firing indexes
						if ( index <= firingIndex ) {
							firingIndex--;
						}
					}
				} );
				return this;
			},

			// Check if a given callback is in the list.
			// If no argument is given, return whether or not list has callbacks attached.
			has: function( fn ) {
				return fn ?
					jQuery.inArray( fn, list ) > -1 :
					list.length > 0;
			},

			// Remove all callbacks from the list
			empty: function() {
				if ( list ) {
					list = [];
				}
				return this;
			},

			// Disable .fire and .add
			// Abort any current/pending executions
			// Clear all callbacks and values
			disable: function() {
				locked = queue = [];
				list = memory = "";
				return this;
			},
			disabled: function() {
				return !list;
			},

			// Disable .fire
			// Also disable .add unless we have memory (since it would have no effect)
			// Abort any pending executions
			lock: function() {
				locked = queue = [];
				if ( !memory && !firing ) {
					list = memory = "";
				}
				return this;
			},
			locked: function() {
				return !!locked;
			},

			// Call all callbacks with the given context and arguments
			fireWith: function( context, args ) {
				if ( !locked ) {
					args = args || [];
					args = [ context, args.slice ? args.slice() : args ];
					queue.push( args );
					if ( !firing ) {
						fire();
					}
				}
				return this;
			},

			// Call all the callbacks with the given arguments
			fire: function() {
				self.fireWith( this, arguments );
				return this;
			},

			// To know if the callbacks have already been called at least once
			fired: function() {
				return !!fired;
			}
		};

	return self;
};


function Identity( v ) {
	return v;
}
function Thrower( ex ) {
	throw ex;
}

function adoptValue( value, resolve, reject, noValue ) {
	var method;

	try {

		// Check for promise aspect first to privilege synchronous behavior
		if ( value && jQuery.isFunction( ( method = value.promise ) ) ) {
			method.call( value ).done( resolve ).fail( reject );

		// Other thenables
		} else if ( value && jQuery.isFunction( ( method = value.then ) ) ) {
			method.call( value, resolve, reject );

		// Other non-thenables
		} else {

			// Control `resolve` arguments by letting Array#slice cast boolean `noValue` to integer:
			// * false: [ value ].slice( 0 ) => resolve( value )
			// * true: [ value ].slice( 1 ) => resolve()
			resolve.apply( undefined, [ value ].slice( noValue ) );
		}

	// For Promises/A+, convert exceptions into rejections
	// Since jQuery.when doesn't unwrap thenables, we can skip the extra checks appearing in
	// Deferred#then to conditionally suppress rejection.
	} catch ( value ) {

		// Support: Android 4.0 only
		// Strict mode functions invoked without .call/.apply get global-object context
		reject.apply( undefined, [ value ] );
	}
}

jQuery.extend( {

	Deferred: function( func ) {
		var tuples = [

				// action, add listener, callbacks,
				// ... .then handlers, argument index, [final state]
				[ "notify", "progress", jQuery.Callbacks( "memory" ),
					jQuery.Callbacks( "memory" ), 2 ],
				[ "resolve", "done", jQuery.Callbacks( "once memory" ),
					jQuery.Callbacks( "once memory" ), 0, "resolved" ],
				[ "reject", "fail", jQuery.Callbacks( "once memory" ),
					jQuery.Callbacks( "once memory" ), 1, "rejected" ]
			],
			state = "pending",
			promise = {
				state: function() {
					return state;
				},
				always: function() {
					deferred.done( arguments ).fail( arguments );
					return this;
				},
				"catch": function( fn ) {
					return promise.then( null, fn );
				},

				// Keep pipe for back-compat
				pipe: function( /* fnDone, fnFail, fnProgress */ ) {
					var fns = arguments;

					return jQuery.Deferred( function( newDefer ) {
						jQuery.each( tuples, function( i, tuple ) {

							// Map tuples (progress, done, fail) to arguments (done, fail, progress)
							var fn = jQuery.isFunction( fns[ tuple[ 4 ] ] ) && fns[ tuple[ 4 ] ];

							// deferred.progress(function() { bind to newDefer or newDefer.notify })
							// deferred.done(function() { bind to newDefer or newDefer.resolve })
							// deferred.fail(function() { bind to newDefer or newDefer.reject })
							deferred[ tuple[ 1 ] ]( function() {
								var returned = fn && fn.apply( this, arguments );
								if ( returned && jQuery.isFunction( returned.promise ) ) {
									returned.promise()
										.progress( newDefer.notify )
										.done( newDefer.resolve )
										.fail( newDefer.reject );
								} else {
									newDefer[ tuple[ 0 ] + "With" ](
										this,
										fn ? [ returned ] : arguments
									);
								}
							} );
						} );
						fns = null;
					} ).promise();
				},
				then: function( onFulfilled, onRejected, onProgress ) {
					var maxDepth = 0;
					function resolve( depth, deferred, handler, special ) {
						return function() {
							var that = this,
								args = arguments,
								mightThrow = function() {
									var returned, then;

									// Support: Promises/A+ section 2.3.3.3.3
									// https://promisesaplus.com/#point-59
									// Ignore double-resolution attempts
									if ( depth < maxDepth ) {
										return;
									}

									returned = handler.apply( that, args );

									// Support: Promises/A+ section 2.3.1
									// https://promisesaplus.com/#point-48
									if ( returned === deferred.promise() ) {
										throw new TypeError( "Thenable self-resolution" );
									}

									// Support: Promises/A+ sections 2.3.3.1, 3.5
									// https://promisesaplus.com/#point-54
									// https://promisesaplus.com/#point-75
									// Retrieve `then` only once
									then = returned &&

										// Support: Promises/A+ section 2.3.4
										// https://promisesaplus.com/#point-64
										// Only check objects and functions for thenability
										( typeof returned === "object" ||
											typeof returned === "function" ) &&
										returned.then;

									// Handle a returned thenable
									if ( jQuery.isFunction( then ) ) {

										// Special processors (notify) just wait for resolution
										if ( special ) {
											then.call(
												returned,
												resolve( maxDepth, deferred, Identity, special ),
												resolve( maxDepth, deferred, Thrower, special )
											);

										// Normal processors (resolve) also hook into progress
										} else {

											// ...and disregard older resolution values
											maxDepth++;

											then.call(
												returned,
												resolve( maxDepth, deferred, Identity, special ),
												resolve( maxDepth, deferred, Thrower, special ),
												resolve( maxDepth, deferred, Identity,
													deferred.notifyWith )
											);
										}

									// Handle all other returned values
									} else {

										// Only substitute handlers pass on context
										// and multiple values (non-spec behavior)
										if ( handler !== Identity ) {
											that = undefined;
											args = [ returned ];
										}

										// Process the value(s)
										// Default process is resolve
										( special || deferred.resolveWith )( that, args );
									}
								},

								// Only normal processors (resolve) catch and reject exceptions
								process = special ?
									mightThrow :
									function() {
										try {
											mightThrow();
										} catch ( e ) {

											if ( jQuery.Deferred.exceptionHook ) {
												jQuery.Deferred.exceptionHook( e,
													process.stackTrace );
											}

											// Support: Promises/A+ section 2.3.3.3.4.1
											// https://promisesaplus.com/#point-61
											// Ignore post-resolution exceptions
											if ( depth + 1 >= maxDepth ) {

												// Only substitute handlers pass on context
												// and multiple values (non-spec behavior)
												if ( handler !== Thrower ) {
													that = undefined;
													args = [ e ];
												}

												deferred.rejectWith( that, args );
											}
										}
									};

							// Support: Promises/A+ section 2.3.3.3.1
							// https://promisesaplus.com/#point-57
							// Re-resolve promises immediately to dodge false rejection from
							// subsequent errors
							if ( depth ) {
								process();
							} else {

								// Call an optional hook to record the stack, in case of exception
								// since it's otherwise lost when execution goes async
								if ( jQuery.Deferred.getStackHook ) {
									process.stackTrace = jQuery.Deferred.getStackHook();
								}
								window.setTimeout( process );
							}
						};
					}

					return jQuery.Deferred( function( newDefer ) {

						// progress_handlers.add( ... )
						tuples[ 0 ][ 3 ].add(
							resolve(
								0,
								newDefer,
								jQuery.isFunction( onProgress ) ?
									onProgress :
									Identity,
								newDefer.notifyWith
							)
						);

						// fulfilled_handlers.add( ... )
						tuples[ 1 ][ 3 ].add(
							resolve(
								0,
								newDefer,
								jQuery.isFunction( onFulfilled ) ?
									onFulfilled :
									Identity
							)
						);

						// rejected_handlers.add( ... )
						tuples[ 2 ][ 3 ].add(
							resolve(
								0,
								newDefer,
								jQuery.isFunction( onRejected ) ?
									onRejected :
									Thrower
							)
						);
					} ).promise();
				},

				// Get a promise for this deferred
				// If obj is provided, the promise aspect is added to the object
				promise: function( obj ) {
					return obj != null ? jQuery.extend( obj, promise ) : promise;
				}
			},
			deferred = {};

		// Add list-specific methods
		jQuery.each( tuples, function( i, tuple ) {
			var list = tuple[ 2 ],
				stateString = tuple[ 5 ];

			// promise.progress = list.add
			// promise.done = list.add
			// promise.fail = list.add
			promise[ tuple[ 1 ] ] = list.add;

			// Handle state
			if ( stateString ) {
				list.add(
					function() {

						// state = "resolved" (i.e., fulfilled)
						// state = "rejected"
						state = stateString;
					},

					// rejected_callbacks.disable
					// fulfilled_callbacks.disable
					tuples[ 3 - i ][ 2 ].disable,

					// progress_callbacks.lock
					tuples[ 0 ][ 2 ].lock
				);
			}

			// progress_handlers.fire
			// fulfilled_handlers.fire
			// rejected_handlers.fire
			list.add( tuple[ 3 ].fire );

			// deferred.notify = function() { deferred.notifyWith(...) }
			// deferred.resolve = function() { deferred.resolveWith(...) }
			// deferred.reject = function() { deferred.rejectWith(...) }
			deferred[ tuple[ 0 ] ] = function() {
				deferred[ tuple[ 0 ] + "With" ]( this === deferred ? undefined : this, arguments );
				return this;
			};

			// deferred.notifyWith = list.fireWith
			// deferred.resolveWith = list.fireWith
			// deferred.rejectWith = list.fireWith
			deferred[ tuple[ 0 ] + "With" ] = list.fireWith;
		} );

		// Make the deferred a promise
		promise.promise( deferred );

		// Call given func if any
		if ( func ) {
			func.call( deferred, deferred );
		}

		// All done!
		return deferred;
	},

	// Deferred helper
	when: function( singleValue ) {
		var

			// count of uncompleted subordinates
			remaining = arguments.length,

			// count of unprocessed arguments
			i = remaining,

			// subordinate fulfillment data
			resolveContexts = Array( i ),
			resolveValues = slice.call( arguments ),

			// the master Deferred
			master = jQuery.Deferred(),

			// subordinate callback factory
			updateFunc = function( i ) {
				return function( value ) {
					resolveContexts[ i ] = this;
					resolveValues[ i ] = arguments.length > 1 ? slice.call( arguments ) : value;
					if ( !( --remaining ) ) {
						master.resolveWith( resolveContexts, resolveValues );
					}
				};
			};

		// Single- and empty arguments are adopted like Promise.resolve
		if ( remaining <= 1 ) {
			adoptValue( singleValue, master.done( updateFunc( i ) ).resolve, master.reject,
				!remaining );

			// Use .then() to unwrap secondary thenables (cf. gh-3000)
			if ( master.state() === "pending" ||
				jQuery.isFunction( resolveValues[ i ] && resolveValues[ i ].then ) ) {

				return master.then();
			}
		}

		// Multiple arguments are aggregated like Promise.all array elements
		while ( i-- ) {
			adoptValue( resolveValues[ i ], updateFunc( i ), master.reject );
		}

		return master.promise();
	}
} );


// These usually indicate a programmer mistake during development,
// warn about them ASAP rather than swallowing them by default.
var rerrorNames = /^(Eval|Internal|Range|Reference|Syntax|Type|URI)Error$/;

jQuery.Deferred.exceptionHook = function( error, stack ) {

	// Support: IE 8 - 9 only
	// Console exists when dev tools are open, which can happen at any time
	if ( window.console && window.console.warn && error && rerrorNames.test( error.name ) ) {
		window.console.warn( "jQuery.Deferred exception: " + error.message, error.stack, stack );
	}
};




jQuery.readyException = function( error ) {
	window.setTimeout( function() {
		throw error;
	} );
};




// The deferred used on DOM ready
var readyList = jQuery.Deferred();

jQuery.fn.ready = function( fn ) {

	readyList
		.then( fn )

		// Wrap jQuery.readyException in a function so that the lookup
		// happens at the time of error handling instead of callback
		// registration.
		.catch( function( error ) {
			jQuery.readyException( error );
		} );

	return this;
};

jQuery.extend( {

	// Is the DOM ready to be used? Set to true once it occurs.
	isReady: false,

	// A counter to track how many items to wait for before
	// the ready event fires. See #6781
	readyWait: 1,

	// Handle when the DOM is ready
	ready: function( wait ) {

		// Abort if there are pending holds or we're already ready
		if ( wait === true ? --jQuery.readyWait : jQuery.isReady ) {
			return;
		}

		// Remember that the DOM is ready
		jQuery.isReady = true;

		// If a normal DOM Ready event fired, decrement, and wait if need be
		if ( wait !== true && --jQuery.readyWait > 0 ) {
			return;
		}

		// If there are functions bound, to execute
		readyList.resolveWith( document, [ jQuery ] );
	}
} );

jQuery.ready.then = readyList.then;

// The ready event handler and self cleanup method
function completed() {
	document.removeEventListener( "DOMContentLoaded", completed );
	window.removeEventListener( "load", completed );
	jQuery.ready();
}

// Catch cases where $(document).ready() is called
// after the browser event has already occurred.
// Support: IE <=9 - 10 only
// Older IE sometimes signals "interactive" too soon
if ( document.readyState === "complete" ||
	( document.readyState !== "loading" && !document.documentElement.doScroll ) ) {

	// Handle it asynchronously to allow scripts the opportunity to delay ready
	window.setTimeout( jQuery.ready );

} else {

	// Use the handy event callback
	document.addEventListener( "DOMContentLoaded", completed );

	// A fallback to window.onload, that will always work
	window.addEventListener( "load", completed );
}




// Multifunctional method to get and set values of a collection
// The value/s can optionally be executed if it's a function
var access = function( elems, fn, key, value, chainable, emptyGet, raw ) {
	var i = 0,
		len = elems.length,
		bulk = key == null;

	// Sets many values
	if ( jQuery.type( key ) === "object" ) {
		chainable = true;
		for ( i in key ) {
			access( elems, fn, i, key[ i ], true, emptyGet, raw );
		}

	// Sets one value
	} else if ( value !== undefined ) {
		chainable = true;

		if ( !jQuery.isFunction( value ) ) {
			raw = true;
		}

		if ( bulk ) {

			// Bulk operations run against the entire set
			if ( raw ) {
				fn.call( elems, value );
				fn = null;

			// ...except when executing function values
			} else {
				bulk = fn;
				fn = function( elem, key, value ) {
					return bulk.call( jQuery( elem ), value );
				};
			}
		}

		if ( fn ) {
			for ( ; i < len; i++ ) {
				fn(
					elems[ i ], key, raw ?
					value :
					value.call( elems[ i ], i, fn( elems[ i ], key ) )
				);
			}
		}
	}

	if ( chainable ) {
		return elems;
	}

	// Gets
	if ( bulk ) {
		return fn.call( elems );
	}

	return len ? fn( elems[ 0 ], key ) : emptyGet;
};
var acceptData = function( owner ) {

	// Accepts only:
	//  - Node
	//    - Node.ELEMENT_NODE
	//    - Node.DOCUMENT_NODE
	//  - Object
	//    - Any
	return owner.nodeType === 1 || owner.nodeType === 9 || !( +owner.nodeType );
};




function Data() {
	this.expando = jQuery.expando + Data.uid++;
}

Data.uid = 1;

Data.prototype = {

	cache: function( owner ) {

		// Check if the owner object already has a cache
		var value = owner[ this.expando ];

		// If not, create one
		if ( !value ) {
			value = {};

			// We can accept data for non-element nodes in modern browsers,
			// but we should not, see #8335.
			// Always return an empty object.
			if ( acceptData( owner ) ) {

				// If it is a node unlikely to be stringify-ed or looped over
				// use plain assignment
				if ( owner.nodeType ) {
					owner[ this.expando ] = value;

				// Otherwise secure it in a non-enumerable property
				// configurable must be true to allow the property to be
				// deleted when data is removed
				} else {
					Object.defineProperty( owner, this.expando, {
						value: value,
						configurable: true
					} );
				}
			}
		}

		return value;
	},
	set: function( owner, data, value ) {
		var prop,
			cache = this.cache( owner );

		// Handle: [ owner, key, value ] args
		// Always use camelCase key (gh-2257)
		if ( typeof data === "string" ) {
			cache[ jQuery.camelCase( data ) ] = value;

		// Handle: [ owner, { properties } ] args
		} else {

			// Copy the properties one-by-one to the cache object
			for ( prop in data ) {
				cache[ jQuery.camelCase( prop ) ] = data[ prop ];
			}
		}
		return cache;
	},
	get: function( owner, key ) {
		return key === undefined ?
			this.cache( owner ) :

			// Always use camelCase key (gh-2257)
			owner[ this.expando ] && owner[ this.expando ][ jQuery.camelCase( key ) ];
	},
	access: function( owner, key, value ) {

		// In cases where either:
		//
		//   1. No key was specified
		//   2. A string key was specified, but no value provided
		//
		// Take the "read" path and allow the get method to determine
		// which value to return, respectively either:
		//
		//   1. The entire cache object
		//   2. The data stored at the key
		//
		if ( key === undefined ||
				( ( key && typeof key === "string" ) && value === undefined ) ) {

			return this.get( owner, key );
		}

		// When the key is not a string, or both a key and value
		// are specified, set or extend (existing objects) with either:
		//
		//   1. An object of properties
		//   2. A key and value
		//
		this.set( owner, key, value );

		// Since the "set" path can have two possible entry points
		// return the expected data based on which path was taken[*]
		return value !== undefined ? value : key;
	},
	remove: function( owner, key ) {
		var i,
			cache = owner[ this.expando ];

		if ( cache === undefined ) {
			return;
		}

		if ( key !== undefined ) {

			// Support array or space separated string of keys
			if ( Array.isArray( key ) ) {

				// If key is an array of keys...
				// We always set camelCase keys, so remove that.
				key = key.map( jQuery.camelCase );
			} else {
				key = jQuery.camelCase( key );

				// If a key with the spaces exists, use it.
				// Otherwise, create an array by matching non-whitespace
				key = key in cache ?
					[ key ] :
					( key.match( rnothtmlwhite ) || [] );
			}

			i = key.length;

			while ( i-- ) {
				delete cache[ key[ i ] ];
			}
		}

		// Remove the expando if there's no more data
		if ( key === undefined || jQuery.isEmptyObject( cache ) ) {

			// Support: Chrome <=35 - 45
			// Webkit & Blink performance suffers when deleting properties
			// from DOM nodes, so set to undefined instead
			// https://bugs.chromium.org/p/chromium/issues/detail?id=378607 (bug restricted)
			if ( owner.nodeType ) {
				owner[ this.expando ] = undefined;
			} else {
				delete owner[ this.expando ];
			}
		}
	},
	hasData: function( owner ) {
		var cache = owner[ this.expando ];
		return cache !== undefined && !jQuery.isEmptyObject( cache );
	}
};
var dataPriv = new Data();

var dataUser = new Data();



//	Implementation Summary
//
//	1. Enforce API surface and semantic compatibility with 1.9.x branch
//	2. Improve the module's maintainability by reducing the storage
//		paths to a single mechanism.
//	3. Use the same single mechanism to support "private" and "user" data.
//	4. _Never_ expose "private" data to user code (TODO: Drop _data, _removeData)
//	5. Avoid exposing implementation details on user objects (eg. expando properties)
//	6. Provide a clear path for implementation upgrade to WeakMap in 2014

var rbrace = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,
	rmultiDash = /[A-Z]/g;

function getData( data ) {
	if ( data === "true" ) {
		return true;
	}

	if ( data === "false" ) {
		return false;
	}

	if ( data === "null" ) {
		return null;
	}

	// Only convert to a number if it doesn't change the string
	if ( data === +data + "" ) {
		return +data;
	}

	if ( rbrace.test( data ) ) {
		return JSON.parse( data );
	}

	return data;
}

function dataAttr( elem, key, data ) {
	var name;

	// If nothing was found internally, try to fetch any
	// data from the HTML5 data-* attribute
	if ( data === undefined && elem.nodeType === 1 ) {
		name = "data-" + key.replace( rmultiDash, "-$&" ).toLowerCase();
		data = elem.getAttribute( name );

		if ( typeof data === "string" ) {
			try {
				data = getData( data );
			} catch ( e ) {}

			// Make sure we set the data so it isn't changed later
			dataUser.set( elem, key, data );
		} else {
			data = undefined;
		}
	}
	return data;
}

jQuery.extend( {
	hasData: function( elem ) {
		return dataUser.hasData( elem ) || dataPriv.hasData( elem );
	},

	data: function( elem, name, data ) {
		return dataUser.access( elem, name, data );
	},

	removeData: function( elem, name ) {
		dataUser.remove( elem, name );
	},

	// TODO: Now that all calls to _data and _removeData have been replaced
	// with direct calls to dataPriv methods, these can be deprecated.
	_data: function( elem, name, data ) {
		return dataPriv.access( elem, name, data );
	},

	_removeData: function( elem, name ) {
		dataPriv.remove( elem, name );
	}
} );

jQuery.fn.extend( {
	data: function( key, value ) {
		var i, name, data,
			elem = this[ 0 ],
			attrs = elem && elem.attributes;

		// Gets all values
		if ( key === undefined ) {
			if ( this.length ) {
				data = dataUser.get( elem );

				if ( elem.nodeType === 1 && !dataPriv.get( elem, "hasDataAttrs" ) ) {
					i = attrs.length;
					while ( i-- ) {

						// Support: IE 11 only
						// The attrs elements can be null (#14894)
						if ( attrs[ i ] ) {
							name = attrs[ i ].name;
							if ( name.indexOf( "data-" ) === 0 ) {
								name = jQuery.camelCase( name.slice( 5 ) );
								dataAttr( elem, name, data[ name ] );
							}
						}
					}
					dataPriv.set( elem, "hasDataAttrs", true );
				}
			}

			return data;
		}

		// Sets multiple values
		if ( typeof key === "object" ) {
			return this.each( function() {
				dataUser.set( this, key );
			} );
		}

		return access( this, function( value ) {
			var data;

			// The calling jQuery object (element matches) is not empty
			// (and therefore has an element appears at this[ 0 ]) and the
			// `value` parameter was not undefined. An empty jQuery object
			// will result in `undefined` for elem = this[ 0 ] which will
			// throw an exception if an attempt to read a data cache is made.
			if ( elem && value === undefined ) {

				// Attempt to get data from the cache
				// The key will always be camelCased in Data
				data = dataUser.get( elem, key );
				if ( data !== undefined ) {
					return data;
				}

				// Attempt to "discover" the data in
				// HTML5 custom data-* attrs
				data = dataAttr( elem, key );
				if ( data !== undefined ) {
					return data;
				}

				// We tried really hard, but the data doesn't exist.
				return;
			}

			// Set the data...
			this.each( function() {

				// We always store the camelCased key
				dataUser.set( this, key, value );
			} );
		}, null, value, arguments.length > 1, null, true );
	},

	removeData: function( key ) {
		return this.each( function() {
			dataUser.remove( this, key );
		} );
	}
} );


jQuery.extend( {
	queue: function( elem, type, data ) {
		var queue;

		if ( elem ) {
			type = ( type || "fx" ) + "queue";
			queue = dataPriv.get( elem, type );

			// Speed up dequeue by getting out quickly if this is just a lookup
			if ( data ) {
				if ( !queue || Array.isArray( data ) ) {
					queue = dataPriv.access( elem, type, jQuery.makeArray( data ) );
				} else {
					queue.push( data );
				}
			}
			return queue || [];
		}
	},

	dequeue: function( elem, type ) {
		type = type || "fx";

		var queue = jQuery.queue( elem, type ),
			startLength = queue.length,
			fn = queue.shift(),
			hooks = jQuery._queueHooks( elem, type ),
			next = function() {
				jQuery.dequeue( elem, type );
			};

		// If the fx queue is dequeued, always remove the progress sentinel
		if ( fn === "inprogress" ) {
			fn = queue.shift();
			startLength--;
		}

		if ( fn ) {

			// Add a progress sentinel to prevent the fx queue from being
			// automatically dequeued
			if ( type === "fx" ) {
				queue.unshift( "inprogress" );
			}

			// Clear up the last queue stop function
			delete hooks.stop;
			fn.call( elem, next, hooks );
		}

		if ( !startLength && hooks ) {
			hooks.empty.fire();
		}
	},

	// Not public - generate a queueHooks object, or return the current one
	_queueHooks: function( elem, type ) {
		var key = type + "queueHooks";
		return dataPriv.get( elem, key ) || dataPriv.access( elem, key, {
			empty: jQuery.Callbacks( "once memory" ).add( function() {
				dataPriv.remove( elem, [ type + "queue", key ] );
			} )
		} );
	}
} );

jQuery.fn.extend( {
	queue: function( type, data ) {
		var setter = 2;

		if ( typeof type !== "string" ) {
			data = type;
			type = "fx";
			setter--;
		}

		if ( arguments.length < setter ) {
			return jQuery.queue( this[ 0 ], type );
		}

		return data === undefined ?
			this :
			this.each( function() {
				var queue = jQuery.queue( this, type, data );

				// Ensure a hooks for this queue
				jQuery._queueHooks( this, type );

				if ( type === "fx" && queue[ 0 ] !== "inprogress" ) {
					jQuery.dequeue( this, type );
				}
			} );
	},
	dequeue: function( type ) {
		return this.each( function() {
			jQuery.dequeue( this, type );
		} );
	},
	clearQueue: function( type ) {
		return this.queue( type || "fx", [] );
	},

	// Get a promise resolved when queues of a certain type
	// are emptied (fx is the type by default)
	promise: function( type, obj ) {
		var tmp,
			count = 1,
			defer = jQuery.Deferred(),
			elements = this,
			i = this.length,
			resolve = function() {
				if ( !( --count ) ) {
					defer.resolveWith( elements, [ elements ] );
				}
			};

		if ( typeof type !== "string" ) {
			obj = type;
			type = undefined;
		}
		type = type || "fx";

		while ( i-- ) {
			tmp = dataPriv.get( elements[ i ], type + "queueHooks" );
			if ( tmp && tmp.empty ) {
				count++;
				tmp.empty.add( resolve );
			}
		}
		resolve();
		return defer.promise( obj );
	}
} );
var pnum = ( /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/ ).source;

var rcssNum = new RegExp( "^(?:([+-])=|)(" + pnum + ")([a-z%]*)$", "i" );


var cssExpand = [ "Top", "Right", "Bottom", "Left" ];

var isHiddenWithinTree = function( elem, el ) {

		// isHiddenWithinTree might be called from jQuery#filter function;
		// in that case, element will be second argument
		elem = el || elem;

		// Inline style trumps all
		return elem.style.display === "none" ||
			elem.style.display === "" &&

			// Otherwise, check computed style
			// Support: Firefox <=43 - 45
			// Disconnected elements can have computed display: none, so first confirm that elem is
			// in the document.
			jQuery.contains( elem.ownerDocument, elem ) &&

			jQuery.css( elem, "display" ) === "none";
	};

var swap = function( elem, options, callback, args ) {
	var ret, name,
		old = {};

	// Remember the old values, and insert the new ones
	for ( name in options ) {
		old[ name ] = elem.style[ name ];
		elem.style[ name ] = options[ name ];
	}

	ret = callback.apply( elem, args || [] );

	// Revert the old values
	for ( name in options ) {
		elem.style[ name ] = old[ name ];
	}

	return ret;
};




function adjustCSS( elem, prop, valueParts, tween ) {
	var adjusted,
		scale = 1,
		maxIterations = 20,
		currentValue = tween ?
			function() {
				return tween.cur();
			} :
			function() {
				return jQuery.css( elem, prop, "" );
			},
		initial = currentValue(),
		unit = valueParts && valueParts[ 3 ] || ( jQuery.cssNumber[ prop ] ? "" : "px" ),

		// Starting value computation is required for potential unit mismatches
		initialInUnit = ( jQuery.cssNumber[ prop ] || unit !== "px" && +initial ) &&
			rcssNum.exec( jQuery.css( elem, prop ) );

	if ( initialInUnit && initialInUnit[ 3 ] !== unit ) {

		// Trust units reported by jQuery.css
		unit = unit || initialInUnit[ 3 ];

		// Make sure we update the tween properties later on
		valueParts = valueParts || [];

		// Iteratively approximate from a nonzero starting point
		initialInUnit = +initial || 1;

		do {

			// If previous iteration zeroed out, double until we get *something*.
			// Use string for doubling so we don't accidentally see scale as unchanged below
			scale = scale || ".5";

			// Adjust and apply
			initialInUnit = initialInUnit / scale;
			jQuery.style( elem, prop, initialInUnit + unit );

		// Update scale, tolerating zero or NaN from tween.cur()
		// Break the loop if scale is unchanged or perfect, or if we've just had enough.
		} while (
			scale !== ( scale = currentValue() / initial ) && scale !== 1 && --maxIterations
		);
	}

	if ( valueParts ) {
		initialInUnit = +initialInUnit || +initial || 0;

		// Apply relative offset (+=/-=) if specified
		adjusted = valueParts[ 1 ] ?
			initialInUnit + ( valueParts[ 1 ] + 1 ) * valueParts[ 2 ] :
			+valueParts[ 2 ];
		if ( tween ) {
			tween.unit = unit;
			tween.start = initialInUnit;
			tween.end = adjusted;
		}
	}
	return adjusted;
}


var defaultDisplayMap = {};

function getDefaultDisplay( elem ) {
	var temp,
		doc = elem.ownerDocument,
		nodeName = elem.nodeName,
		display = defaultDisplayMap[ nodeName ];

	if ( display ) {
		return display;
	}

	temp = doc.body.appendChild( doc.createElement( nodeName ) );
	display = jQuery.css( temp, "display" );

	temp.parentNode.removeChild( temp );

	if ( display === "none" ) {
		display = "block";
	}
	defaultDisplayMap[ nodeName ] = display;

	return display;
}

function showHide( elements, show ) {
	var display, elem,
		values = [],
		index = 0,
		length = elements.length;

	// Determine new display value for elements that need to change
	for ( ; index < length; index++ ) {
		elem = elements[ index ];
		if ( !elem.style ) {
			continue;
		}

		display = elem.style.display;
		if ( show ) {

			// Since we force visibility upon cascade-hidden elements, an immediate (and slow)
			// check is required in this first loop unless we have a nonempty display value (either
			// inline or about-to-be-restored)
			if ( display === "none" ) {
				values[ index ] = dataPriv.get( elem, "display" ) || null;
				if ( !values[ index ] ) {
					elem.style.display = "";
				}
			}
			if ( elem.style.display === "" && isHiddenWithinTree( elem ) ) {
				values[ index ] = getDefaultDisplay( elem );
			}
		} else {
			if ( display !== "none" ) {
				values[ index ] = "none";

				// Remember what we're overwriting
				dataPriv.set( elem, "display", display );
			}
		}
	}

	// Set the display of the elements in a second loop to avoid constant reflow
	for ( index = 0; index < length; index++ ) {
		if ( values[ index ] != null ) {
			elements[ index ].style.display = values[ index ];
		}
	}

	return elements;
}

jQuery.fn.extend( {
	show: function() {
		return showHide( this, true );
	},
	hide: function() {
		return showHide( this );
	},
	toggle: function( state ) {
		if ( typeof state === "boolean" ) {
			return state ? this.show() : this.hide();
		}

		return this.each( function() {
			if ( isHiddenWithinTree( this ) ) {
				jQuery( this ).show();
			} else {
				jQuery( this ).hide();
			}
		} );
	}
} );
var rcheckableType = ( /^(?:checkbox|radio)$/i );

var rtagName = ( /<([a-z][^\/\0>\x20\t\r\n\f]+)/i );

var rscriptType = ( /^$|\/(?:java|ecma)script/i );



// We have to close these tags to support XHTML (#13200)
var wrapMap = {

	// Support: IE <=9 only
	option: [ 1, "<select multiple='multiple'>", "</select>" ],

	// XHTML parsers do not magically insert elements in the
	// same way that tag soup parsers do. So we cannot shorten
	// this by omitting <tbody> or other required elements.
	thead: [ 1, "<table>", "</table>" ],
	col: [ 2, "<table><colgroup>", "</colgroup></table>" ],
	tr: [ 2, "<table><tbody>", "</tbody></table>" ],
	td: [ 3, "<table><tbody><tr>", "</tr></tbody></table>" ],

	_default: [ 0, "", "" ]
};

// Support: IE <=9 only
wrapMap.optgroup = wrapMap.option;

wrapMap.tbody = wrapMap.tfoot = wrapMap.colgroup = wrapMap.caption = wrapMap.thead;
wrapMap.th = wrapMap.td;


function getAll( context, tag ) {

	// Support: IE <=9 - 11 only
	// Use typeof to avoid zero-argument method invocation on host objects (#15151)
	var ret;

	if ( typeof context.getElementsByTagName !== "undefined" ) {
		ret = context.getElementsByTagName( tag || "*" );

	} else if ( typeof context.querySelectorAll !== "undefined" ) {
		ret = context.querySelectorAll( tag || "*" );

	} else {
		ret = [];
	}

	if ( tag === undefined || tag && nodeName( context, tag ) ) {
		return jQuery.merge( [ context ], ret );
	}

	return ret;
}


// Mark scripts as having already been evaluated
function setGlobalEval( elems, refElements ) {
	var i = 0,
		l = elems.length;

	for ( ; i < l; i++ ) {
		dataPriv.set(
			elems[ i ],
			"globalEval",
			!refElements || dataPriv.get( refElements[ i ], "globalEval" )
		);
	}
}


var rhtml = /<|&#?\w+;/;

function buildFragment( elems, context, scripts, selection, ignored ) {
	var elem, tmp, tag, wrap, contains, j,
		fragment = context.createDocumentFragment(),
		nodes = [],
		i = 0,
		l = elems.length;

	for ( ; i < l; i++ ) {
		elem = elems[ i ];

		if ( elem || elem === 0 ) {

			// Add nodes directly
			if ( jQuery.type( elem ) === "object" ) {

				// Support: Android <=4.0 only, PhantomJS 1 only
				// push.apply(_, arraylike) throws on ancient WebKit
				jQuery.merge( nodes, elem.nodeType ? [ elem ] : elem );

			// Convert non-html into a text node
			} else if ( !rhtml.test( elem ) ) {
				nodes.push( context.createTextNode( elem ) );

			// Convert html into DOM nodes
			} else {
				tmp = tmp || fragment.appendChild( context.createElement( "div" ) );

				// Deserialize a standard representation
				tag = ( rtagName.exec( elem ) || [ "", "" ] )[ 1 ].toLowerCase();
				wrap = wrapMap[ tag ] || wrapMap._default;
				tmp.innerHTML = wrap[ 1 ] + jQuery.htmlPrefilter( elem ) + wrap[ 2 ];

				// Descend through wrappers to the right content
				j = wrap[ 0 ];
				while ( j-- ) {
					tmp = tmp.lastChild;
				}

				// Support: Android <=4.0 only, PhantomJS 1 only
				// push.apply(_, arraylike) throws on ancient WebKit
				jQuery.merge( nodes, tmp.childNodes );

				// Remember the top-level container
				tmp = fragment.firstChild;

				// Ensure the created nodes are orphaned (#12392)
				tmp.textContent = "";
			}
		}
	}

	// Remove wrapper from fragment
	fragment.textContent = "";

	i = 0;
	while ( ( elem = nodes[ i++ ] ) ) {

		// Skip elements already in the context collection (trac-4087)
		if ( selection && jQuery.inArray( elem, selection ) > -1 ) {
			if ( ignored ) {
				ignored.push( elem );
			}
			continue;
		}

		contains = jQuery.contains( elem.ownerDocument, elem );

		// Append to fragment
		tmp = getAll( fragment.appendChild( elem ), "script" );

		// Preserve script evaluation history
		if ( contains ) {
			setGlobalEval( tmp );
		}

		// Capture executables
		if ( scripts ) {
			j = 0;
			while ( ( elem = tmp[ j++ ] ) ) {
				if ( rscriptType.test( elem.type || "" ) ) {
					scripts.push( elem );
				}
			}
		}
	}

	return fragment;
}


( function() {
	var fragment = document.createDocumentFragment(),
		div = fragment.appendChild( document.createElement( "div" ) ),
		input = document.createElement( "input" );

	// Support: Android 4.0 - 4.3 only
	// Check state lost if the name is set (#11217)
	// Support: Windows Web Apps (WWA)
	// `name` and `type` must use .setAttribute for WWA (#14901)
	input.setAttribute( "type", "radio" );
	input.setAttribute( "checked", "checked" );
	input.setAttribute( "name", "t" );

	div.appendChild( input );

	// Support: Android <=4.1 only
	// Older WebKit doesn't clone checked state correctly in fragments
	support.checkClone = div.cloneNode( true ).cloneNode( true ).lastChild.checked;

	// Support: IE <=11 only
	// Make sure textarea (and checkbox) defaultValue is properly cloned
	div.innerHTML = "<textarea>x</textarea>";
	support.noCloneChecked = !!div.cloneNode( true ).lastChild.defaultValue;
} )();
var documentElement = document.documentElement;



var
	rkeyEvent = /^key/,
	rmouseEvent = /^(?:mouse|pointer|contextmenu|drag|drop)|click/,
	rtypenamespace = /^([^.]*)(?:\.(.+)|)/;

function returnTrue() {
	return true;
}

function returnFalse() {
	return false;
}

// Support: IE <=9 only
// See #13393 for more info
function safeActiveElement() {
	try {
		return document.activeElement;
	} catch ( err ) { }
}

function on( elem, types, selector, data, fn, one ) {
	var origFn, type;

	// Types can be a map of types/handlers
	if ( typeof types === "object" ) {

		// ( types-Object, selector, data )
		if ( typeof selector !== "string" ) {

			// ( types-Object, data )
			data = data || selector;
			selector = undefined;
		}
		for ( type in types ) {
			on( elem, type, selector, data, types[ type ], one );
		}
		return elem;
	}

	if ( data == null && fn == null ) {

		// ( types, fn )
		fn = selector;
		data = selector = undefined;
	} else if ( fn == null ) {
		if ( typeof selector === "string" ) {

			// ( types, selector, fn )
			fn = data;
			data = undefined;
		} else {

			// ( types, data, fn )
			fn = data;
			data = selector;
			selector = undefined;
		}
	}
	if ( fn === false ) {
		fn = returnFalse;
	} else if ( !fn ) {
		return elem;
	}

	if ( one === 1 ) {
		origFn = fn;
		fn = function( event ) {

			// Can use an empty set, since event contains the info
			jQuery().off( event );
			return origFn.apply( this, arguments );
		};

		// Use same guid so caller can remove using origFn
		fn.guid = origFn.guid || ( origFn.guid = jQuery.guid++ );
	}
	return elem.each( function() {
		jQuery.event.add( this, types, fn, data, selector );
	} );
}

/*
 * Helper functions for managing events -- not part of the public interface.
 * Props to Dean Edwards' addEvent library for many of the ideas.
 */
jQuery.event = {

	global: {},

	add: function( elem, types, handler, data, selector ) {

		var handleObjIn, eventHandle, tmp,
			events, t, handleObj,
			special, handlers, type, namespaces, origType,
			elemData = dataPriv.get( elem );

		// Don't attach events to noData or text/comment nodes (but allow plain objects)
		if ( !elemData ) {
			return;
		}

		// Caller can pass in an object of custom data in lieu of the handler
		if ( handler.handler ) {
			handleObjIn = handler;
			handler = handleObjIn.handler;
			selector = handleObjIn.selector;
		}

		// Ensure that invalid selectors throw exceptions at attach time
		// Evaluate against documentElement in case elem is a non-element node (e.g., document)
		if ( selector ) {
			jQuery.find.matchesSelector( documentElement, selector );
		}

		// Make sure that the handler has a unique ID, used to find/remove it later
		if ( !handler.guid ) {
			handler.guid = jQuery.guid++;
		}

		// Init the element's event structure and main handler, if this is the first
		if ( !( events = elemData.events ) ) {
			events = elemData.events = {};
		}
		if ( !( eventHandle = elemData.handle ) ) {
			eventHandle = elemData.handle = function( e ) {

				// Discard the second event of a jQuery.event.trigger() and
				// when an event is called after a page has unloaded
				return typeof jQuery !== "undefined" && jQuery.event.triggered !== e.type ?
					jQuery.event.dispatch.apply( elem, arguments ) : undefined;
			};
		}

		// Handle multiple events separated by a space
		types = ( types || "" ).match( rnothtmlwhite ) || [ "" ];
		t = types.length;
		while ( t-- ) {
			tmp = rtypenamespace.exec( types[ t ] ) || [];
			type = origType = tmp[ 1 ];
			namespaces = ( tmp[ 2 ] || "" ).split( "." ).sort();

			// There *must* be a type, no attaching namespace-only handlers
			if ( !type ) {
				continue;
			}

			// If event changes its type, use the special event handlers for the changed type
			special = jQuery.event.special[ type ] || {};

			// If selector defined, determine special event api type, otherwise given type
			type = ( selector ? special.delegateType : special.bindType ) || type;

			// Update special based on newly reset type
			special = jQuery.event.special[ type ] || {};

			// handleObj is passed to all event handlers
			handleObj = jQuery.extend( {
				type: type,
				origType: origType,
				data: data,
				handler: handler,
				guid: handler.guid,
				selector: selector,
				needsContext: selector && jQuery.expr.match.needsContext.test( selector ),
				namespace: namespaces.join( "." )
			}, handleObjIn );

			// Init the event handler queue if we're the first
			if ( !( handlers = events[ type ] ) ) {
				handlers = events[ type ] = [];
				handlers.delegateCount = 0;

				// Only use addEventListener if the special events handler returns false
				if ( !special.setup ||
					special.setup.call( elem, data, namespaces, eventHandle ) === false ) {

					if ( elem.addEventListener ) {
						elem.addEventListener( type, eventHandle );
					}
				}
			}

			if ( special.add ) {
				special.add.call( elem, handleObj );

				if ( !handleObj.handler.guid ) {
					handleObj.handler.guid = handler.guid;
				}
			}

			// Add to the element's handler list, delegates in front
			if ( selector ) {
				handlers.splice( handlers.delegateCount++, 0, handleObj );
			} else {
				handlers.push( handleObj );
			}

			// Keep track of which events have ever been used, for event optimization
			jQuery.event.global[ type ] = true;
		}

	},

	// Detach an event or set of events from an element
	remove: function( elem, types, handler, selector, mappedTypes ) {

		var j, origCount, tmp,
			events, t, handleObj,
			special, handlers, type, namespaces, origType,
			elemData = dataPriv.hasData( elem ) && dataPriv.get( elem );

		if ( !elemData || !( events = elemData.events ) ) {
			return;
		}

		// Once for each type.namespace in types; type may be omitted
		types = ( types || "" ).match( rnothtmlwhite ) || [ "" ];
		t = types.length;
		while ( t-- ) {
			tmp = rtypenamespace.exec( types[ t ] ) || [];
			type = origType = tmp[ 1 ];
			namespaces = ( tmp[ 2 ] || "" ).split( "." ).sort();

			// Unbind all events (on this namespace, if provided) for the element
			if ( !type ) {
				for ( type in events ) {
					jQuery.event.remove( elem, type + types[ t ], handler, selector, true );
				}
				continue;
			}

			special = jQuery.event.special[ type ] || {};
			type = ( selector ? special.delegateType : special.bindType ) || type;
			handlers = events[ type ] || [];
			tmp = tmp[ 2 ] &&
				new RegExp( "(^|\\.)" + namespaces.join( "\\.(?:.*\\.|)" ) + "(\\.|$)" );

			// Remove matching events
			origCount = j = handlers.length;
			while ( j-- ) {
				handleObj = handlers[ j ];

				if ( ( mappedTypes || origType === handleObj.origType ) &&
					( !handler || handler.guid === handleObj.guid ) &&
					( !tmp || tmp.test( handleObj.namespace ) ) &&
					( !selector || selector === handleObj.selector ||
						selector === "**" && handleObj.selector ) ) {
					handlers.splice( j, 1 );

					if ( handleObj.selector ) {
						handlers.delegateCount--;
					}
					if ( special.remove ) {
						special.remove.call( elem, handleObj );
					}
				}
			}

			// Remove generic event handler if we removed something and no more handlers exist
			// (avoids potential for endless recursion during removal of special event handlers)
			if ( origCount && !handlers.length ) {
				if ( !special.teardown ||
					special.teardown.call( elem, namespaces, elemData.handle ) === false ) {

					jQuery.removeEvent( elem, type, elemData.handle );
				}

				delete events[ type ];
			}
		}

		// Remove data and the expando if it's no longer used
		if ( jQuery.isEmptyObject( events ) ) {
			dataPriv.remove( elem, "handle events" );
		}
	},

	dispatch: function( nativeEvent ) {

		// Make a writable jQuery.Event from the native event object
		var event = jQuery.event.fix( nativeEvent );

		var i, j, ret, matched, handleObj, handlerQueue,
			args = new Array( arguments.length ),
			handlers = ( dataPriv.get( this, "events" ) || {} )[ event.type ] || [],
			special = jQuery.event.special[ event.type ] || {};

		// Use the fix-ed jQuery.Event rather than the (read-only) native event
		args[ 0 ] = event;

		for ( i = 1; i < arguments.length; i++ ) {
			args[ i ] = arguments[ i ];
		}

		event.delegateTarget = this;

		// Call the preDispatch hook for the mapped type, and let it bail if desired
		if ( special.preDispatch && special.preDispatch.call( this, event ) === false ) {
			return;
		}

		// Determine handlers
		handlerQueue = jQuery.event.handlers.call( this, event, handlers );

		// Run delegates first; they may want to stop propagation beneath us
		i = 0;
		while ( ( matched = handlerQueue[ i++ ] ) && !event.isPropagationStopped() ) {
			event.currentTarget = matched.elem;

			j = 0;
			while ( ( handleObj = matched.handlers[ j++ ] ) &&
				!event.isImmediatePropagationStopped() ) {

				// Triggered event must either 1) have no namespace, or 2) have namespace(s)
				// a subset or equal to those in the bound event (both can have no namespace).
				if ( !event.rnamespace || event.rnamespace.test( handleObj.namespace ) ) {

					event.handleObj = handleObj;
					event.data = handleObj.data;

					ret = ( ( jQuery.event.special[ handleObj.origType ] || {} ).handle ||
						handleObj.handler ).apply( matched.elem, args );

					if ( ret !== undefined ) {
						if ( ( event.result = ret ) === false ) {
							event.preventDefault();
							event.stopPropagation();
						}
					}
				}
			}
		}

		// Call the postDispatch hook for the mapped type
		if ( special.postDispatch ) {
			special.postDispatch.call( this, event );
		}

		return event.result;
	},

	handlers: function( event, handlers ) {
		var i, handleObj, sel, matchedHandlers, matchedSelectors,
			handlerQueue = [],
			delegateCount = handlers.delegateCount,
			cur = event.target;

		// Find delegate handlers
		if ( delegateCount &&

			// Support: IE <=9
			// Black-hole SVG <use> instance trees (trac-13180)
			cur.nodeType &&

			// Support: Firefox <=42
			// Suppress spec-violating clicks indicating a non-primary pointer button (trac-3861)
			// https://www.w3.org/TR/DOM-Level-3-Events/#event-type-click
			// Support: IE 11 only
			// ...but not arrow key "clicks" of radio inputs, which can have `button` -1 (gh-2343)
			!( event.type === "click" && event.button >= 1 ) ) {

			for ( ; cur !== this; cur = cur.parentNode || this ) {

				// Don't check non-elements (#13208)
				// Don't process clicks on disabled elements (#6911, #8165, #11382, #11764)
				if ( cur.nodeType === 1 && !( event.type === "click" && cur.disabled === true ) ) {
					matchedHandlers = [];
					matchedSelectors = {};
					for ( i = 0; i < delegateCount; i++ ) {
						handleObj = handlers[ i ];

						// Don't conflict with Object.prototype properties (#13203)
						sel = handleObj.selector + " ";

						if ( matchedSelectors[ sel ] === undefined ) {
							matchedSelectors[ sel ] = handleObj.needsContext ?
								jQuery( sel, this ).index( cur ) > -1 :
								jQuery.find( sel, this, null, [ cur ] ).length;
						}
						if ( matchedSelectors[ sel ] ) {
							matchedHandlers.push( handleObj );
						}
					}
					if ( matchedHandlers.length ) {
						handlerQueue.push( { elem: cur, handlers: matchedHandlers } );
					}
				}
			}
		}

		// Add the remaining (directly-bound) handlers
		cur = this;
		if ( delegateCount < handlers.length ) {
			handlerQueue.push( { elem: cur, handlers: handlers.slice( delegateCount ) } );
		}

		return handlerQueue;
	},

	addProp: function( name, hook ) {
		Object.defineProperty( jQuery.Event.prototype, name, {
			enumerable: true,
			configurable: true,

			get: jQuery.isFunction( hook ) ?
				function() {
					if ( this.originalEvent ) {
							return hook( this.originalEvent );
					}
				} :
				function() {
					if ( this.originalEvent ) {
							return this.originalEvent[ name ];
					}
				},

			set: function( value ) {
				Object.defineProperty( this, name, {
					enumerable: true,
					configurable: true,
					writable: true,
					value: value
				} );
			}
		} );
	},

	fix: function( originalEvent ) {
		return originalEvent[ jQuery.expando ] ?
			originalEvent :
			new jQuery.Event( originalEvent );
	},

	special: {
		load: {

			// Prevent triggered image.load events from bubbling to window.load
			noBubble: true
		},
		focus: {

			// Fire native event if possible so blur/focus sequence is correct
			trigger: function() {
				if ( this !== safeActiveElement() && this.focus ) {
					this.focus();
					return false;
				}
			},
			delegateType: "focusin"
		},
		blur: {
			trigger: function() {
				if ( this === safeActiveElement() && this.blur ) {
					this.blur();
					return false;
				}
			},
			delegateType: "focusout"
		},
		click: {

			// For checkbox, fire native event so checked state will be right
			trigger: function() {
				if ( this.type === "checkbox" && this.click && nodeName( this, "input" ) ) {
					this.click();
					return false;
				}
			},

			// For cross-browser consistency, don't fire native .click() on links
			_default: function( event ) {
				return nodeName( event.target, "a" );
			}
		},

		beforeunload: {
			postDispatch: function( event ) {

				// Support: Firefox 20+
				// Firefox doesn't alert if the returnValue field is not set.
				if ( event.result !== undefined && event.originalEvent ) {
					event.originalEvent.returnValue = event.result;
				}
			}
		}
	}
};

jQuery.removeEvent = function( elem, type, handle ) {

	// This "if" is needed for plain objects
	if ( elem.removeEventListener ) {
		elem.removeEventListener( type, handle );
	}
};

jQuery.Event = function( src, props ) {

	// Allow instantiation without the 'new' keyword
	if ( !( this instanceof jQuery.Event ) ) {
		return new jQuery.Event( src, props );
	}

	// Event object
	if ( src && src.type ) {
		this.originalEvent = src;
		this.type = src.type;

		// Events bubbling up the document may have been marked as prevented
		// by a handler lower down the tree; reflect the correct value.
		this.isDefaultPrevented = src.defaultPrevented ||
				src.defaultPrevented === undefined &&

				// Support: Android <=2.3 only
				src.returnValue === false ?
			returnTrue :
			returnFalse;

		// Create target properties
		// Support: Safari <=6 - 7 only
		// Target should not be a text node (#504, #13143)
		this.target = ( src.target && src.target.nodeType === 3 ) ?
			src.target.parentNode :
			src.target;

		this.currentTarget = src.currentTarget;
		this.relatedTarget = src.relatedTarget;

	// Event type
	} else {
		this.type = src;
	}

	// Put explicitly provided properties onto the event object
	if ( props ) {
		jQuery.extend( this, props );
	}

	// Create a timestamp if incoming event doesn't have one
	this.timeStamp = src && src.timeStamp || jQuery.now();

	// Mark it as fixed
	this[ jQuery.expando ] = true;
};

// jQuery.Event is based on DOM3 Events as specified by the ECMAScript Language Binding
// https://www.w3.org/TR/2003/WD-DOM-Level-3-Events-20030331/ecma-script-binding.html
jQuery.Event.prototype = {
	constructor: jQuery.Event,
	isDefaultPrevented: returnFalse,
	isPropagationStopped: returnFalse,
	isImmediatePropagationStopped: returnFalse,
	isSimulated: false,

	preventDefault: function() {
		var e = this.originalEvent;

		this.isDefaultPrevented = returnTrue;

		if ( e && !this.isSimulated ) {
			e.preventDefault();
		}
	},
	stopPropagation: function() {
		var e = this.originalEvent;

		this.isPropagationStopped = returnTrue;

		if ( e && !this.isSimulated ) {
			e.stopPropagation();
		}
	},
	stopImmediatePropagation: function() {
		var e = this.originalEvent;

		this.isImmediatePropagationStopped = returnTrue;

		if ( e && !this.isSimulated ) {
			e.stopImmediatePropagation();
		}

		this.stopPropagation();
	}
};

// Includes all common event props including KeyEvent and MouseEvent specific props
jQuery.each( {
	altKey: true,
	bubbles: true,
	cancelable: true,
	changedTouches: true,
	ctrlKey: true,
	detail: true,
	eventPhase: true,
	metaKey: true,
	pageX: true,
	pageY: true,
	shiftKey: true,
	view: true,
	"char": true,
	charCode: true,
	key: true,
	keyCode: true,
	button: true,
	buttons: true,
	clientX: true,
	clientY: true,
	offsetX: true,
	offsetY: true,
	pointerId: true,
	pointerType: true,
	screenX: true,
	screenY: true,
	targetTouches: true,
	toElement: true,
	touches: true,

	which: function( event ) {
		var button = event.button;

		// Add which for key events
		if ( event.which == null && rkeyEvent.test( event.type ) ) {
			return event.charCode != null ? event.charCode : event.keyCode;
		}

		// Add which for click: 1 === left; 2 === middle; 3 === right
		if ( !event.which && button !== undefined && rmouseEvent.test( event.type ) ) {
			if ( button & 1 ) {
				return 1;
			}

			if ( button & 2 ) {
				return 3;
			}

			if ( button & 4 ) {
				return 2;
			}

			return 0;
		}

		return event.which;
	}
}, jQuery.event.addProp );

// Create mouseenter/leave events using mouseover/out and event-time checks
// so that event delegation works in jQuery.
// Do the same for pointerenter/pointerleave and pointerover/pointerout
//
// Support: Safari 7 only
// Safari sends mouseenter too often; see:
// https://bugs.chromium.org/p/chromium/issues/detail?id=470258
// for the description of the bug (it existed in older Chrome versions as well).
jQuery.each( {
	mouseenter: "mouseover",
	mouseleave: "mouseout",
	pointerenter: "pointerover",
	pointerleave: "pointerout"
}, function( orig, fix ) {
	jQuery.event.special[ orig ] = {
		delegateType: fix,
		bindType: fix,

		handle: function( event ) {
			var ret,
				target = this,
				related = event.relatedTarget,
				handleObj = event.handleObj;

			// For mouseenter/leave call the handler if related is outside the target.
			// NB: No relatedTarget if the mouse left/entered the browser window
			if ( !related || ( related !== target && !jQuery.contains( target, related ) ) ) {
				event.type = handleObj.origType;
				ret = handleObj.handler.apply( this, arguments );
				event.type = fix;
			}
			return ret;
		}
	};
} );

jQuery.fn.extend( {

	on: function( types, selector, data, fn ) {
		return on( this, types, selector, data, fn );
	},
	one: function( types, selector, data, fn ) {
		return on( this, types, selector, data, fn, 1 );
	},
	off: function( types, selector, fn ) {
		var handleObj, type;
		if ( types && types.preventDefault && types.handleObj ) {

			// ( event )  dispatched jQuery.Event
			handleObj = types.handleObj;
			jQuery( types.delegateTarget ).off(
				handleObj.namespace ?
					handleObj.origType + "." + handleObj.namespace :
					handleObj.origType,
				handleObj.selector,
				handleObj.handler
			);
			return this;
		}
		if ( typeof types === "object" ) {

			// ( types-object [, selector] )
			for ( type in types ) {
				this.off( type, selector, types[ type ] );
			}
			return this;
		}
		if ( selector === false || typeof selector === "function" ) {

			// ( types [, fn] )
			fn = selector;
			selector = undefined;
		}
		if ( fn === false ) {
			fn = returnFalse;
		}
		return this.each( function() {
			jQuery.event.remove( this, types, fn, selector );
		} );
	}
} );


var

	/* eslint-disable max-len */

	// See https://github.com/eslint/eslint/issues/3229
	rxhtmlTag = /<(?!area|br|col|embed|hr|img|input|link|meta|param)(([a-z][^\/\0>\x20\t\r\n\f]*)[^>]*)\/>/gi,

	/* eslint-enable */

	// Support: IE <=10 - 11, Edge 12 - 13
	// In IE/Edge using regex groups here causes severe slowdowns.
	// See https://connect.microsoft.com/IE/feedback/details/1736512/
	rnoInnerhtml = /<script|<style|<link/i,

	// checked="checked" or checked
	rchecked = /checked\s*(?:[^=]|=\s*.checked.)/i,
	rscriptTypeMasked = /^true\/(.*)/,
	rcleanScript = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g;

// Prefer a tbody over its parent table for containing new rows
function manipulationTarget( elem, content ) {
	if ( nodeName( elem, "table" ) &&
		nodeName( content.nodeType !== 11 ? content : content.firstChild, "tr" ) ) {

		return jQuery( ">tbody", elem )[ 0 ] || elem;
	}

	return elem;
}

// Replace/restore the type attribute of script elements for safe DOM manipulation
function disableScript( elem ) {
	elem.type = ( elem.getAttribute( "type" ) !== null ) + "/" + elem.type;
	return elem;
}
function restoreScript( elem ) {
	var match = rscriptTypeMasked.exec( elem.type );

	if ( match ) {
		elem.type = match[ 1 ];
	} else {
		elem.removeAttribute( "type" );
	}

	return elem;
}

function cloneCopyEvent( src, dest ) {
	var i, l, type, pdataOld, pdataCur, udataOld, udataCur, events;

	if ( dest.nodeType !== 1 ) {
		return;
	}

	// 1. Copy private data: events, handlers, etc.
	if ( dataPriv.hasData( src ) ) {
		pdataOld = dataPriv.access( src );
		pdataCur = dataPriv.set( dest, pdataOld );
		events = pdataOld.events;

		if ( events ) {
			delete pdataCur.handle;
			pdataCur.events = {};

			for ( type in events ) {
				for ( i = 0, l = events[ type ].length; i < l; i++ ) {
					jQuery.event.add( dest, type, events[ type ][ i ] );
				}
			}
		}
	}

	// 2. Copy user data
	if ( dataUser.hasData( src ) ) {
		udataOld = dataUser.access( src );
		udataCur = jQuery.extend( {}, udataOld );

		dataUser.set( dest, udataCur );
	}
}

// Fix IE bugs, see support tests
function fixInput( src, dest ) {
	var nodeName = dest.nodeName.toLowerCase();

	// Fails to persist the checked state of a cloned checkbox or radio button.
	if ( nodeName === "input" && rcheckableType.test( src.type ) ) {
		dest.checked = src.checked;

	// Fails to return the selected option to the default selected state when cloning options
	} else if ( nodeName === "input" || nodeName === "textarea" ) {
		dest.defaultValue = src.defaultValue;
	}
}

function domManip( collection, args, callback, ignored ) {

	// Flatten any nested arrays
	args = concat.apply( [], args );

	var fragment, first, scripts, hasScripts, node, doc,
		i = 0,
		l = collection.length,
		iNoClone = l - 1,
		value = args[ 0 ],
		isFunction = jQuery.isFunction( value );

	// We can't cloneNode fragments that contain checked, in WebKit
	if ( isFunction ||
			( l > 1 && typeof value === "string" &&
				!support.checkClone && rchecked.test( value ) ) ) {
		return collection.each( function( index ) {
			var self = collection.eq( index );
			if ( isFunction ) {
				args[ 0 ] = value.call( this, index, self.html() );
			}
			domManip( self, args, callback, ignored );
		} );
	}

	if ( l ) {
		fragment = buildFragment( args, collection[ 0 ].ownerDocument, false, collection, ignored );
		first = fragment.firstChild;

		if ( fragment.childNodes.length === 1 ) {
			fragment = first;
		}

		// Require either new content or an interest in ignored elements to invoke the callback
		if ( first || ignored ) {
			scripts = jQuery.map( getAll( fragment, "script" ), disableScript );
			hasScripts = scripts.length;

			// Use the original fragment for the last item
			// instead of the first because it can end up
			// being emptied incorrectly in certain situations (#8070).
			for ( ; i < l; i++ ) {
				node = fragment;

				if ( i !== iNoClone ) {
					node = jQuery.clone( node, true, true );

					// Keep references to cloned scripts for later restoration
					if ( hasScripts ) {

						// Support: Android <=4.0 only, PhantomJS 1 only
						// push.apply(_, arraylike) throws on ancient WebKit
						jQuery.merge( scripts, getAll( node, "script" ) );
					}
				}

				callback.call( collection[ i ], node, i );
			}

			if ( hasScripts ) {
				doc = scripts[ scripts.length - 1 ].ownerDocument;

				// Reenable scripts
				jQuery.map( scripts, restoreScript );

				// Evaluate executable scripts on first document insertion
				for ( i = 0; i < hasScripts; i++ ) {
					node = scripts[ i ];
					if ( rscriptType.test( node.type || "" ) &&
						!dataPriv.access( node, "globalEval" ) &&
						jQuery.contains( doc, node ) ) {

						if ( node.src ) {

							// Optional AJAX dependency, but won't run scripts if not present
							if ( jQuery._evalUrl ) {
								jQuery._evalUrl( node.src );
							}
						} else {
							DOMEval( node.textContent.replace( rcleanScript, "" ), doc );
						}
					}
				}
			}
		}
	}

	return collection;
}

function remove( elem, selector, keepData ) {
	var node,
		nodes = selector ? jQuery.filter( selector, elem ) : elem,
		i = 0;

	for ( ; ( node = nodes[ i ] ) != null; i++ ) {
		if ( !keepData && node.nodeType === 1 ) {
			jQuery.cleanData( getAll( node ) );
		}

		if ( node.parentNode ) {
			if ( keepData && jQuery.contains( node.ownerDocument, node ) ) {
				setGlobalEval( getAll( node, "script" ) );
			}
			node.parentNode.removeChild( node );
		}
	}

	return elem;
}

jQuery.extend( {
	htmlPrefilter: function( html ) {
		return html.replace( rxhtmlTag, "<$1></$2>" );
	},

	clone: function( elem, dataAndEvents, deepDataAndEvents ) {
		var i, l, srcElements, destElements,
			clone = elem.cloneNode( true ),
			inPage = jQuery.contains( elem.ownerDocument, elem );

		// Fix IE cloning issues
		if ( !support.noCloneChecked && ( elem.nodeType === 1 || elem.nodeType === 11 ) &&
				!jQuery.isXMLDoc( elem ) ) {

			// We eschew Sizzle here for performance reasons: https://jsperf.com/getall-vs-sizzle/2
			destElements = getAll( clone );
			srcElements = getAll( elem );

			for ( i = 0, l = srcElements.length; i < l; i++ ) {
				fixInput( srcElements[ i ], destElements[ i ] );
			}
		}

		// Copy the events from the original to the clone
		if ( dataAndEvents ) {
			if ( deepDataAndEvents ) {
				srcElements = srcElements || getAll( elem );
				destElements = destElements || getAll( clone );

				for ( i = 0, l = srcElements.length; i < l; i++ ) {
					cloneCopyEvent( srcElements[ i ], destElements[ i ] );
				}
			} else {
				cloneCopyEvent( elem, clone );
			}
		}

		// Preserve script evaluation history
		destElements = getAll( clone, "script" );
		if ( destElements.length > 0 ) {
			setGlobalEval( destElements, !inPage && getAll( elem, "script" ) );
		}

		// Return the cloned set
		return clone;
	},

	cleanData: function( elems ) {
		var data, elem, type,
			special = jQuery.event.special,
			i = 0;

		for ( ; ( elem = elems[ i ] ) !== undefined; i++ ) {
			if ( acceptData( elem ) ) {
				if ( ( data = elem[ dataPriv.expando ] ) ) {
					if ( data.events ) {
						for ( type in data.events ) {
							if ( special[ type ] ) {
								jQuery.event.remove( elem, type );

							// This is a shortcut to avoid jQuery.event.remove's overhead
							} else {
								jQuery.removeEvent( elem, type, data.handle );
							}
						}
					}

					// Support: Chrome <=35 - 45+
					// Assign undefined instead of using delete, see Data#remove
					elem[ dataPriv.expando ] = undefined;
				}
				if ( elem[ dataUser.expando ] ) {

					// Support: Chrome <=35 - 45+
					// Assign undefined instead of using delete, see Data#remove
					elem[ dataUser.expando ] = undefined;
				}
			}
		}
	}
} );

jQuery.fn.extend( {
	detach: function( selector ) {
		return remove( this, selector, true );
	},

	remove: function( selector ) {
		return remove( this, selector );
	},

	text: function( value ) {
		return access( this, function( value ) {
			return value === undefined ?
				jQuery.text( this ) :
				this.empty().each( function() {
					if ( this.nodeType === 1 || this.nodeType === 11 || this.nodeType === 9 ) {
						this.textContent = value;
					}
				} );
		}, null, value, arguments.length );
	},

	append: function() {
		return domManip( this, arguments, function( elem ) {
			if ( this.nodeType === 1 || this.nodeType === 11 || this.nodeType === 9 ) {
				var target = manipulationTarget( this, elem );
				target.appendChild( elem );
			}
		} );
	},

	prepend: function() {
		return domManip( this, arguments, function( elem ) {
			if ( this.nodeType === 1 || this.nodeType === 11 || this.nodeType === 9 ) {
				var target = manipulationTarget( this, elem );
				target.insertBefore( elem, target.firstChild );
			}
		} );
	},

	before: function() {
		return domManip( this, arguments, function( elem ) {
			if ( this.parentNode ) {
				this.parentNode.insertBefore( elem, this );
			}
		} );
	},

	after: function() {
		return domManip( this, arguments, function( elem ) {
			if ( this.parentNode ) {
				this.parentNode.insertBefore( elem, this.nextSibling );
			}
		} );
	},

	empty: function() {
		var elem,
			i = 0;

		for ( ; ( elem = this[ i ] ) != null; i++ ) {
			if ( elem.nodeType === 1 ) {

				// Prevent memory leaks
				jQuery.cleanData( getAll( elem, false ) );

				// Remove any remaining nodes
				elem.textContent = "";
			}
		}

		return this;
	},

	clone: function( dataAndEvents, deepDataAndEvents ) {
		dataAndEvents = dataAndEvents == null ? false : dataAndEvents;
		deepDataAndEvents = deepDataAndEvents == null ? dataAndEvents : deepDataAndEvents;

		return this.map( function() {
			return jQuery.clone( this, dataAndEvents, deepDataAndEvents );
		} );
	},

	html: function( value ) {
		return access( this, function( value ) {
			var elem = this[ 0 ] || {},
				i = 0,
				l = this.length;

			if ( value === undefined && elem.nodeType === 1 ) {
				return elem.innerHTML;
			}

			// See if we can take a shortcut and just use innerHTML
			if ( typeof value === "string" && !rnoInnerhtml.test( value ) &&
				!wrapMap[ ( rtagName.exec( value ) || [ "", "" ] )[ 1 ].toLowerCase() ] ) {

				value = jQuery.htmlPrefilter( value );

				try {
					for ( ; i < l; i++ ) {
						elem = this[ i ] || {};

						// Remove element nodes and prevent memory leaks
						if ( elem.nodeType === 1 ) {
							jQuery.cleanData( getAll( elem, false ) );
							elem.innerHTML = value;
						}
					}

					elem = 0;

				// If using innerHTML throws an exception, use the fallback method
				} catch ( e ) {}
			}

			if ( elem ) {
				this.empty().append( value );
			}
		}, null, value, arguments.length );
	},

	replaceWith: function() {
		var ignored = [];

		// Make the changes, replacing each non-ignored context element with the new content
		return domManip( this, arguments, function( elem ) {
			var parent = this.parentNode;

			if ( jQuery.inArray( this, ignored ) < 0 ) {
				jQuery.cleanData( getAll( this ) );
				if ( parent ) {
					parent.replaceChild( elem, this );
				}
			}

		// Force callback invocation
		}, ignored );
	}
} );

jQuery.each( {
	appendTo: "append",
	prependTo: "prepend",
	insertBefore: "before",
	insertAfter: "after",
	replaceAll: "replaceWith"
}, function( name, original ) {
	jQuery.fn[ name ] = function( selector ) {
		var elems,
			ret = [],
			insert = jQuery( selector ),
			last = insert.length - 1,
			i = 0;

		for ( ; i <= last; i++ ) {
			elems = i === last ? this : this.clone( true );
			jQuery( insert[ i ] )[ original ]( elems );

			// Support: Android <=4.0 only, PhantomJS 1 only
			// .get() because push.apply(_, arraylike) throws on ancient WebKit
			push.apply( ret, elems.get() );
		}

		return this.pushStack( ret );
	};
} );
var rmargin = ( /^margin/ );

var rnumnonpx = new RegExp( "^(" + pnum + ")(?!px)[a-z%]+$", "i" );

var getStyles = function( elem ) {

		// Support: IE <=11 only, Firefox <=30 (#15098, #14150)
		// IE throws on elements created in popups
		// FF meanwhile throws on frame elements through "defaultView.getComputedStyle"
		var view = elem.ownerDocument.defaultView;

		if ( !view || !view.opener ) {
			view = window;
		}

		return view.getComputedStyle( elem );
	};



( function() {

	// Executing both pixelPosition & boxSizingReliable tests require only one layout
	// so they're executed at the same time to save the second computation.
	function computeStyleTests() {

		// This is a singleton, we need to execute it only once
		if ( !div ) {
			return;
		}

		div.style.cssText =
			"box-sizing:border-box;" +
			"position:relative;display:block;" +
			"margin:auto;border:1px;padding:1px;" +
			"top:1%;width:50%";
		div.innerHTML = "";
		documentElement.appendChild( container );

		var divStyle = window.getComputedStyle( div );
		pixelPositionVal = divStyle.top !== "1%";

		// Support: Android 4.0 - 4.3 only, Firefox <=3 - 44
		reliableMarginLeftVal = divStyle.marginLeft === "2px";
		boxSizingReliableVal = divStyle.width === "4px";

		// Support: Android 4.0 - 4.3 only
		// Some styles come back with percentage values, even though they shouldn't
		div.style.marginRight = "50%";
		pixelMarginRightVal = divStyle.marginRight === "4px";

		documentElement.removeChild( container );

		// Nullify the div so it wouldn't be stored in the memory and
		// it will also be a sign that checks already performed
		div = null;
	}

	var pixelPositionVal, boxSizingReliableVal, pixelMarginRightVal, reliableMarginLeftVal,
		container = document.createElement( "div" ),
		div = document.createElement( "div" );

	// Finish early in limited (non-browser) environments
	if ( !div.style ) {
		return;
	}

	// Support: IE <=9 - 11 only
	// Style of cloned element affects source element cloned (#8908)
	div.style.backgroundClip = "content-box";
	div.cloneNode( true ).style.backgroundClip = "";
	support.clearCloneStyle = div.style.backgroundClip === "content-box";

	container.style.cssText = "border:0;width:8px;height:0;top:0;left:-9999px;" +
		"padding:0;margin-top:1px;position:absolute";
	container.appendChild( div );

	jQuery.extend( support, {
		pixelPosition: function() {
			computeStyleTests();
			return pixelPositionVal;
		},
		boxSizingReliable: function() {
			computeStyleTests();
			return boxSizingReliableVal;
		},
		pixelMarginRight: function() {
			computeStyleTests();
			return pixelMarginRightVal;
		},
		reliableMarginLeft: function() {
			computeStyleTests();
			return reliableMarginLeftVal;
		}
	} );
} )();


function curCSS( elem, name, computed ) {
	var width, minWidth, maxWidth, ret,

		// Support: Firefox 51+
		// Retrieving style before computed somehow
		// fixes an issue with getting wrong values
		// on detached elements
		style = elem.style;

	computed = computed || getStyles( elem );

	// getPropertyValue is needed for:
	//   .css('filter') (IE 9 only, #12537)
	//   .css('--customProperty) (#3144)
	if ( computed ) {
		ret = computed.getPropertyValue( name ) || computed[ name ];

		if ( ret === "" && !jQuery.contains( elem.ownerDocument, elem ) ) {
			ret = jQuery.style( elem, name );
		}

		// A tribute to the "awesome hack by Dean Edwards"
		// Android Browser returns percentage for some values,
		// but width seems to be reliably pixels.
		// This is against the CSSOM draft spec:
		// https://drafts.csswg.org/cssom/#resolved-values
		if ( !support.pixelMarginRight() && rnumnonpx.test( ret ) && rmargin.test( name ) ) {

			// Remember the original values
			width = style.width;
			minWidth = style.minWidth;
			maxWidth = style.maxWidth;

			// Put in the new values to get a computed value out
			style.minWidth = style.maxWidth = style.width = ret;
			ret = computed.width;

			// Revert the changed values
			style.width = width;
			style.minWidth = minWidth;
			style.maxWidth = maxWidth;
		}
	}

	return ret !== undefined ?

		// Support: IE <=9 - 11 only
		// IE returns zIndex value as an integer.
		ret + "" :
		ret;
}


function addGetHookIf( conditionFn, hookFn ) {

	// Define the hook, we'll check on the first run if it's really needed.
	return {
		get: function() {
			if ( conditionFn() ) {

				// Hook not needed (or it's not possible to use it due
				// to missing dependency), remove it.
				delete this.get;
				return;
			}

			// Hook needed; redefine it so that the support test is not executed again.
			return ( this.get = hookFn ).apply( this, arguments );
		}
	};
}


var

	// Swappable if display is none or starts with table
	// except "table", "table-cell", or "table-caption"
	// See here for display values: https://developer.mozilla.org/en-US/docs/CSS/display
	rdisplayswap = /^(none|table(?!-c[ea]).+)/,
	rcustomProp = /^--/,
	cssShow = { position: "absolute", visibility: "hidden", display: "block" },
	cssNormalTransform = {
		letterSpacing: "0",
		fontWeight: "400"
	},

	cssPrefixes = [ "Webkit", "Moz", "ms" ],
	emptyStyle = document.createElement( "div" ).style;

// Return a css property mapped to a potentially vendor prefixed property
function vendorPropName( name ) {

	// Shortcut for names that are not vendor prefixed
	if ( name in emptyStyle ) {
		return name;
	}

	// Check for vendor prefixed names
	var capName = name[ 0 ].toUpperCase() + name.slice( 1 ),
		i = cssPrefixes.length;

	while ( i-- ) {
		name = cssPrefixes[ i ] + capName;
		if ( name in emptyStyle ) {
			return name;
		}
	}
}

// Return a property mapped along what jQuery.cssProps suggests or to
// a vendor prefixed property.
function finalPropName( name ) {
	var ret = jQuery.cssProps[ name ];
	if ( !ret ) {
		ret = jQuery.cssProps[ name ] = vendorPropName( name ) || name;
	}
	return ret;
}

function setPositiveNumber( elem, value, subtract ) {

	// Any relative (+/-) values have already been
	// normalized at this point
	var matches = rcssNum.exec( value );
	return matches ?

		// Guard against undefined "subtract", e.g., when used as in cssHooks
		Math.max( 0, matches[ 2 ] - ( subtract || 0 ) ) + ( matches[ 3 ] || "px" ) :
		value;
}

function augmentWidthOrHeight( elem, name, extra, isBorderBox, styles ) {
	var i,
		val = 0;

	// If we already have the right measurement, avoid augmentation
	if ( extra === ( isBorderBox ? "border" : "content" ) ) {
		i = 4;

	// Otherwise initialize for horizontal or vertical properties
	} else {
		i = name === "width" ? 1 : 0;
	}

	for ( ; i < 4; i += 2 ) {

		// Both box models exclude margin, so add it if we want it
		if ( extra === "margin" ) {
			val += jQuery.css( elem, extra + cssExpand[ i ], true, styles );
		}

		if ( isBorderBox ) {

			// border-box includes padding, so remove it if we want content
			if ( extra === "content" ) {
				val -= jQuery.css( elem, "padding" + cssExpand[ i ], true, styles );
			}

			// At this point, extra isn't border nor margin, so remove border
			if ( extra !== "margin" ) {
				val -= jQuery.css( elem, "border" + cssExpand[ i ] + "Width", true, styles );
			}
		} else {

			// At this point, extra isn't content, so add padding
			val += jQuery.css( elem, "padding" + cssExpand[ i ], true, styles );

			// At this point, extra isn't content nor padding, so add border
			if ( extra !== "padding" ) {
				val += jQuery.css( elem, "border" + cssExpand[ i ] + "Width", true, styles );
			}
		}
	}

	return val;
}

function getWidthOrHeight( elem, name, extra ) {

	// Start with computed style
	var valueIsBorderBox,
		styles = getStyles( elem ),
		val = curCSS( elem, name, styles ),
		isBorderBox = jQuery.css( elem, "boxSizing", false, styles ) === "border-box";

	// Computed unit is not pixels. Stop here and return.
	if ( rnumnonpx.test( val ) ) {
		return val;
	}

	// Check for style in case a browser which returns unreliable values
	// for getComputedStyle silently falls back to the reliable elem.style
	valueIsBorderBox = isBorderBox &&
		( support.boxSizingReliable() || val === elem.style[ name ] );

	// Fall back to offsetWidth/Height when value is "auto"
	// This happens for inline elements with no explicit setting (gh-3571)
	if ( val === "auto" ) {
		val = elem[ "offset" + name[ 0 ].toUpperCase() + name.slice( 1 ) ];
	}

	// Normalize "", auto, and prepare for extra
	val = parseFloat( val ) || 0;

	// Use the active box-sizing model to add/subtract irrelevant styles
	return ( val +
		augmentWidthOrHeight(
			elem,
			name,
			extra || ( isBorderBox ? "border" : "content" ),
			valueIsBorderBox,
			styles
		)
	) + "px";
}

jQuery.extend( {

	// Add in style property hooks for overriding the default
	// behavior of getting and setting a style property
	cssHooks: {
		opacity: {
			get: function( elem, computed ) {
				if ( computed ) {

					// We should always get a number back from opacity
					var ret = curCSS( elem, "opacity" );
					return ret === "" ? "1" : ret;
				}
			}
		}
	},

	// Don't automatically add "px" to these possibly-unitless properties
	cssNumber: {
		"animationIterationCount": true,
		"columnCount": true,
		"fillOpacity": true,
		"flexGrow": true,
		"flexShrink": true,
		"fontWeight": true,
		"lineHeight": true,
		"opacity": true,
		"order": true,
		"orphans": true,
		"widows": true,
		"zIndex": true,
		"zoom": true
	},

	// Add in properties whose names you wish to fix before
	// setting or getting the value
	cssProps: {
		"float": "cssFloat"
	},

	// Get and set the style property on a DOM Node
	style: function( elem, name, value, extra ) {

		// Don't set styles on text and comment nodes
		if ( !elem || elem.nodeType === 3 || elem.nodeType === 8 || !elem.style ) {
			return;
		}

		// Make sure that we're working with the right name
		var ret, type, hooks,
			origName = jQuery.camelCase( name ),
			isCustomProp = rcustomProp.test( name ),
			style = elem.style;

		// Make sure that we're working with the right name. We don't
		// want to query the value if it is a CSS custom property
		// since they are user-defined.
		if ( !isCustomProp ) {
			name = finalPropName( origName );
		}

		// Gets hook for the prefixed version, then unprefixed version
		hooks = jQuery.cssHooks[ name ] || jQuery.cssHooks[ origName ];

		// Check if we're setting a value
		if ( value !== undefined ) {
			type = typeof value;

			// Convert "+=" or "-=" to relative numbers (#7345)
			if ( type === "string" && ( ret = rcssNum.exec( value ) ) && ret[ 1 ] ) {
				value = adjustCSS( elem, name, ret );

				// Fixes bug #9237
				type = "number";
			}

			// Make sure that null and NaN values aren't set (#7116)
			if ( value == null || value !== value ) {
				return;
			}

			// If a number was passed in, add the unit (except for certain CSS properties)
			if ( type === "number" ) {
				value += ret && ret[ 3 ] || ( jQuery.cssNumber[ origName ] ? "" : "px" );
			}

			// background-* props affect original clone's values
			if ( !support.clearCloneStyle && value === "" && name.indexOf( "background" ) === 0 ) {
				style[ name ] = "inherit";
			}

			// If a hook was provided, use that value, otherwise just set the specified value
			if ( !hooks || !( "set" in hooks ) ||
				( value = hooks.set( elem, value, extra ) ) !== undefined ) {

				if ( isCustomProp ) {
					style.setProperty( name, value );
				} else {
					style[ name ] = value;
				}
			}

		} else {

			// If a hook was provided get the non-computed value from there
			if ( hooks && "get" in hooks &&
				( ret = hooks.get( elem, false, extra ) ) !== undefined ) {

				return ret;
			}

			// Otherwise just get the value from the style object
			return style[ name ];
		}
	},

	css: function( elem, name, extra, styles ) {
		var val, num, hooks,
			origName = jQuery.camelCase( name ),
			isCustomProp = rcustomProp.test( name );

		// Make sure that we're working with the right name. We don't
		// want to modify the value if it is a CSS custom property
		// since they are user-defined.
		if ( !isCustomProp ) {
			name = finalPropName( origName );
		}

		// Try prefixed name followed by the unprefixed name
		hooks = jQuery.cssHooks[ name ] || jQuery.cssHooks[ origName ];

		// If a hook was provided get the computed value from there
		if ( hooks && "get" in hooks ) {
			val = hooks.get( elem, true, extra );
		}

		// Otherwise, if a way to get the computed value exists, use that
		if ( val === undefined ) {
			val = curCSS( elem, name, styles );
		}

		// Convert "normal" to computed value
		if ( val === "normal" && name in cssNormalTransform ) {
			val = cssNormalTransform[ name ];
		}

		// Make numeric if forced or a qualifier was provided and val looks numeric
		if ( extra === "" || extra ) {
			num = parseFloat( val );
			return extra === true || isFinite( num ) ? num || 0 : val;
		}

		return val;
	}
} );

jQuery.each( [ "height", "width" ], function( i, name ) {
	jQuery.cssHooks[ name ] = {
		get: function( elem, computed, extra ) {
			if ( computed ) {

				// Certain elements can have dimension info if we invisibly show them
				// but it must have a current display style that would benefit
				return rdisplayswap.test( jQuery.css( elem, "display" ) ) &&

					// Support: Safari 8+
					// Table columns in Safari have non-zero offsetWidth & zero
					// getBoundingClientRect().width unless display is changed.
					// Support: IE <=11 only
					// Running getBoundingClientRect on a disconnected node
					// in IE throws an error.
					( !elem.getClientRects().length || !elem.getBoundingClientRect().width ) ?
						swap( elem, cssShow, function() {
							return getWidthOrHeight( elem, name, extra );
						} ) :
						getWidthOrHeight( elem, name, extra );
			}
		},

		set: function( elem, value, extra ) {
			var matches,
				styles = extra && getStyles( elem ),
				subtract = extra && augmentWidthOrHeight(
					elem,
					name,
					extra,
					jQuery.css( elem, "boxSizing", false, styles ) === "border-box",
					styles
				);

			// Convert to pixels if value adjustment is needed
			if ( subtract && ( matches = rcssNum.exec( value ) ) &&
				( matches[ 3 ] || "px" ) !== "px" ) {

				elem.style[ name ] = value;
				value = jQuery.css( elem, name );
			}

			return setPositiveNumber( elem, value, subtract );
		}
	};
} );

jQuery.cssHooks.marginLeft = addGetHookIf( support.reliableMarginLeft,
	function( elem, computed ) {
		if ( computed ) {
			return ( parseFloat( curCSS( elem, "marginLeft" ) ) ||
				elem.getBoundingClientRect().left -
					swap( elem, { marginLeft: 0 }, function() {
						return elem.getBoundingClientRect().left;
					} )
				) + "px";
		}
	}
);

// These hooks are used by animate to expand properties
jQuery.each( {
	margin: "",
	padding: "",
	border: "Width"
}, function( prefix, suffix ) {
	jQuery.cssHooks[ prefix + suffix ] = {
		expand: function( value ) {
			var i = 0,
				expanded = {},

				// Assumes a single number if not a string
				parts = typeof value === "string" ? value.split( " " ) : [ value ];

			for ( ; i < 4; i++ ) {
				expanded[ prefix + cssExpand[ i ] + suffix ] =
					parts[ i ] || parts[ i - 2 ] || parts[ 0 ];
			}

			return expanded;
		}
	};

	if ( !rmargin.test( prefix ) ) {
		jQuery.cssHooks[ prefix + suffix ].set = setPositiveNumber;
	}
} );

jQuery.fn.extend( {
	css: function( name, value ) {
		return access( this, function( elem, name, value ) {
			var styles, len,
				map = {},
				i = 0;

			if ( Array.isArray( name ) ) {
				styles = getStyles( elem );
				len = name.length;

				for ( ; i < len; i++ ) {
					map[ name[ i ] ] = jQuery.css( elem, name[ i ], false, styles );
				}

				return map;
			}

			return value !== undefined ?
				jQuery.style( elem, name, value ) :
				jQuery.css( elem, name );
		}, name, value, arguments.length > 1 );
	}
} );


function Tween( elem, options, prop, end, easing ) {
	return new Tween.prototype.init( elem, options, prop, end, easing );
}
jQuery.Tween = Tween;

Tween.prototype = {
	constructor: Tween,
	init: function( elem, options, prop, end, easing, unit ) {
		this.elem = elem;
		this.prop = prop;
		this.easing = easing || jQuery.easing._default;
		this.options = options;
		this.start = this.now = this.cur();
		this.end = end;
		this.unit = unit || ( jQuery.cssNumber[ prop ] ? "" : "px" );
	},
	cur: function() {
		var hooks = Tween.propHooks[ this.prop ];

		return hooks && hooks.get ?
			hooks.get( this ) :
			Tween.propHooks._default.get( this );
	},
	run: function( percent ) {
		var eased,
			hooks = Tween.propHooks[ this.prop ];

		if ( this.options.duration ) {
			this.pos = eased = jQuery.easing[ this.easing ](
				percent, this.options.duration * percent, 0, 1, this.options.duration
			);
		} else {
			this.pos = eased = percent;
		}
		this.now = ( this.end - this.start ) * eased + this.start;

		if ( this.options.step ) {
			this.options.step.call( this.elem, this.now, this );
		}

		if ( hooks && hooks.set ) {
			hooks.set( this );
		} else {
			Tween.propHooks._default.set( this );
		}
		return this;
	}
};

Tween.prototype.init.prototype = Tween.prototype;

Tween.propHooks = {
	_default: {
		get: function( tween ) {
			var result;

			// Use a property on the element directly when it is not a DOM element,
			// or when there is no matching style property that exists.
			if ( tween.elem.nodeType !== 1 ||
				tween.elem[ tween.prop ] != null && tween.elem.style[ tween.prop ] == null ) {
				return tween.elem[ tween.prop ];
			}

			// Passing an empty string as a 3rd parameter to .css will automatically
			// attempt a parseFloat and fallback to a string if the parse fails.
			// Simple values such as "10px" are parsed to Float;
			// complex values such as "rotate(1rad)" are returned as-is.
			result = jQuery.css( tween.elem, tween.prop, "" );

			// Empty strings, null, undefined and "auto" are converted to 0.
			return !result || result === "auto" ? 0 : result;
		},
		set: function( tween ) {

			// Use step hook for back compat.
			// Use cssHook if its there.
			// Use .style if available and use plain properties where available.
			if ( jQuery.fx.step[ tween.prop ] ) {
				jQuery.fx.step[ tween.prop ]( tween );
			} else if ( tween.elem.nodeType === 1 &&
				( tween.elem.style[ jQuery.cssProps[ tween.prop ] ] != null ||
					jQuery.cssHooks[ tween.prop ] ) ) {
				jQuery.style( tween.elem, tween.prop, tween.now + tween.unit );
			} else {
				tween.elem[ tween.prop ] = tween.now;
			}
		}
	}
};

// Support: IE <=9 only
// Panic based approach to setting things on disconnected nodes
Tween.propHooks.scrollTop = Tween.propHooks.scrollLeft = {
	set: function( tween ) {
		if ( tween.elem.nodeType && tween.elem.parentNode ) {
			tween.elem[ tween.prop ] = tween.now;
		}
	}
};

jQuery.easing = {
	linear: function( p ) {
		return p;
	},
	swing: function( p ) {
		return 0.5 - Math.cos( p * Math.PI ) / 2;
	},
	_default: "swing"
};

jQuery.fx = Tween.prototype.init;

// Back compat <1.8 extension point
jQuery.fx.step = {};




var
	fxNow, inProgress,
	rfxtypes = /^(?:toggle|show|hide)$/,
	rrun = /queueHooks$/;

function schedule() {
	if ( inProgress ) {
		if ( document.hidden === false && window.requestAnimationFrame ) {
			window.requestAnimationFrame( schedule );
		} else {
			window.setTimeout( schedule, jQuery.fx.interval );
		}

		jQuery.fx.tick();
	}
}

// Animations created synchronously will run synchronously
function createFxNow() {
	window.setTimeout( function() {
		fxNow = undefined;
	} );
	return ( fxNow = jQuery.now() );
}

// Generate parameters to create a standard animation
function genFx( type, includeWidth ) {
	var which,
		i = 0,
		attrs = { height: type };

	// If we include width, step value is 1 to do all cssExpand values,
	// otherwise step value is 2 to skip over Left and Right
	includeWidth = includeWidth ? 1 : 0;
	for ( ; i < 4; i += 2 - includeWidth ) {
		which = cssExpand[ i ];
		attrs[ "margin" + which ] = attrs[ "padding" + which ] = type;
	}

	if ( includeWidth ) {
		attrs.opacity = attrs.width = type;
	}

	return attrs;
}

function createTween( value, prop, animation ) {
	var tween,
		collection = ( Animation.tweeners[ prop ] || [] ).concat( Animation.tweeners[ "*" ] ),
		index = 0,
		length = collection.length;
	for ( ; index < length; index++ ) {
		if ( ( tween = collection[ index ].call( animation, prop, value ) ) ) {

			// We're done with this property
			return tween;
		}
	}
}

function defaultPrefilter( elem, props, opts ) {
	var prop, value, toggle, hooks, oldfire, propTween, restoreDisplay, display,
		isBox = "width" in props || "height" in props,
		anim = this,
		orig = {},
		style = elem.style,
		hidden = elem.nodeType && isHiddenWithinTree( elem ),
		dataShow = dataPriv.get( elem, "fxshow" );

	// Queue-skipping animations hijack the fx hooks
	if ( !opts.queue ) {
		hooks = jQuery._queueHooks( elem, "fx" );
		if ( hooks.unqueued == null ) {
			hooks.unqueued = 0;
			oldfire = hooks.empty.fire;
			hooks.empty.fire = function() {
				if ( !hooks.unqueued ) {
					oldfire();
				}
			};
		}
		hooks.unqueued++;

		anim.always( function() {

			// Ensure the complete handler is called before this completes
			anim.always( function() {
				hooks.unqueued--;
				if ( !jQuery.queue( elem, "fx" ).length ) {
					hooks.empty.fire();
				}
			} );
		} );
	}

	// Detect show/hide animations
	for ( prop in props ) {
		value = props[ prop ];
		if ( rfxtypes.test( value ) ) {
			delete props[ prop ];
			toggle = toggle || value === "toggle";
			if ( value === ( hidden ? "hide" : "show" ) ) {

				// Pretend to be hidden if this is a "show" and
				// there is still data from a stopped show/hide
				if ( value === "show" && dataShow && dataShow[ prop ] !== undefined ) {
					hidden = true;

				// Ignore all other no-op show/hide data
				} else {
					continue;
				}
			}
			orig[ prop ] = dataShow && dataShow[ prop ] || jQuery.style( elem, prop );
		}
	}

	// Bail out if this is a no-op like .hide().hide()
	propTween = !jQuery.isEmptyObject( props );
	if ( !propTween && jQuery.isEmptyObject( orig ) ) {
		return;
	}

	// Restrict "overflow" and "display" styles during box animations
	if ( isBox && elem.nodeType === 1 ) {

		// Support: IE <=9 - 11, Edge 12 - 13
		// Record all 3 overflow attributes because IE does not infer the shorthand
		// from identically-valued overflowX and overflowY
		opts.overflow = [ style.overflow, style.overflowX, style.overflowY ];

		// Identify a display type, preferring old show/hide data over the CSS cascade
		restoreDisplay = dataShow && dataShow.display;
		if ( restoreDisplay == null ) {
			restoreDisplay = dataPriv.get( elem, "display" );
		}
		display = jQuery.css( elem, "display" );
		if ( display === "none" ) {
			if ( restoreDisplay ) {
				display = restoreDisplay;
			} else {

				// Get nonempty value(s) by temporarily forcing visibility
				showHide( [ elem ], true );
				restoreDisplay = elem.style.display || restoreDisplay;
				display = jQuery.css( elem, "display" );
				showHide( [ elem ] );
			}
		}

		// Animate inline elements as inline-block
		if ( display === "inline" || display === "inline-block" && restoreDisplay != null ) {
			if ( jQuery.css( elem, "float" ) === "none" ) {

				// Restore the original display value at the end of pure show/hide animations
				if ( !propTween ) {
					anim.done( function() {
						style.display = restoreDisplay;
					} );
					if ( restoreDisplay == null ) {
						display = style.display;
						restoreDisplay = display === "none" ? "" : display;
					}
				}
				style.display = "inline-block";
			}
		}
	}

	if ( opts.overflow ) {
		style.overflow = "hidden";
		anim.always( function() {
			style.overflow = opts.overflow[ 0 ];
			style.overflowX = opts.overflow[ 1 ];
			style.overflowY = opts.overflow[ 2 ];
		} );
	}

	// Implement show/hide animations
	propTween = false;
	for ( prop in orig ) {

		// General show/hide setup for this element animation
		if ( !propTween ) {
			if ( dataShow ) {
				if ( "hidden" in dataShow ) {
					hidden = dataShow.hidden;
				}
			} else {
				dataShow = dataPriv.access( elem, "fxshow", { display: restoreDisplay } );
			}

			// Store hidden/visible for toggle so `.stop().toggle()` "reverses"
			if ( toggle ) {
				dataShow.hidden = !hidden;
			}

			// Show elements before animating them
			if ( hidden ) {
				showHide( [ elem ], true );
			}

			/* eslint-disable no-loop-func */

			anim.done( function() {

			/* eslint-enable no-loop-func */

				// The final step of a "hide" animation is actually hiding the element
				if ( !hidden ) {
					showHide( [ elem ] );
				}
				dataPriv.remove( elem, "fxshow" );
				for ( prop in orig ) {
					jQuery.style( elem, prop, orig[ prop ] );
				}
			} );
		}

		// Per-property setup
		propTween = createTween( hidden ? dataShow[ prop ] : 0, prop, anim );
		if ( !( prop in dataShow ) ) {
			dataShow[ prop ] = propTween.start;
			if ( hidden ) {
				propTween.end = propTween.start;
				propTween.start = 0;
			}
		}
	}
}

function propFilter( props, specialEasing ) {
	var index, name, easing, value, hooks;

	// camelCase, specialEasing and expand cssHook pass
	for ( index in props ) {
		name = jQuery.camelCase( index );
		easing = specialEasing[ name ];
		value = props[ index ];
		if ( Array.isArray( value ) ) {
			easing = value[ 1 ];
			value = props[ index ] = value[ 0 ];
		}

		if ( index !== name ) {
			props[ name ] = value;
			delete props[ index ];
		}

		hooks = jQuery.cssHooks[ name ];
		if ( hooks && "expand" in hooks ) {
			value = hooks.expand( value );
			delete props[ name ];

			// Not quite $.extend, this won't overwrite existing keys.
			// Reusing 'index' because we have the correct "name"
			for ( index in value ) {
				if ( !( index in props ) ) {
					props[ index ] = value[ index ];
					specialEasing[ index ] = easing;
				}
			}
		} else {
			specialEasing[ name ] = easing;
		}
	}
}

function Animation( elem, properties, options ) {
	var result,
		stopped,
		index = 0,
		length = Animation.prefilters.length,
		deferred = jQuery.Deferred().always( function() {

			// Don't match elem in the :animated selector
			delete tick.elem;
		} ),
		tick = function() {
			if ( stopped ) {
				return false;
			}
			var currentTime = fxNow || createFxNow(),
				remaining = Math.max( 0, animation.startTime + animation.duration - currentTime ),

				// Support: Android 2.3 only
				// Archaic crash bug won't allow us to use `1 - ( 0.5 || 0 )` (#12497)
				temp = remaining / animation.duration || 0,
				percent = 1 - temp,
				index = 0,
				length = animation.tweens.length;

			for ( ; index < length; index++ ) {
				animation.tweens[ index ].run( percent );
			}

			deferred.notifyWith( elem, [ animation, percent, remaining ] );

			// If there's more to do, yield
			if ( percent < 1 && length ) {
				return remaining;
			}

			// If this was an empty animation, synthesize a final progress notification
			if ( !length ) {
				deferred.notifyWith( elem, [ animation, 1, 0 ] );
			}

			// Resolve the animation and report its conclusion
			deferred.resolveWith( elem, [ animation ] );
			return false;
		},
		animation = deferred.promise( {
			elem: elem,
			props: jQuery.extend( {}, properties ),
			opts: jQuery.extend( true, {
				specialEasing: {},
				easing: jQuery.easing._default
			}, options ),
			originalProperties: properties,
			originalOptions: options,
			startTime: fxNow || createFxNow(),
			duration: options.duration,
			tweens: [],
			createTween: function( prop, end ) {
				var tween = jQuery.Tween( elem, animation.opts, prop, end,
						animation.opts.specialEasing[ prop ] || animation.opts.easing );
				animation.tweens.push( tween );
				return tween;
			},
			stop: function( gotoEnd ) {
				var index = 0,

					// If we are going to the end, we want to run all the tweens
					// otherwise we skip this part
					length = gotoEnd ? animation.tweens.length : 0;
				if ( stopped ) {
					return this;
				}
				stopped = true;
				for ( ; index < length; index++ ) {
					animation.tweens[ index ].run( 1 );
				}

				// Resolve when we played the last frame; otherwise, reject
				if ( gotoEnd ) {
					deferred.notifyWith( elem, [ animation, 1, 0 ] );
					deferred.resolveWith( elem, [ animation, gotoEnd ] );
				} else {
					deferred.rejectWith( elem, [ animation, gotoEnd ] );
				}
				return this;
			}
		} ),
		props = animation.props;

	propFilter( props, animation.opts.specialEasing );

	for ( ; index < length; index++ ) {
		result = Animation.prefilters[ index ].call( animation, elem, props, animation.opts );
		if ( result ) {
			if ( jQuery.isFunction( result.stop ) ) {
				jQuery._queueHooks( animation.elem, animation.opts.queue ).stop =
					jQuery.proxy( result.stop, result );
			}
			return result;
		}
	}

	jQuery.map( props, createTween, animation );

	if ( jQuery.isFunction( animation.opts.start ) ) {
		animation.opts.start.call( elem, animation );
	}

	// Attach callbacks from options
	animation
		.progress( animation.opts.progress )
		.done( animation.opts.done, animation.opts.complete )
		.fail( animation.opts.fail )
		.always( animation.opts.always );

	jQuery.fx.timer(
		jQuery.extend( tick, {
			elem: elem,
			anim: animation,
			queue: animation.opts.queue
		} )
	);

	return animation;
}

jQuery.Animation = jQuery.extend( Animation, {

	tweeners: {
		"*": [ function( prop, value ) {
			var tween = this.createTween( prop, value );
			adjustCSS( tween.elem, prop, rcssNum.exec( value ), tween );
			return tween;
		} ]
	},

	tweener: function( props, callback ) {
		if ( jQuery.isFunction( props ) ) {
			callback = props;
			props = [ "*" ];
		} else {
			props = props.match( rnothtmlwhite );
		}

		var prop,
			index = 0,
			length = props.length;

		for ( ; index < length; index++ ) {
			prop = props[ index ];
			Animation.tweeners[ prop ] = Animation.tweeners[ prop ] || [];
			Animation.tweeners[ prop ].unshift( callback );
		}
	},

	prefilters: [ defaultPrefilter ],

	prefilter: function( callback, prepend ) {
		if ( prepend ) {
			Animation.prefilters.unshift( callback );
		} else {
			Animation.prefilters.push( callback );
		}
	}
} );

jQuery.speed = function( speed, easing, fn ) {
	var opt = speed && typeof speed === "object" ? jQuery.extend( {}, speed ) : {
		complete: fn || !fn && easing ||
			jQuery.isFunction( speed ) && speed,
		duration: speed,
		easing: fn && easing || easing && !jQuery.isFunction( easing ) && easing
	};

	// Go to the end state if fx are off
	if ( jQuery.fx.off ) {
		opt.duration = 0;

	} else {
		if ( typeof opt.duration !== "number" ) {
			if ( opt.duration in jQuery.fx.speeds ) {
				opt.duration = jQuery.fx.speeds[ opt.duration ];

			} else {
				opt.duration = jQuery.fx.speeds._default;
			}
		}
	}

	// Normalize opt.queue - true/undefined/null -> "fx"
	if ( opt.queue == null || opt.queue === true ) {
		opt.queue = "fx";
	}

	// Queueing
	opt.old = opt.complete;

	opt.complete = function() {
		if ( jQuery.isFunction( opt.old ) ) {
			opt.old.call( this );
		}

		if ( opt.queue ) {
			jQuery.dequeue( this, opt.queue );
		}
	};

	return opt;
};

jQuery.fn.extend( {
	fadeTo: function( speed, to, easing, callback ) {

		// Show any hidden elements after setting opacity to 0
		return this.filter( isHiddenWithinTree ).css( "opacity", 0 ).show()

			// Animate to the value specified
			.end().animate( { opacity: to }, speed, easing, callback );
	},
	animate: function( prop, speed, easing, callback ) {
		var empty = jQuery.isEmptyObject( prop ),
			optall = jQuery.speed( speed, easing, callback ),
			doAnimation = function() {

				// Operate on a copy of prop so per-property easing won't be lost
				var anim = Animation( this, jQuery.extend( {}, prop ), optall );

				// Empty animations, or finishing resolves immediately
				if ( empty || dataPriv.get( this, "finish" ) ) {
					anim.stop( true );
				}
			};
			doAnimation.finish = doAnimation;

		return empty || optall.queue === false ?
			this.each( doAnimation ) :
			this.queue( optall.queue, doAnimation );
	},
	stop: function( type, clearQueue, gotoEnd ) {
		var stopQueue = function( hooks ) {
			var stop = hooks.stop;
			delete hooks.stop;
			stop( gotoEnd );
		};

		if ( typeof type !== "string" ) {
			gotoEnd = clearQueue;
			clearQueue = type;
			type = undefined;
		}
		if ( clearQueue && type !== false ) {
			this.queue( type || "fx", [] );
		}

		return this.each( function() {
			var dequeue = true,
				index = type != null && type + "queueHooks",
				timers = jQuery.timers,
				data = dataPriv.get( this );

			if ( index ) {
				if ( data[ index ] && data[ index ].stop ) {
					stopQueue( data[ index ] );
				}
			} else {
				for ( index in data ) {
					if ( data[ index ] && data[ index ].stop && rrun.test( index ) ) {
						stopQueue( data[ index ] );
					}
				}
			}

			for ( index = timers.length; index--; ) {
				if ( timers[ index ].elem === this &&
					( type == null || timers[ index ].queue === type ) ) {

					timers[ index ].anim.stop( gotoEnd );
					dequeue = false;
					timers.splice( index, 1 );
				}
			}

			// Start the next in the queue if the last step wasn't forced.
			// Timers currently will call their complete callbacks, which
			// will dequeue but only if they were gotoEnd.
			if ( dequeue || !gotoEnd ) {
				jQuery.dequeue( this, type );
			}
		} );
	},
	finish: function( type ) {
		if ( type !== false ) {
			type = type || "fx";
		}
		return this.each( function() {
			var index,
				data = dataPriv.get( this ),
				queue = data[ type + "queue" ],
				hooks = data[ type + "queueHooks" ],
				timers = jQuery.timers,
				length = queue ? queue.length : 0;

			// Enable finishing flag on private data
			data.finish = true;

			// Empty the queue first
			jQuery.queue( this, type, [] );

			if ( hooks && hooks.stop ) {
				hooks.stop.call( this, true );
			}

			// Look for any active animations, and finish them
			for ( index = timers.length; index--; ) {
				if ( timers[ index ].elem === this && timers[ index ].queue === type ) {
					timers[ index ].anim.stop( true );
					timers.splice( index, 1 );
				}
			}

			// Look for any animations in the old queue and finish them
			for ( index = 0; index < length; index++ ) {
				if ( queue[ index ] && queue[ index ].finish ) {
					queue[ index ].finish.call( this );
				}
			}

			// Turn off finishing flag
			delete data.finish;
		} );
	}
} );

jQuery.each( [ "toggle", "show", "hide" ], function( i, name ) {
	var cssFn = jQuery.fn[ name ];
	jQuery.fn[ name ] = function( speed, easing, callback ) {
		return speed == null || typeof speed === "boolean" ?
			cssFn.apply( this, arguments ) :
			this.animate( genFx( name, true ), speed, easing, callback );
	};
} );

// Generate shortcuts for custom animations
jQuery.each( {
	slideDown: genFx( "show" ),
	slideUp: genFx( "hide" ),
	slideToggle: genFx( "toggle" ),
	fadeIn: { opacity: "show" },
	fadeOut: { opacity: "hide" },
	fadeToggle: { opacity: "toggle" }
}, function( name, props ) {
	jQuery.fn[ name ] = function( speed, easing, callback ) {
		return this.animate( props, speed, easing, callback );
	};
} );

jQuery.timers = [];
jQuery.fx.tick = function() {
	var timer,
		i = 0,
		timers = jQuery.timers;

	fxNow = jQuery.now();

	for ( ; i < timers.length; i++ ) {
		timer = timers[ i ];

		// Run the timer and safely remove it when done (allowing for external removal)
		if ( !timer() && timers[ i ] === timer ) {
			timers.splice( i--, 1 );
		}
	}

	if ( !timers.length ) {
		jQuery.fx.stop();
	}
	fxNow = undefined;
};

jQuery.fx.timer = function( timer ) {
	jQuery.timers.push( timer );
	jQuery.fx.start();
};

jQuery.fx.interval = 13;
jQuery.fx.start = function() {
	if ( inProgress ) {
		return;
	}

	inProgress = true;
	schedule();
};

jQuery.fx.stop = function() {
	inProgress = null;
};

jQuery.fx.speeds = {
	slow: 600,
	fast: 200,

	// Default speed
	_default: 400
};


// Based off of the plugin by Clint Helfers, with permission.
// https://web.archive.org/web/20100324014747/http://blindsignals.com/index.php/2009/07/jquery-delay/
jQuery.fn.delay = function( time, type ) {
	time = jQuery.fx ? jQuery.fx.speeds[ time ] || time : time;
	type = type || "fx";

	return this.queue( type, function( next, hooks ) {
		var timeout = window.setTimeout( next, time );
		hooks.stop = function() {
			window.clearTimeout( timeout );
		};
	} );
};


( function() {
	var input = document.createElement( "input" ),
		select = document.createElement( "select" ),
		opt = select.appendChild( document.createElement( "option" ) );

	input.type = "checkbox";

	// Support: Android <=4.3 only
	// Default value for a checkbox should be "on"
	support.checkOn = input.value !== "";

	// Support: IE <=11 only
	// Must access selectedIndex to make default options select
	support.optSelected = opt.selected;

	// Support: IE <=11 only
	// An input loses its value after becoming a radio
	input = document.createElement( "input" );
	input.value = "t";
	input.type = "radio";
	support.radioValue = input.value === "t";
} )();


var boolHook,
	attrHandle = jQuery.expr.attrHandle;

jQuery.fn.extend( {
	attr: function( name, value ) {
		return access( this, jQuery.attr, name, value, arguments.length > 1 );
	},

	removeAttr: function( name ) {
		return this.each( function() {
			jQuery.removeAttr( this, name );
		} );
	}
} );

jQuery.extend( {
	attr: function( elem, name, value ) {
		var ret, hooks,
			nType = elem.nodeType;

		// Don't get/set attributes on text, comment and attribute nodes
		if ( nType === 3 || nType === 8 || nType === 2 ) {
			return;
		}

		// Fallback to prop when attributes are not supported
		if ( typeof elem.getAttribute === "undefined" ) {
			return jQuery.prop( elem, name, value );
		}

		// Attribute hooks are determined by the lowercase version
		// Grab necessary hook if one is defined
		if ( nType !== 1 || !jQuery.isXMLDoc( elem ) ) {
			hooks = jQuery.attrHooks[ name.toLowerCase() ] ||
				( jQuery.expr.match.bool.test( name ) ? boolHook : undefined );
		}

		if ( value !== undefined ) {
			if ( value === null ) {
				jQuery.removeAttr( elem, name );
				return;
			}

			if ( hooks && "set" in hooks &&
				( ret = hooks.set( elem, value, name ) ) !== undefined ) {
				return ret;
			}

			elem.setAttribute( name, value + "" );
			return value;
		}

		if ( hooks && "get" in hooks && ( ret = hooks.get( elem, name ) ) !== null ) {
			return ret;
		}

		ret = jQuery.find.attr( elem, name );

		// Non-existent attributes return null, we normalize to undefined
		return ret == null ? undefined : ret;
	},

	attrHooks: {
		type: {
			set: function( elem, value ) {
				if ( !support.radioValue && value === "radio" &&
					nodeName( elem, "input" ) ) {
					var val = elem.value;
					elem.setAttribute( "type", value );
					if ( val ) {
						elem.value = val;
					}
					return value;
				}
			}
		}
	},

	removeAttr: function( elem, value ) {
		var name,
			i = 0,

			// Attribute names can contain non-HTML whitespace characters
			// https://html.spec.whatwg.org/multipage/syntax.html#attributes-2
			attrNames = value && value.match( rnothtmlwhite );

		if ( attrNames && elem.nodeType === 1 ) {
			while ( ( name = attrNames[ i++ ] ) ) {
				elem.removeAttribute( name );
			}
		}
	}
} );

// Hooks for boolean attributes
boolHook = {
	set: function( elem, value, name ) {
		if ( value === false ) {

			// Remove boolean attributes when set to false
			jQuery.removeAttr( elem, name );
		} else {
			elem.setAttribute( name, name );
		}
		return name;
	}
};

jQuery.each( jQuery.expr.match.bool.source.match( /\w+/g ), function( i, name ) {
	var getter = attrHandle[ name ] || jQuery.find.attr;

	attrHandle[ name ] = function( elem, name, isXML ) {
		var ret, handle,
			lowercaseName = name.toLowerCase();

		if ( !isXML ) {

			// Avoid an infinite loop by temporarily removing this function from the getter
			handle = attrHandle[ lowercaseName ];
			attrHandle[ lowercaseName ] = ret;
			ret = getter( elem, name, isXML ) != null ?
				lowercaseName :
				null;
			attrHandle[ lowercaseName ] = handle;
		}
		return ret;
	};
} );




var rfocusable = /^(?:input|select|textarea|button)$/i,
	rclickable = /^(?:a|area)$/i;

jQuery.fn.extend( {
	prop: function( name, value ) {
		return access( this, jQuery.prop, name, value, arguments.length > 1 );
	},

	removeProp: function( name ) {
		return this.each( function() {
			delete this[ jQuery.propFix[ name ] || name ];
		} );
	}
} );

jQuery.extend( {
	prop: function( elem, name, value ) {
		var ret, hooks,
			nType = elem.nodeType;

		// Don't get/set properties on text, comment and attribute nodes
		if ( nType === 3 || nType === 8 || nType === 2 ) {
			return;
		}

		if ( nType !== 1 || !jQuery.isXMLDoc( elem ) ) {

			// Fix name and attach hooks
			name = jQuery.propFix[ name ] || name;
			hooks = jQuery.propHooks[ name ];
		}

		if ( value !== undefined ) {
			if ( hooks && "set" in hooks &&
				( ret = hooks.set( elem, value, name ) ) !== undefined ) {
				return ret;
			}

			return ( elem[ name ] = value );
		}

		if ( hooks && "get" in hooks && ( ret = hooks.get( elem, name ) ) !== null ) {
			return ret;
		}

		return elem[ name ];
	},

	propHooks: {
		tabIndex: {
			get: function( elem ) {

				// Support: IE <=9 - 11 only
				// elem.tabIndex doesn't always return the
				// correct value when it hasn't been explicitly set
				// https://web.archive.org/web/20141116233347/http://fluidproject.org/blog/2008/01/09/getting-setting-and-removing-tabindex-values-with-javascript/
				// Use proper attribute retrieval(#12072)
				var tabindex = jQuery.find.attr( elem, "tabindex" );

				if ( tabindex ) {
					return parseInt( tabindex, 10 );
				}

				if (
					rfocusable.test( elem.nodeName ) ||
					rclickable.test( elem.nodeName ) &&
					elem.href
				) {
					return 0;
				}

				return -1;
			}
		}
	},

	propFix: {
		"for": "htmlFor",
		"class": "className"
	}
} );

// Support: IE <=11 only
// Accessing the selectedIndex property
// forces the browser to respect setting selected
// on the option
// The getter ensures a default option is selected
// when in an optgroup
// eslint rule "no-unused-expressions" is disabled for this code
// since it considers such accessions noop
if ( !support.optSelected ) {
	jQuery.propHooks.selected = {
		get: function( elem ) {

			/* eslint no-unused-expressions: "off" */

			var parent = elem.parentNode;
			if ( parent && parent.parentNode ) {
				parent.parentNode.selectedIndex;
			}
			return null;
		},
		set: function( elem ) {

			/* eslint no-unused-expressions: "off" */

			var parent = elem.parentNode;
			if ( parent ) {
				parent.selectedIndex;

				if ( parent.parentNode ) {
					parent.parentNode.selectedIndex;
				}
			}
		}
	};
}

jQuery.each( [
	"tabIndex",
	"readOnly",
	"maxLength",
	"cellSpacing",
	"cellPadding",
	"rowSpan",
	"colSpan",
	"useMap",
	"frameBorder",
	"contentEditable"
], function() {
	jQuery.propFix[ this.toLowerCase() ] = this;
} );




	// Strip and collapse whitespace according to HTML spec
	// https://html.spec.whatwg.org/multipage/infrastructure.html#strip-and-collapse-whitespace
	function stripAndCollapse( value ) {
		var tokens = value.match( rnothtmlwhite ) || [];
		return tokens.join( " " );
	}


function getClass( elem ) {
	return elem.getAttribute && elem.getAttribute( "class" ) || "";
}

jQuery.fn.extend( {
	addClass: function( value ) {
		var classes, elem, cur, curValue, clazz, j, finalValue,
			i = 0;

		if ( jQuery.isFunction( value ) ) {
			return this.each( function( j ) {
				jQuery( this ).addClass( value.call( this, j, getClass( this ) ) );
			} );
		}

		if ( typeof value === "string" && value ) {
			classes = value.match( rnothtmlwhite ) || [];

			while ( ( elem = this[ i++ ] ) ) {
				curValue = getClass( elem );
				cur = elem.nodeType === 1 && ( " " + stripAndCollapse( curValue ) + " " );

				if ( cur ) {
					j = 0;
					while ( ( clazz = classes[ j++ ] ) ) {
						if ( cur.indexOf( " " + clazz + " " ) < 0 ) {
							cur += clazz + " ";
						}
					}

					// Only assign if different to avoid unneeded rendering.
					finalValue = stripAndCollapse( cur );
					if ( curValue !== finalValue ) {
						elem.setAttribute( "class", finalValue );
					}
				}
			}
		}

		return this;
	},

	removeClass: function( value ) {
		var classes, elem, cur, curValue, clazz, j, finalValue,
			i = 0;

		if ( jQuery.isFunction( value ) ) {
			return this.each( function( j ) {
				jQuery( this ).removeClass( value.call( this, j, getClass( this ) ) );
			} );
		}

		if ( !arguments.length ) {
			return this.attr( "class", "" );
		}

		if ( typeof value === "string" && value ) {
			classes = value.match( rnothtmlwhite ) || [];

			while ( ( elem = this[ i++ ] ) ) {
				curValue = getClass( elem );

				// This expression is here for better compressibility (see addClass)
				cur = elem.nodeType === 1 && ( " " + stripAndCollapse( curValue ) + " " );

				if ( cur ) {
					j = 0;
					while ( ( clazz = classes[ j++ ] ) ) {

						// Remove *all* instances
						while ( cur.indexOf( " " + clazz + " " ) > -1 ) {
							cur = cur.replace( " " + clazz + " ", " " );
						}
					}

					// Only assign if different to avoid unneeded rendering.
					finalValue = stripAndCollapse( cur );
					if ( curValue !== finalValue ) {
						elem.setAttribute( "class", finalValue );
					}
				}
			}
		}

		return this;
	},

	toggleClass: function( value, stateVal ) {
		var type = typeof value;

		if ( typeof stateVal === "boolean" && type === "string" ) {
			return stateVal ? this.addClass( value ) : this.removeClass( value );
		}

		if ( jQuery.isFunction( value ) ) {
			return this.each( function( i ) {
				jQuery( this ).toggleClass(
					value.call( this, i, getClass( this ), stateVal ),
					stateVal
				);
			} );
		}

		return this.each( function() {
			var className, i, self, classNames;

			if ( type === "string" ) {

				// Toggle individual class names
				i = 0;
				self = jQuery( this );
				classNames = value.match( rnothtmlwhite ) || [];

				while ( ( className = classNames[ i++ ] ) ) {

					// Check each className given, space separated list
					if ( self.hasClass( className ) ) {
						self.removeClass( className );
					} else {
						self.addClass( className );
					}
				}

			// Toggle whole class name
			} else if ( value === undefined || type === "boolean" ) {
				className = getClass( this );
				if ( className ) {

					// Store className if set
					dataPriv.set( this, "__className__", className );
				}

				// If the element has a class name or if we're passed `false`,
				// then remove the whole classname (if there was one, the above saved it).
				// Otherwise bring back whatever was previously saved (if anything),
				// falling back to the empty string if nothing was stored.
				if ( this.setAttribute ) {
					this.setAttribute( "class",
						className || value === false ?
						"" :
						dataPriv.get( this, "__className__" ) || ""
					);
				}
			}
		} );
	},

	hasClass: function( selector ) {
		var className, elem,
			i = 0;

		className = " " + selector + " ";
		while ( ( elem = this[ i++ ] ) ) {
			if ( elem.nodeType === 1 &&
				( " " + stripAndCollapse( getClass( elem ) ) + " " ).indexOf( className ) > -1 ) {
					return true;
			}
		}

		return false;
	}
} );




var rreturn = /\r/g;

jQuery.fn.extend( {
	val: function( value ) {
		var hooks, ret, isFunction,
			elem = this[ 0 ];

		if ( !arguments.length ) {
			if ( elem ) {
				hooks = jQuery.valHooks[ elem.type ] ||
					jQuery.valHooks[ elem.nodeName.toLowerCase() ];

				if ( hooks &&
					"get" in hooks &&
					( ret = hooks.get( elem, "value" ) ) !== undefined
				) {
					return ret;
				}

				ret = elem.value;

				// Handle most common string cases
				if ( typeof ret === "string" ) {
					return ret.replace( rreturn, "" );
				}

				// Handle cases where value is null/undef or number
				return ret == null ? "" : ret;
			}

			return;
		}

		isFunction = jQuery.isFunction( value );

		return this.each( function( i ) {
			var val;

			if ( this.nodeType !== 1 ) {
				return;
			}

			if ( isFunction ) {
				val = value.call( this, i, jQuery( this ).val() );
			} else {
				val = value;
			}

			// Treat null/undefined as ""; convert numbers to string
			if ( val == null ) {
				val = "";

			} else if ( typeof val === "number" ) {
				val += "";

			} else if ( Array.isArray( val ) ) {
				val = jQuery.map( val, function( value ) {
					return value == null ? "" : value + "";
				} );
			}

			hooks = jQuery.valHooks[ this.type ] || jQuery.valHooks[ this.nodeName.toLowerCase() ];

			// If set returns undefined, fall back to normal setting
			if ( !hooks || !( "set" in hooks ) || hooks.set( this, val, "value" ) === undefined ) {
				this.value = val;
			}
		} );
	}
} );

jQuery.extend( {
	valHooks: {
		option: {
			get: function( elem ) {

				var val = jQuery.find.attr( elem, "value" );
				return val != null ?
					val :

					// Support: IE <=10 - 11 only
					// option.text throws exceptions (#14686, #14858)
					// Strip and collapse whitespace
					// https://html.spec.whatwg.org/#strip-and-collapse-whitespace
					stripAndCollapse( jQuery.text( elem ) );
			}
		},
		select: {
			get: function( elem ) {
				var value, option, i,
					options = elem.options,
					index = elem.selectedIndex,
					one = elem.type === "select-one",
					values = one ? null : [],
					max = one ? index + 1 : options.length;

				if ( index < 0 ) {
					i = max;

				} else {
					i = one ? index : 0;
				}

				// Loop through all the selected options
				for ( ; i < max; i++ ) {
					option = options[ i ];

					// Support: IE <=9 only
					// IE8-9 doesn't update selected after form reset (#2551)
					if ( ( option.selected || i === index ) &&

							// Don't return options that are disabled or in a disabled optgroup
							!option.disabled &&
							( !option.parentNode.disabled ||
								!nodeName( option.parentNode, "optgroup" ) ) ) {

						// Get the specific value for the option
						value = jQuery( option ).val();

						// We don't need an array for one selects
						if ( one ) {
							return value;
						}

						// Multi-Selects return an array
						values.push( value );
					}
				}

				return values;
			},

			set: function( elem, value ) {
				var optionSet, option,
					options = elem.options,
					values = jQuery.makeArray( value ),
					i = options.length;

				while ( i-- ) {
					option = options[ i ];

					/* eslint-disable no-cond-assign */

					if ( option.selected =
						jQuery.inArray( jQuery.valHooks.option.get( option ), values ) > -1
					) {
						optionSet = true;
					}

					/* eslint-enable no-cond-assign */
				}

				// Force browsers to behave consistently when non-matching value is set
				if ( !optionSet ) {
					elem.selectedIndex = -1;
				}
				return values;
			}
		}
	}
} );

// Radios and checkboxes getter/setter
jQuery.each( [ "radio", "checkbox" ], function() {
	jQuery.valHooks[ this ] = {
		set: function( elem, value ) {
			if ( Array.isArray( value ) ) {
				return ( elem.checked = jQuery.inArray( jQuery( elem ).val(), value ) > -1 );
			}
		}
	};
	if ( !support.checkOn ) {
		jQuery.valHooks[ this ].get = function( elem ) {
			return elem.getAttribute( "value" ) === null ? "on" : elem.value;
		};
	}
} );




// Return jQuery for attributes-only inclusion


var rfocusMorph = /^(?:focusinfocus|focusoutblur)$/;

jQuery.extend( jQuery.event, {

	trigger: function( event, data, elem, onlyHandlers ) {

		var i, cur, tmp, bubbleType, ontype, handle, special,
			eventPath = [ elem || document ],
			type = hasOwn.call( event, "type" ) ? event.type : event,
			namespaces = hasOwn.call( event, "namespace" ) ? event.namespace.split( "." ) : [];

		cur = tmp = elem = elem || document;

		// Don't do events on text and comment nodes
		if ( elem.nodeType === 3 || elem.nodeType === 8 ) {
			return;
		}

		// focus/blur morphs to focusin/out; ensure we're not firing them right now
		if ( rfocusMorph.test( type + jQuery.event.triggered ) ) {
			return;
		}

		if ( type.indexOf( "." ) > -1 ) {

			// Namespaced trigger; create a regexp to match event type in handle()
			namespaces = type.split( "." );
			type = namespaces.shift();
			namespaces.sort();
		}
		ontype = type.indexOf( ":" ) < 0 && "on" + type;

		// Caller can pass in a jQuery.Event object, Object, or just an event type string
		event = event[ jQuery.expando ] ?
			event :
			new jQuery.Event( type, typeof event === "object" && event );

		// Trigger bitmask: & 1 for native handlers; & 2 for jQuery (always true)
		event.isTrigger = onlyHandlers ? 2 : 3;
		event.namespace = namespaces.join( "." );
		event.rnamespace = event.namespace ?
			new RegExp( "(^|\\.)" + namespaces.join( "\\.(?:.*\\.|)" ) + "(\\.|$)" ) :
			null;

		// Clean up the event in case it is being reused
		event.result = undefined;
		if ( !event.target ) {
			event.target = elem;
		}

		// Clone any incoming data and prepend the event, creating the handler arg list
		data = data == null ?
			[ event ] :
			jQuery.makeArray( data, [ event ] );

		// Allow special events to draw outside the lines
		special = jQuery.event.special[ type ] || {};
		if ( !onlyHandlers && special.trigger && special.trigger.apply( elem, data ) === false ) {
			return;
		}

		// Determine event propagation path in advance, per W3C events spec (#9951)
		// Bubble up to document, then to window; watch for a global ownerDocument var (#9724)
		if ( !onlyHandlers && !special.noBubble && !jQuery.isWindow( elem ) ) {

			bubbleType = special.delegateType || type;
			if ( !rfocusMorph.test( bubbleType + type ) ) {
				cur = cur.parentNode;
			}
			for ( ; cur; cur = cur.parentNode ) {
				eventPath.push( cur );
				tmp = cur;
			}

			// Only add window if we got to document (e.g., not plain obj or detached DOM)
			if ( tmp === ( elem.ownerDocument || document ) ) {
				eventPath.push( tmp.defaultView || tmp.parentWindow || window );
			}
		}

		// Fire handlers on the event path
		i = 0;
		while ( ( cur = eventPath[ i++ ] ) && !event.isPropagationStopped() ) {

			event.type = i > 1 ?
				bubbleType :
				special.bindType || type;

			// jQuery handler
			handle = ( dataPriv.get( cur, "events" ) || {} )[ event.type ] &&
				dataPriv.get( cur, "handle" );
			if ( handle ) {
				handle.apply( cur, data );
			}

			// Native handler
			handle = ontype && cur[ ontype ];
			if ( handle && handle.apply && acceptData( cur ) ) {
				event.result = handle.apply( cur, data );
				if ( event.result === false ) {
					event.preventDefault();
				}
			}
		}
		event.type = type;

		// If nobody prevented the default action, do it now
		if ( !onlyHandlers && !event.isDefaultPrevented() ) {

			if ( ( !special._default ||
				special._default.apply( eventPath.pop(), data ) === false ) &&
				acceptData( elem ) ) {

				// Call a native DOM method on the target with the same name as the event.
				// Don't do default actions on window, that's where global variables be (#6170)
				if ( ontype && jQuery.isFunction( elem[ type ] ) && !jQuery.isWindow( elem ) ) {

					// Don't re-trigger an onFOO event when we call its FOO() method
					tmp = elem[ ontype ];

					if ( tmp ) {
						elem[ ontype ] = null;
					}

					// Prevent re-triggering of the same event, since we already bubbled it above
					jQuery.event.triggered = type;
					elem[ type ]();
					jQuery.event.triggered = undefined;

					if ( tmp ) {
						elem[ ontype ] = tmp;
					}
				}
			}
		}

		return event.result;
	},

	// Piggyback on a donor event to simulate a different one
	// Used only for `focus(in | out)` events
	simulate: function( type, elem, event ) {
		var e = jQuery.extend(
			new jQuery.Event(),
			event,
			{
				type: type,
				isSimulated: true
			}
		);

		jQuery.event.trigger( e, null, elem );
	}

} );

jQuery.fn.extend( {

	trigger: function( type, data ) {
		return this.each( function() {
			jQuery.event.trigger( type, data, this );
		} );
	},
	triggerHandler: function( type, data ) {
		var elem = this[ 0 ];
		if ( elem ) {
			return jQuery.event.trigger( type, data, elem, true );
		}
	}
} );


jQuery.each( ( "blur focus focusin focusout resize scroll click dblclick " +
	"mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave " +
	"change select submit keydown keypress keyup contextmenu" ).split( " " ),
	function( i, name ) {

	// Handle event binding
	jQuery.fn[ name ] = function( data, fn ) {
		return arguments.length > 0 ?
			this.on( name, null, data, fn ) :
			this.trigger( name );
	};
} );

jQuery.fn.extend( {
	hover: function( fnOver, fnOut ) {
		return this.mouseenter( fnOver ).mouseleave( fnOut || fnOver );
	}
} );




support.focusin = "onfocusin" in window;


// Support: Firefox <=44
// Firefox doesn't have focus(in | out) events
// Related ticket - https://bugzilla.mozilla.org/show_bug.cgi?id=687787
//
// Support: Chrome <=48 - 49, Safari <=9.0 - 9.1
// focus(in | out) events fire after focus & blur events,
// which is spec violation - http://www.w3.org/TR/DOM-Level-3-Events/#events-focusevent-event-order
// Related ticket - https://bugs.chromium.org/p/chromium/issues/detail?id=449857
if ( !support.focusin ) {
	jQuery.each( { focus: "focusin", blur: "focusout" }, function( orig, fix ) {

		// Attach a single capturing handler on the document while someone wants focusin/focusout
		var handler = function( event ) {
			jQuery.event.simulate( fix, event.target, jQuery.event.fix( event ) );
		};

		jQuery.event.special[ fix ] = {
			setup: function() {
				var doc = this.ownerDocument || this,
					attaches = dataPriv.access( doc, fix );

				if ( !attaches ) {
					doc.addEventListener( orig, handler, true );
				}
				dataPriv.access( doc, fix, ( attaches || 0 ) + 1 );
			},
			teardown: function() {
				var doc = this.ownerDocument || this,
					attaches = dataPriv.access( doc, fix ) - 1;

				if ( !attaches ) {
					doc.removeEventListener( orig, handler, true );
					dataPriv.remove( doc, fix );

				} else {
					dataPriv.access( doc, fix, attaches );
				}
			}
		};
	} );
}
var location = window.location;

var nonce = jQuery.now();

var rquery = ( /\?/ );



// Cross-browser xml parsing
jQuery.parseXML = function( data ) {
	var xml;
	if ( !data || typeof data !== "string" ) {
		return null;
	}

	// Support: IE 9 - 11 only
	// IE throws on parseFromString with invalid input.
	try {
		xml = ( new window.DOMParser() ).parseFromString( data, "text/xml" );
	} catch ( e ) {
		xml = undefined;
	}

	if ( !xml || xml.getElementsByTagName( "parsererror" ).length ) {
		jQuery.error( "Invalid XML: " + data );
	}
	return xml;
};


var
	rbracket = /\[\]$/,
	rCRLF = /\r?\n/g,
	rsubmitterTypes = /^(?:submit|button|image|reset|file)$/i,
	rsubmittable = /^(?:input|select|textarea|keygen)/i;

function buildParams( prefix, obj, traditional, add ) {
	var name;

	if ( Array.isArray( obj ) ) {

		// Serialize array item.
		jQuery.each( obj, function( i, v ) {
			if ( traditional || rbracket.test( prefix ) ) {

				// Treat each array item as a scalar.
				add( prefix, v );

			} else {

				// Item is non-scalar (array or object), encode its numeric index.
				buildParams(
					prefix + "[" + ( typeof v === "object" && v != null ? i : "" ) + "]",
					v,
					traditional,
					add
				);
			}
		} );

	} else if ( !traditional && jQuery.type( obj ) === "object" ) {

		// Serialize object item.
		for ( name in obj ) {
			buildParams( prefix + "[" + name + "]", obj[ name ], traditional, add );
		}

	} else {

		// Serialize scalar item.
		add( prefix, obj );
	}
}

// Serialize an array of form elements or a set of
// key/values into a query string
jQuery.param = function( a, traditional ) {
	var prefix,
		s = [],
		add = function( key, valueOrFunction ) {

			// If value is a function, invoke it and use its return value
			var value = jQuery.isFunction( valueOrFunction ) ?
				valueOrFunction() :
				valueOrFunction;

			s[ s.length ] = encodeURIComponent( key ) + "=" +
				encodeURIComponent( value == null ? "" : value );
		};

	// If an array was passed in, assume that it is an array of form elements.
	if ( Array.isArray( a ) || ( a.jquery && !jQuery.isPlainObject( a ) ) ) {

		// Serialize the form elements
		jQuery.each( a, function() {
			add( this.name, this.value );
		} );

	} else {

		// If traditional, encode the "old" way (the way 1.3.2 or older
		// did it), otherwise encode params recursively.
		for ( prefix in a ) {
			buildParams( prefix, a[ prefix ], traditional, add );
		}
	}

	// Return the resulting serialization
	return s.join( "&" );
};

jQuery.fn.extend( {
	serialize: function() {
		return jQuery.param( this.serializeArray() );
	},
	serializeArray: function() {
		return this.map( function() {

			// Can add propHook for "elements" to filter or add form elements
			var elements = jQuery.prop( this, "elements" );
			return elements ? jQuery.makeArray( elements ) : this;
		} )
		.filter( function() {
			var type = this.type;

			// Use .is( ":disabled" ) so that fieldset[disabled] works
			return this.name && !jQuery( this ).is( ":disabled" ) &&
				rsubmittable.test( this.nodeName ) && !rsubmitterTypes.test( type ) &&
				( this.checked || !rcheckableType.test( type ) );
		} )
		.map( function( i, elem ) {
			var val = jQuery( this ).val();

			if ( val == null ) {
				return null;
			}

			if ( Array.isArray( val ) ) {
				return jQuery.map( val, function( val ) {
					return { name: elem.name, value: val.replace( rCRLF, "\r\n" ) };
				} );
			}

			return { name: elem.name, value: val.replace( rCRLF, "\r\n" ) };
		} ).get();
	}
} );


var
	r20 = /%20/g,
	rhash = /#.*$/,
	rantiCache = /([?&])_=[^&]*/,
	rheaders = /^(.*?):[ \t]*([^\r\n]*)$/mg,

	// #7653, #8125, #8152: local protocol detection
	rlocalProtocol = /^(?:about|app|app-storage|.+-extension|file|res|widget):$/,
	rnoContent = /^(?:GET|HEAD)$/,
	rprotocol = /^\/\//,

	/* Prefilters
	 * 1) They are useful to introduce custom dataTypes (see ajax/jsonp.js for an example)
	 * 2) These are called:
	 *    - BEFORE asking for a transport
	 *    - AFTER param serialization (s.data is a string if s.processData is true)
	 * 3) key is the dataType
	 * 4) the catchall symbol "*" can be used
	 * 5) execution will start with transport dataType and THEN continue down to "*" if needed
	 */
	prefilters = {},

	/* Transports bindings
	 * 1) key is the dataType
	 * 2) the catchall symbol "*" can be used
	 * 3) selection will start with transport dataType and THEN go to "*" if needed
	 */
	transports = {},

	// Avoid comment-prolog char sequence (#10098); must appease lint and evade compression
	allTypes = "*/".concat( "*" ),

	// Anchor tag for parsing the document origin
	originAnchor = document.createElement( "a" );
	originAnchor.href = location.href;

// Base "constructor" for jQuery.ajaxPrefilter and jQuery.ajaxTransport
function addToPrefiltersOrTransports( structure ) {

	// dataTypeExpression is optional and defaults to "*"
	return function( dataTypeExpression, func ) {

		if ( typeof dataTypeExpression !== "string" ) {
			func = dataTypeExpression;
			dataTypeExpression = "*";
		}

		var dataType,
			i = 0,
			dataTypes = dataTypeExpression.toLowerCase().match( rnothtmlwhite ) || [];

		if ( jQuery.isFunction( func ) ) {

			// For each dataType in the dataTypeExpression
			while ( ( dataType = dataTypes[ i++ ] ) ) {

				// Prepend if requested
				if ( dataType[ 0 ] === "+" ) {
					dataType = dataType.slice( 1 ) || "*";
					( structure[ dataType ] = structure[ dataType ] || [] ).unshift( func );

				// Otherwise append
				} else {
					( structure[ dataType ] = structure[ dataType ] || [] ).push( func );
				}
			}
		}
	};
}

// Base inspection function for prefilters and transports
function inspectPrefiltersOrTransports( structure, options, originalOptions, jqXHR ) {

	var inspected = {},
		seekingTransport = ( structure === transports );

	function inspect( dataType ) {
		var selected;
		inspected[ dataType ] = true;
		jQuery.each( structure[ dataType ] || [], function( _, prefilterOrFactory ) {
			var dataTypeOrTransport = prefilterOrFactory( options, originalOptions, jqXHR );
			if ( typeof dataTypeOrTransport === "string" &&
				!seekingTransport && !inspected[ dataTypeOrTransport ] ) {

				options.dataTypes.unshift( dataTypeOrTransport );
				inspect( dataTypeOrTransport );
				return false;
			} else if ( seekingTransport ) {
				return !( selected = dataTypeOrTransport );
			}
		} );
		return selected;
	}

	return inspect( options.dataTypes[ 0 ] ) || !inspected[ "*" ] && inspect( "*" );
}

// A special extend for ajax options
// that takes "flat" options (not to be deep extended)
// Fixes #9887
function ajaxExtend( target, src ) {
	var key, deep,
		flatOptions = jQuery.ajaxSettings.flatOptions || {};

	for ( key in src ) {
		if ( src[ key ] !== undefined ) {
			( flatOptions[ key ] ? target : ( deep || ( deep = {} ) ) )[ key ] = src[ key ];
		}
	}
	if ( deep ) {
		jQuery.extend( true, target, deep );
	}

	return target;
}

/* Handles responses to an ajax request:
 * - finds the right dataType (mediates between content-type and expected dataType)
 * - returns the corresponding response
 */
function ajaxHandleResponses( s, jqXHR, responses ) {

	var ct, type, finalDataType, firstDataType,
		contents = s.contents,
		dataTypes = s.dataTypes;

	// Remove auto dataType and get content-type in the process
	while ( dataTypes[ 0 ] === "*" ) {
		dataTypes.shift();
		if ( ct === undefined ) {
			ct = s.mimeType || jqXHR.getResponseHeader( "Content-Type" );
		}
	}

	// Check if we're dealing with a known content-type
	if ( ct ) {
		for ( type in contents ) {
			if ( contents[ type ] && contents[ type ].test( ct ) ) {
				dataTypes.unshift( type );
				break;
			}
		}
	}

	// Check to see if we have a response for the expected dataType
	if ( dataTypes[ 0 ] in responses ) {
		finalDataType = dataTypes[ 0 ];
	} else {

		// Try convertible dataTypes
		for ( type in responses ) {
			if ( !dataTypes[ 0 ] || s.converters[ type + " " + dataTypes[ 0 ] ] ) {
				finalDataType = type;
				break;
			}
			if ( !firstDataType ) {
				firstDataType = type;
			}
		}

		// Or just use first one
		finalDataType = finalDataType || firstDataType;
	}

	// If we found a dataType
	// We add the dataType to the list if needed
	// and return the corresponding response
	if ( finalDataType ) {
		if ( finalDataType !== dataTypes[ 0 ] ) {
			dataTypes.unshift( finalDataType );
		}
		return responses[ finalDataType ];
	}
}

/* Chain conversions given the request and the original response
 * Also sets the responseXXX fields on the jqXHR instance
 */
function ajaxConvert( s, response, jqXHR, isSuccess ) {
	var conv2, current, conv, tmp, prev,
		converters = {},

		// Work with a copy of dataTypes in case we need to modify it for conversion
		dataTypes = s.dataTypes.slice();

	// Create converters map with lowercased keys
	if ( dataTypes[ 1 ] ) {
		for ( conv in s.converters ) {
			converters[ conv.toLowerCase() ] = s.converters[ conv ];
		}
	}

	current = dataTypes.shift();

	// Convert to each sequential dataType
	while ( current ) {

		if ( s.responseFields[ current ] ) {
			jqXHR[ s.responseFields[ current ] ] = response;
		}

		// Apply the dataFilter if provided
		if ( !prev && isSuccess && s.dataFilter ) {
			response = s.dataFilter( response, s.dataType );
		}

		prev = current;
		current = dataTypes.shift();

		if ( current ) {

			// There's only work to do if current dataType is non-auto
			if ( current === "*" ) {

				current = prev;

			// Convert response if prev dataType is non-auto and differs from current
			} else if ( prev !== "*" && prev !== current ) {

				// Seek a direct converter
				conv = converters[ prev + " " + current ] || converters[ "* " + current ];

				// If none found, seek a pair
				if ( !conv ) {
					for ( conv2 in converters ) {

						// If conv2 outputs current
						tmp = conv2.split( " " );
						if ( tmp[ 1 ] === current ) {

							// If prev can be converted to accepted input
							conv = converters[ prev + " " + tmp[ 0 ] ] ||
								converters[ "* " + tmp[ 0 ] ];
							if ( conv ) {

								// Condense equivalence converters
								if ( conv === true ) {
									conv = converters[ conv2 ];

								// Otherwise, insert the intermediate dataType
								} else if ( converters[ conv2 ] !== true ) {
									current = tmp[ 0 ];
									dataTypes.unshift( tmp[ 1 ] );
								}
								break;
							}
						}
					}
				}

				// Apply converter (if not an equivalence)
				if ( conv !== true ) {

					// Unless errors are allowed to bubble, catch and return them
					if ( conv && s.throws ) {
						response = conv( response );
					} else {
						try {
							response = conv( response );
						} catch ( e ) {
							return {
								state: "parsererror",
								error: conv ? e : "No conversion from " + prev + " to " + current
							};
						}
					}
				}
			}
		}
	}

	return { state: "success", data: response };
}

jQuery.extend( {

	// Counter for holding the number of active queries
	active: 0,

	// Last-Modified header cache for next request
	lastModified: {},
	etag: {},

	ajaxSettings: {
		url: location.href,
		type: "GET",
		isLocal: rlocalProtocol.test( location.protocol ),
		global: true,
		processData: true,
		async: true,
		contentType: "application/x-www-form-urlencoded; charset=UTF-8",

		/*
		timeout: 0,
		data: null,
		dataType: null,
		username: null,
		password: null,
		cache: null,
		throws: false,
		traditional: false,
		headers: {},
		*/

		accepts: {
			"*": allTypes,
			text: "text/plain",
			html: "text/html",
			xml: "application/xml, text/xml",
			json: "application/json, text/javascript"
		},

		contents: {
			xml: /\bxml\b/,
			html: /\bhtml/,
			json: /\bjson\b/
		},

		responseFields: {
			xml: "responseXML",
			text: "responseText",
			json: "responseJSON"
		},

		// Data converters
		// Keys separate source (or catchall "*") and destination types with a single space
		converters: {

			// Convert anything to text
			"* text": String,

			// Text to html (true = no transformation)
			"text html": true,

			// Evaluate text as a json expression
			"text json": JSON.parse,

			// Parse text as xml
			"text xml": jQuery.parseXML
		},

		// For options that shouldn't be deep extended:
		// you can add your own custom options here if
		// and when you create one that shouldn't be
		// deep extended (see ajaxExtend)
		flatOptions: {
			url: true,
			context: true
		}
	},

	// Creates a full fledged settings object into target
	// with both ajaxSettings and settings fields.
	// If target is omitted, writes into ajaxSettings.
	ajaxSetup: function( target, settings ) {
		return settings ?

			// Building a settings object
			ajaxExtend( ajaxExtend( target, jQuery.ajaxSettings ), settings ) :

			// Extending ajaxSettings
			ajaxExtend( jQuery.ajaxSettings, target );
	},

	ajaxPrefilter: addToPrefiltersOrTransports( prefilters ),
	ajaxTransport: addToPrefiltersOrTransports( transports ),

	// Main method
	ajax: function( url, options ) {

		// If url is an object, simulate pre-1.5 signature
		if ( typeof url === "object" ) {
			options = url;
			url = undefined;
		}

		// Force options to be an object
		options = options || {};

		var transport,

			// URL without anti-cache param
			cacheURL,

			// Response headers
			responseHeadersString,
			responseHeaders,

			// timeout handle
			timeoutTimer,

			// Url cleanup var
			urlAnchor,

			// Request state (becomes false upon send and true upon completion)
			completed,

			// To know if global events are to be dispatched
			fireGlobals,

			// Loop variable
			i,

			// uncached part of the url
			uncached,

			// Create the final options object
			s = jQuery.ajaxSetup( {}, options ),

			// Callbacks context
			callbackContext = s.context || s,

			// Context for global events is callbackContext if it is a DOM node or jQuery collection
			globalEventContext = s.context &&
				( callbackContext.nodeType || callbackContext.jquery ) ?
					jQuery( callbackContext ) :
					jQuery.event,

			// Deferreds
			deferred = jQuery.Deferred(),
			completeDeferred = jQuery.Callbacks( "once memory" ),

			// Status-dependent callbacks
			statusCode = s.statusCode || {},

			// Headers (they are sent all at once)
			requestHeaders = {},
			requestHeadersNames = {},

			// Default abort message
			strAbort = "canceled",

			// Fake xhr
			jqXHR = {
				readyState: 0,

				// Builds headers hashtable if needed
				getResponseHeader: function( key ) {
					var match;
					if ( completed ) {
						if ( !responseHeaders ) {
							responseHeaders = {};
							while ( ( match = rheaders.exec( responseHeadersString ) ) ) {
								responseHeaders[ match[ 1 ].toLowerCase() ] = match[ 2 ];
							}
						}
						match = responseHeaders[ key.toLowerCase() ];
					}
					return match == null ? null : match;
				},

				// Raw string
				getAllResponseHeaders: function() {
					return completed ? responseHeadersString : null;
				},

				// Caches the header
				setRequestHeader: function( name, value ) {
					if ( completed == null ) {
						name = requestHeadersNames[ name.toLowerCase() ] =
							requestHeadersNames[ name.toLowerCase() ] || name;
						requestHeaders[ name ] = value;
					}
					return this;
				},

				// Overrides response content-type header
				overrideMimeType: function( type ) {
					if ( completed == null ) {
						s.mimeType = type;
					}
					return this;
				},

				// Status-dependent callbacks
				statusCode: function( map ) {
					var code;
					if ( map ) {
						if ( completed ) {

							// Execute the appropriate callbacks
							jqXHR.always( map[ jqXHR.status ] );
						} else {

							// Lazy-add the new callbacks in a way that preserves old ones
							for ( code in map ) {
								statusCode[ code ] = [ statusCode[ code ], map[ code ] ];
							}
						}
					}
					return this;
				},

				// Cancel the request
				abort: function( statusText ) {
					var finalText = statusText || strAbort;
					if ( transport ) {
						transport.abort( finalText );
					}
					done( 0, finalText );
					return this;
				}
			};

		// Attach deferreds
		deferred.promise( jqXHR );

		// Add protocol if not provided (prefilters might expect it)
		// Handle falsy url in the settings object (#10093: consistency with old signature)
		// We also use the url parameter if available
		s.url = ( ( url || s.url || location.href ) + "" )
			.replace( rprotocol, location.protocol + "//" );

		// Alias method option to type as per ticket #12004
		s.type = options.method || options.type || s.method || s.type;

		// Extract dataTypes list
		s.dataTypes = ( s.dataType || "*" ).toLowerCase().match( rnothtmlwhite ) || [ "" ];

		// A cross-domain request is in order when the origin doesn't match the current origin.
		if ( s.crossDomain == null ) {
			urlAnchor = document.createElement( "a" );

			// Support: IE <=8 - 11, Edge 12 - 13
			// IE throws exception on accessing the href property if url is malformed,
			// e.g. http://example.com:80x/
			try {
				urlAnchor.href = s.url;

				// Support: IE <=8 - 11 only
				// Anchor's host property isn't correctly set when s.url is relative
				urlAnchor.href = urlAnchor.href;
				s.crossDomain = originAnchor.protocol + "//" + originAnchor.host !==
					urlAnchor.protocol + "//" + urlAnchor.host;
			} catch ( e ) {

				// If there is an error parsing the URL, assume it is crossDomain,
				// it can be rejected by the transport if it is invalid
				s.crossDomain = true;
			}
		}

		// Convert data if not already a string
		if ( s.data && s.processData && typeof s.data !== "string" ) {
			s.data = jQuery.param( s.data, s.traditional );
		}

		// Apply prefilters
		inspectPrefiltersOrTransports( prefilters, s, options, jqXHR );

		// If request was aborted inside a prefilter, stop there
		if ( completed ) {
			return jqXHR;
		}

		// We can fire global events as of now if asked to
		// Don't fire events if jQuery.event is undefined in an AMD-usage scenario (#15118)
		fireGlobals = jQuery.event && s.global;

		// Watch for a new set of requests
		if ( fireGlobals && jQuery.active++ === 0 ) {
			jQuery.event.trigger( "ajaxStart" );
		}

		// Uppercase the type
		s.type = s.type.toUpperCase();

		// Determine if request has content
		s.hasContent = !rnoContent.test( s.type );

		// Save the URL in case we're toying with the If-Modified-Since
		// and/or If-None-Match header later on
		// Remove hash to simplify url manipulation
		cacheURL = s.url.replace( rhash, "" );

		// More options handling for requests with no content
		if ( !s.hasContent ) {

			// Remember the hash so we can put it back
			uncached = s.url.slice( cacheURL.length );

			// If data is available, append data to url
			if ( s.data ) {
				cacheURL += ( rquery.test( cacheURL ) ? "&" : "?" ) + s.data;

				// #9682: remove data so that it's not used in an eventual retry
				delete s.data;
			}

			// Add or update anti-cache param if needed
			if ( s.cache === false ) {
				cacheURL = cacheURL.replace( rantiCache, "$1" );
				uncached = ( rquery.test( cacheURL ) ? "&" : "?" ) + "_=" + ( nonce++ ) + uncached;
			}

			// Put hash and anti-cache on the URL that will be requested (gh-1732)
			s.url = cacheURL + uncached;

		// Change '%20' to '+' if this is encoded form body content (gh-2658)
		} else if ( s.data && s.processData &&
			( s.contentType || "" ).indexOf( "application/x-www-form-urlencoded" ) === 0 ) {
			s.data = s.data.replace( r20, "+" );
		}

		// Set the If-Modified-Since and/or If-None-Match header, if in ifModified mode.
		if ( s.ifModified ) {
			if ( jQuery.lastModified[ cacheURL ] ) {
				jqXHR.setRequestHeader( "If-Modified-Since", jQuery.lastModified[ cacheURL ] );
			}
			if ( jQuery.etag[ cacheURL ] ) {
				jqXHR.setRequestHeader( "If-None-Match", jQuery.etag[ cacheURL ] );
			}
		}

		// Set the correct header, if data is being sent
		if ( s.data && s.hasContent && s.contentType !== false || options.contentType ) {
			jqXHR.setRequestHeader( "Content-Type", s.contentType );
		}

		// Set the Accepts header for the server, depending on the dataType
		jqXHR.setRequestHeader(
			"Accept",
			s.dataTypes[ 0 ] && s.accepts[ s.dataTypes[ 0 ] ] ?
				s.accepts[ s.dataTypes[ 0 ] ] +
					( s.dataTypes[ 0 ] !== "*" ? ", " + allTypes + "; q=0.01" : "" ) :
				s.accepts[ "*" ]
		);

		// Check for headers option
		for ( i in s.headers ) {
			jqXHR.setRequestHeader( i, s.headers[ i ] );
		}

		// Allow custom headers/mimetypes and early abort
		if ( s.beforeSend &&
			( s.beforeSend.call( callbackContext, jqXHR, s ) === false || completed ) ) {

			// Abort if not done already and return
			return jqXHR.abort();
		}

		// Aborting is no longer a cancellation
		strAbort = "abort";

		// Install callbacks on deferreds
		completeDeferred.add( s.complete );
		jqXHR.done( s.success );
		jqXHR.fail( s.error );

		// Get transport
		transport = inspectPrefiltersOrTransports( transports, s, options, jqXHR );

		// If no transport, we auto-abort
		if ( !transport ) {
			done( -1, "No Transport" );
		} else {
			jqXHR.readyState = 1;

			// Send global event
			if ( fireGlobals ) {
				globalEventContext.trigger( "ajaxSend", [ jqXHR, s ] );
			}

			// If request was aborted inside ajaxSend, stop there
			if ( completed ) {
				return jqXHR;
			}

			// Timeout
			if ( s.async && s.timeout > 0 ) {
				timeoutTimer = window.setTimeout( function() {
					jqXHR.abort( "timeout" );
				}, s.timeout );
			}

			try {
				completed = false;
				transport.send( requestHeaders, done );
			} catch ( e ) {

				// Rethrow post-completion exceptions
				if ( completed ) {
					throw e;
				}

				// Propagate others as results
				done( -1, e );
			}
		}

		// Callback for when everything is done
		function done( status, nativeStatusText, responses, headers ) {
			var isSuccess, success, error, response, modified,
				statusText = nativeStatusText;

			// Ignore repeat invocations
			if ( completed ) {
				return;
			}

			completed = true;

			// Clear timeout if it exists
			if ( timeoutTimer ) {
				window.clearTimeout( timeoutTimer );
			}

			// Dereference transport for early garbage collection
			// (no matter how long the jqXHR object will be used)
			transport = undefined;

			// Cache response headers
			responseHeadersString = headers || "";

			// Set readyState
			jqXHR.readyState = status > 0 ? 4 : 0;

			// Determine if successful
			isSuccess = status >= 200 && status < 300 || status === 304;

			// Get response data
			if ( responses ) {
				response = ajaxHandleResponses( s, jqXHR, responses );
			}

			// Convert no matter what (that way responseXXX fields are always set)
			response = ajaxConvert( s, response, jqXHR, isSuccess );

			// If successful, handle type chaining
			if ( isSuccess ) {

				// Set the If-Modified-Since and/or If-None-Match header, if in ifModified mode.
				if ( s.ifModified ) {
					modified = jqXHR.getResponseHeader( "Last-Modified" );
					if ( modified ) {
						jQuery.lastModified[ cacheURL ] = modified;
					}
					modified = jqXHR.getResponseHeader( "etag" );
					if ( modified ) {
						jQuery.etag[ cacheURL ] = modified;
					}
				}

				// if no content
				if ( status === 204 || s.type === "HEAD" ) {
					statusText = "nocontent";

				// if not modified
				} else if ( status === 304 ) {
					statusText = "notmodified";

				// If we have data, let's convert it
				} else {
					statusText = response.state;
					success = response.data;
					error = response.error;
					isSuccess = !error;
				}
			} else {

				// Extract error from statusText and normalize for non-aborts
				error = statusText;
				if ( status || !statusText ) {
					statusText = "error";
					if ( status < 0 ) {
						status = 0;
					}
				}
			}

			// Set data for the fake xhr object
			jqXHR.status = status;
			jqXHR.statusText = ( nativeStatusText || statusText ) + "";

			// Success/Error
			if ( isSuccess ) {
				deferred.resolveWith( callbackContext, [ success, statusText, jqXHR ] );
			} else {
				deferred.rejectWith( callbackContext, [ jqXHR, statusText, error ] );
			}

			// Status-dependent callbacks
			jqXHR.statusCode( statusCode );
			statusCode = undefined;

			if ( fireGlobals ) {
				globalEventContext.trigger( isSuccess ? "ajaxSuccess" : "ajaxError",
					[ jqXHR, s, isSuccess ? success : error ] );
			}

			// Complete
			completeDeferred.fireWith( callbackContext, [ jqXHR, statusText ] );

			if ( fireGlobals ) {
				globalEventContext.trigger( "ajaxComplete", [ jqXHR, s ] );

				// Handle the global AJAX counter
				if ( !( --jQuery.active ) ) {
					jQuery.event.trigger( "ajaxStop" );
				}
			}
		}

		return jqXHR;
	},

	getJSON: function( url, data, callback ) {
		return jQuery.get( url, data, callback, "json" );
	},

	getScript: function( url, callback ) {
		return jQuery.get( url, undefined, callback, "script" );
	}
} );

jQuery.each( [ "get", "post" ], function( i, method ) {
	jQuery[ method ] = function( url, data, callback, type ) {

		// Shift arguments if data argument was omitted
		if ( jQuery.isFunction( data ) ) {
			type = type || callback;
			callback = data;
			data = undefined;
		}

		// The url can be an options object (which then must have .url)
		return jQuery.ajax( jQuery.extend( {
			url: url,
			type: method,
			dataType: type,
			data: data,
			success: callback
		}, jQuery.isPlainObject( url ) && url ) );
	};
} );


jQuery._evalUrl = function( url ) {
	return jQuery.ajax( {
		url: url,

		// Make this explicit, since user can override this through ajaxSetup (#11264)
		type: "GET",
		dataType: "script",
		cache: true,
		async: false,
		global: false,
		"throws": true
	} );
};


jQuery.fn.extend( {
	wrapAll: function( html ) {
		var wrap;

		if ( this[ 0 ] ) {
			if ( jQuery.isFunction( html ) ) {
				html = html.call( this[ 0 ] );
			}

			// The elements to wrap the target around
			wrap = jQuery( html, this[ 0 ].ownerDocument ).eq( 0 ).clone( true );

			if ( this[ 0 ].parentNode ) {
				wrap.insertBefore( this[ 0 ] );
			}

			wrap.map( function() {
				var elem = this;

				while ( elem.firstElementChild ) {
					elem = elem.firstElementChild;
				}

				return elem;
			} ).append( this );
		}

		return this;
	},

	wrapInner: function( html ) {
		if ( jQuery.isFunction( html ) ) {
			return this.each( function( i ) {
				jQuery( this ).wrapInner( html.call( this, i ) );
			} );
		}

		return this.each( function() {
			var self = jQuery( this ),
				contents = self.contents();

			if ( contents.length ) {
				contents.wrapAll( html );

			} else {
				self.append( html );
			}
		} );
	},

	wrap: function( html ) {
		var isFunction = jQuery.isFunction( html );

		return this.each( function( i ) {
			jQuery( this ).wrapAll( isFunction ? html.call( this, i ) : html );
		} );
	},

	unwrap: function( selector ) {
		this.parent( selector ).not( "body" ).each( function() {
			jQuery( this ).replaceWith( this.childNodes );
		} );
		return this;
	}
} );


jQuery.expr.pseudos.hidden = function( elem ) {
	return !jQuery.expr.pseudos.visible( elem );
};
jQuery.expr.pseudos.visible = function( elem ) {
	return !!( elem.offsetWidth || elem.offsetHeight || elem.getClientRects().length );
};




jQuery.ajaxSettings.xhr = function() {
	try {
		return new window.XMLHttpRequest();
	} catch ( e ) {}
};

var xhrSuccessStatus = {

		// File protocol always yields status code 0, assume 200
		0: 200,

		// Support: IE <=9 only
		// #1450: sometimes IE returns 1223 when it should be 204
		1223: 204
	},
	xhrSupported = jQuery.ajaxSettings.xhr();

support.cors = !!xhrSupported && ( "withCredentials" in xhrSupported );
support.ajax = xhrSupported = !!xhrSupported;

jQuery.ajaxTransport( function( options ) {
	var callback, errorCallback;

	// Cross domain only allowed if supported through XMLHttpRequest
	if ( support.cors || xhrSupported && !options.crossDomain ) {
		return {
			send: function( headers, complete ) {
				var i,
					xhr = options.xhr();

				xhr.open(
					options.type,
					options.url,
					options.async,
					options.username,
					options.password
				);

				// Apply custom fields if provided
				if ( options.xhrFields ) {
					for ( i in options.xhrFields ) {
						xhr[ i ] = options.xhrFields[ i ];
					}
				}

				// Override mime type if needed
				if ( options.mimeType && xhr.overrideMimeType ) {
					xhr.overrideMimeType( options.mimeType );
				}

				// X-Requested-With header
				// For cross-domain requests, seeing as conditions for a preflight are
				// akin to a jigsaw puzzle, we simply never set it to be sure.
				// (it can always be set on a per-request basis or even using ajaxSetup)
				// For same-domain requests, won't change header if already provided.
				if ( !options.crossDomain && !headers[ "X-Requested-With" ] ) {
					headers[ "X-Requested-With" ] = "XMLHttpRequest";
				}

				// Set headers
				for ( i in headers ) {
					xhr.setRequestHeader( i, headers[ i ] );
				}

				// Callback
				callback = function( type ) {
					return function() {
						if ( callback ) {
							callback = errorCallback = xhr.onload =
								xhr.onerror = xhr.onabort = xhr.onreadystatechange = null;

							if ( type === "abort" ) {
								xhr.abort();
							} else if ( type === "error" ) {

								// Support: IE <=9 only
								// On a manual native abort, IE9 throws
								// errors on any property access that is not readyState
								if ( typeof xhr.status !== "number" ) {
									complete( 0, "error" );
								} else {
									complete(

										// File: protocol always yields status 0; see #8605, #14207
										xhr.status,
										xhr.statusText
									);
								}
							} else {
								complete(
									xhrSuccessStatus[ xhr.status ] || xhr.status,
									xhr.statusText,

									// Support: IE <=9 only
									// IE9 has no XHR2 but throws on binary (trac-11426)
									// For XHR2 non-text, let the caller handle it (gh-2498)
									( xhr.responseType || "text" ) !== "text"  ||
									typeof xhr.responseText !== "string" ?
										{ binary: xhr.response } :
										{ text: xhr.responseText },
									xhr.getAllResponseHeaders()
								);
							}
						}
					};
				};

				// Listen to events
				xhr.onload = callback();
				errorCallback = xhr.onerror = callback( "error" );

				// Support: IE 9 only
				// Use onreadystatechange to replace onabort
				// to handle uncaught aborts
				if ( xhr.onabort !== undefined ) {
					xhr.onabort = errorCallback;
				} else {
					xhr.onreadystatechange = function() {

						// Check readyState before timeout as it changes
						if ( xhr.readyState === 4 ) {

							// Allow onerror to be called first,
							// but that will not handle a native abort
							// Also, save errorCallback to a variable
							// as xhr.onerror cannot be accessed
							window.setTimeout( function() {
								if ( callback ) {
									errorCallback();
								}
							} );
						}
					};
				}

				// Create the abort callback
				callback = callback( "abort" );

				try {

					// Do send the request (this may raise an exception)
					xhr.send( options.hasContent && options.data || null );
				} catch ( e ) {

					// #14683: Only rethrow if this hasn't been notified as an error yet
					if ( callback ) {
						throw e;
					}
				}
			},

			abort: function() {
				if ( callback ) {
					callback();
				}
			}
		};
	}
} );




// Prevent auto-execution of scripts when no explicit dataType was provided (See gh-2432)
jQuery.ajaxPrefilter( function( s ) {
	if ( s.crossDomain ) {
		s.contents.script = false;
	}
} );

// Install script dataType
jQuery.ajaxSetup( {
	accepts: {
		script: "text/javascript, application/javascript, " +
			"application/ecmascript, application/x-ecmascript"
	},
	contents: {
		script: /\b(?:java|ecma)script\b/
	},
	converters: {
		"text script": function( text ) {
			jQuery.globalEval( text );
			return text;
		}
	}
} );

// Handle cache's special case and crossDomain
jQuery.ajaxPrefilter( "script", function( s ) {
	if ( s.cache === undefined ) {
		s.cache = false;
	}
	if ( s.crossDomain ) {
		s.type = "GET";
	}
} );

// Bind script tag hack transport
jQuery.ajaxTransport( "script", function( s ) {

	// This transport only deals with cross domain requests
	if ( s.crossDomain ) {
		var script, callback;
		return {
			send: function( _, complete ) {
				script = jQuery( "<script>" ).prop( {
					charset: s.scriptCharset,
					src: s.url
				} ).on(
					"load error",
					callback = function( evt ) {
						script.remove();
						callback = null;
						if ( evt ) {
							complete( evt.type === "error" ? 404 : 200, evt.type );
						}
					}
				);

				// Use native DOM manipulation to avoid our domManip AJAX trickery
				document.head.appendChild( script[ 0 ] );
			},
			abort: function() {
				if ( callback ) {
					callback();
				}
			}
		};
	}
} );




var oldCallbacks = [],
	rjsonp = /(=)\?(?=&|$)|\?\?/;

// Default jsonp settings
jQuery.ajaxSetup( {
	jsonp: "callback",
	jsonpCallback: function() {
		var callback = oldCallbacks.pop() || ( jQuery.expando + "_" + ( nonce++ ) );
		this[ callback ] = true;
		return callback;
	}
} );

// Detect, normalize options and install callbacks for jsonp requests
jQuery.ajaxPrefilter( "json jsonp", function( s, originalSettings, jqXHR ) {

	var callbackName, overwritten, responseContainer,
		jsonProp = s.jsonp !== false && ( rjsonp.test( s.url ) ?
			"url" :
			typeof s.data === "string" &&
				( s.contentType || "" )
					.indexOf( "application/x-www-form-urlencoded" ) === 0 &&
				rjsonp.test( s.data ) && "data"
		);

	// Handle iff the expected data type is "jsonp" or we have a parameter to set
	if ( jsonProp || s.dataTypes[ 0 ] === "jsonp" ) {

		// Get callback name, remembering preexisting value associated with it
		callbackName = s.jsonpCallback = jQuery.isFunction( s.jsonpCallback ) ?
			s.jsonpCallback() :
			s.jsonpCallback;

		// Insert callback into url or form data
		if ( jsonProp ) {
			s[ jsonProp ] = s[ jsonProp ].replace( rjsonp, "$1" + callbackName );
		} else if ( s.jsonp !== false ) {
			s.url += ( rquery.test( s.url ) ? "&" : "?" ) + s.jsonp + "=" + callbackName;
		}

		// Use data converter to retrieve json after script execution
		s.converters[ "script json" ] = function() {
			if ( !responseContainer ) {
				jQuery.error( callbackName + " was not called" );
			}
			return responseContainer[ 0 ];
		};

		// Force json dataType
		s.dataTypes[ 0 ] = "json";

		// Install callback
		overwritten = window[ callbackName ];
		window[ callbackName ] = function() {
			responseContainer = arguments;
		};

		// Clean-up function (fires after converters)
		jqXHR.always( function() {

			// If previous value didn't exist - remove it
			if ( overwritten === undefined ) {
				jQuery( window ).removeProp( callbackName );

			// Otherwise restore preexisting value
			} else {
				window[ callbackName ] = overwritten;
			}

			// Save back as free
			if ( s[ callbackName ] ) {

				// Make sure that re-using the options doesn't screw things around
				s.jsonpCallback = originalSettings.jsonpCallback;

				// Save the callback name for future use
				oldCallbacks.push( callbackName );
			}

			// Call if it was a function and we have a response
			if ( responseContainer && jQuery.isFunction( overwritten ) ) {
				overwritten( responseContainer[ 0 ] );
			}

			responseContainer = overwritten = undefined;
		} );

		// Delegate to script
		return "script";
	}
} );




// Support: Safari 8 only
// In Safari 8 documents created via document.implementation.createHTMLDocument
// collapse sibling forms: the second one becomes a child of the first one.
// Because of that, this security measure has to be disabled in Safari 8.
// https://bugs.webkit.org/show_bug.cgi?id=137337
support.createHTMLDocument = ( function() {
	var body = document.implementation.createHTMLDocument( "" ).body;
	body.innerHTML = "<form></form><form></form>";
	return body.childNodes.length === 2;
} )();


// Argument "data" should be string of html
// context (optional): If specified, the fragment will be created in this context,
// defaults to document
// keepScripts (optional): If true, will include scripts passed in the html string
jQuery.parseHTML = function( data, context, keepScripts ) {
	if ( typeof data !== "string" ) {
		return [];
	}
	if ( typeof context === "boolean" ) {
		keepScripts = context;
		context = false;
	}

	var base, parsed, scripts;

	if ( !context ) {

		// Stop scripts or inline event handlers from being executed immediately
		// by using document.implementation
		if ( support.createHTMLDocument ) {
			context = document.implementation.createHTMLDocument( "" );

			// Set the base href for the created document
			// so any parsed elements with URLs
			// are based on the document's URL (gh-2965)
			base = context.createElement( "base" );
			base.href = document.location.href;
			context.head.appendChild( base );
		} else {
			context = document;
		}
	}

	parsed = rsingleTag.exec( data );
	scripts = !keepScripts && [];

	// Single tag
	if ( parsed ) {
		return [ context.createElement( parsed[ 1 ] ) ];
	}

	parsed = buildFragment( [ data ], context, scripts );

	if ( scripts && scripts.length ) {
		jQuery( scripts ).remove();
	}

	return jQuery.merge( [], parsed.childNodes );
};


/**
 * Load a url into a page
 */
jQuery.fn.load = function( url, params, callback ) {
	var selector, type, response,
		self = this,
		off = url.indexOf( " " );

	if ( off > -1 ) {
		selector = stripAndCollapse( url.slice( off ) );
		url = url.slice( 0, off );
	}

	// If it's a function
	if ( jQuery.isFunction( params ) ) {

		// We assume that it's the callback
		callback = params;
		params = undefined;

	// Otherwise, build a param string
	} else if ( params && typeof params === "object" ) {
		type = "POST";
	}

	// If we have elements to modify, make the request
	if ( self.length > 0 ) {
		jQuery.ajax( {
			url: url,

			// If "type" variable is undefined, then "GET" method will be used.
			// Make value of this field explicit since
			// user can override it through ajaxSetup method
			type: type || "GET",
			dataType: "html",
			data: params
		} ).done( function( responseText ) {

			// Save response for use in complete callback
			response = arguments;

			self.html( selector ?

				// If a selector was specified, locate the right elements in a dummy div
				// Exclude scripts to avoid IE 'Permission Denied' errors
				jQuery( "<div>" ).append( jQuery.parseHTML( responseText ) ).find( selector ) :

				// Otherwise use the full result
				responseText );

		// If the request succeeds, this function gets "data", "status", "jqXHR"
		// but they are ignored because response was set above.
		// If it fails, this function gets "jqXHR", "status", "error"
		} ).always( callback && function( jqXHR, status ) {
			self.each( function() {
				callback.apply( this, response || [ jqXHR.responseText, status, jqXHR ] );
			} );
		} );
	}

	return this;
};




// Attach a bunch of functions for handling common AJAX events
jQuery.each( [
	"ajaxStart",
	"ajaxStop",
	"ajaxComplete",
	"ajaxError",
	"ajaxSuccess",
	"ajaxSend"
], function( i, type ) {
	jQuery.fn[ type ] = function( fn ) {
		return this.on( type, fn );
	};
} );




jQuery.expr.pseudos.animated = function( elem ) {
	return jQuery.grep( jQuery.timers, function( fn ) {
		return elem === fn.elem;
	} ).length;
};




jQuery.offset = {
	setOffset: function( elem, options, i ) {
		var curPosition, curLeft, curCSSTop, curTop, curOffset, curCSSLeft, calculatePosition,
			position = jQuery.css( elem, "position" ),
			curElem = jQuery( elem ),
			props = {};

		// Set position first, in-case top/left are set even on static elem
		if ( position === "static" ) {
			elem.style.position = "relative";
		}

		curOffset = curElem.offset();
		curCSSTop = jQuery.css( elem, "top" );
		curCSSLeft = jQuery.css( elem, "left" );
		calculatePosition = ( position === "absolute" || position === "fixed" ) &&
			( curCSSTop + curCSSLeft ).indexOf( "auto" ) > -1;

		// Need to be able to calculate position if either
		// top or left is auto and position is either absolute or fixed
		if ( calculatePosition ) {
			curPosition = curElem.position();
			curTop = curPosition.top;
			curLeft = curPosition.left;

		} else {
			curTop = parseFloat( curCSSTop ) || 0;
			curLeft = parseFloat( curCSSLeft ) || 0;
		}

		if ( jQuery.isFunction( options ) ) {

			// Use jQuery.extend here to allow modification of coordinates argument (gh-1848)
			options = options.call( elem, i, jQuery.extend( {}, curOffset ) );
		}

		if ( options.top != null ) {
			props.top = ( options.top - curOffset.top ) + curTop;
		}
		if ( options.left != null ) {
			props.left = ( options.left - curOffset.left ) + curLeft;
		}

		if ( "using" in options ) {
			options.using.call( elem, props );

		} else {
			curElem.css( props );
		}
	}
};

jQuery.fn.extend( {
	offset: function( options ) {

		// Preserve chaining for setter
		if ( arguments.length ) {
			return options === undefined ?
				this :
				this.each( function( i ) {
					jQuery.offset.setOffset( this, options, i );
				} );
		}

		var doc, docElem, rect, win,
			elem = this[ 0 ];

		if ( !elem ) {
			return;
		}

		// Return zeros for disconnected and hidden (display: none) elements (gh-2310)
		// Support: IE <=11 only
		// Running getBoundingClientRect on a
		// disconnected node in IE throws an error
		if ( !elem.getClientRects().length ) {
			return { top: 0, left: 0 };
		}

		rect = elem.getBoundingClientRect();

		doc = elem.ownerDocument;
		docElem = doc.documentElement;
		win = doc.defaultView;

		return {
			top: rect.top + win.pageYOffset - docElem.clientTop,
			left: rect.left + win.pageXOffset - docElem.clientLeft
		};
	},

	position: function() {
		if ( !this[ 0 ] ) {
			return;
		}

		var offsetParent, offset,
			elem = this[ 0 ],
			parentOffset = { top: 0, left: 0 };

		// Fixed elements are offset from window (parentOffset = {top:0, left: 0},
		// because it is its only offset parent
		if ( jQuery.css( elem, "position" ) === "fixed" ) {

			// Assume getBoundingClientRect is there when computed position is fixed
			offset = elem.getBoundingClientRect();

		} else {

			// Get *real* offsetParent
			offsetParent = this.offsetParent();

			// Get correct offsets
			offset = this.offset();
			if ( !nodeName( offsetParent[ 0 ], "html" ) ) {
				parentOffset = offsetParent.offset();
			}

			// Add offsetParent borders
			parentOffset = {
				top: parentOffset.top + jQuery.css( offsetParent[ 0 ], "borderTopWidth", true ),
				left: parentOffset.left + jQuery.css( offsetParent[ 0 ], "borderLeftWidth", true )
			};
		}

		// Subtract parent offsets and element margins
		return {
			top: offset.top - parentOffset.top - jQuery.css( elem, "marginTop", true ),
			left: offset.left - parentOffset.left - jQuery.css( elem, "marginLeft", true )
		};
	},

	// This method will return documentElement in the following cases:
	// 1) For the element inside the iframe without offsetParent, this method will return
	//    documentElement of the parent window
	// 2) For the hidden or detached element
	// 3) For body or html element, i.e. in case of the html node - it will return itself
	//
	// but those exceptions were never presented as a real life use-cases
	// and might be considered as more preferable results.
	//
	// This logic, however, is not guaranteed and can change at any point in the future
	offsetParent: function() {
		return this.map( function() {
			var offsetParent = this.offsetParent;

			while ( offsetParent && jQuery.css( offsetParent, "position" ) === "static" ) {
				offsetParent = offsetParent.offsetParent;
			}

			return offsetParent || documentElement;
		} );
	}
} );

// Create scrollLeft and scrollTop methods
jQuery.each( { scrollLeft: "pageXOffset", scrollTop: "pageYOffset" }, function( method, prop ) {
	var top = "pageYOffset" === prop;

	jQuery.fn[ method ] = function( val ) {
		return access( this, function( elem, method, val ) {

			// Coalesce documents and windows
			var win;
			if ( jQuery.isWindow( elem ) ) {
				win = elem;
			} else if ( elem.nodeType === 9 ) {
				win = elem.defaultView;
			}

			if ( val === undefined ) {
				return win ? win[ prop ] : elem[ method ];
			}

			if ( win ) {
				win.scrollTo(
					!top ? val : win.pageXOffset,
					top ? val : win.pageYOffset
				);

			} else {
				elem[ method ] = val;
			}
		}, method, val, arguments.length );
	};
} );

// Support: Safari <=7 - 9.1, Chrome <=37 - 49
// Add the top/left cssHooks using jQuery.fn.position
// Webkit bug: https://bugs.webkit.org/show_bug.cgi?id=29084
// Blink bug: https://bugs.chromium.org/p/chromium/issues/detail?id=589347
// getComputedStyle returns percent when specified for top/left/bottom/right;
// rather than make the css module depend on the offset module, just check for it here
jQuery.each( [ "top", "left" ], function( i, prop ) {
	jQuery.cssHooks[ prop ] = addGetHookIf( support.pixelPosition,
		function( elem, computed ) {
			if ( computed ) {
				computed = curCSS( elem, prop );

				// If curCSS returns percentage, fallback to offset
				return rnumnonpx.test( computed ) ?
					jQuery( elem ).position()[ prop ] + "px" :
					computed;
			}
		}
	);
} );


// Create innerHeight, innerWidth, height, width, outerHeight and outerWidth methods
jQuery.each( { Height: "height", Width: "width" }, function( name, type ) {
	jQuery.each( { padding: "inner" + name, content: type, "": "outer" + name },
		function( defaultExtra, funcName ) {

		// Margin is only for outerHeight, outerWidth
		jQuery.fn[ funcName ] = function( margin, value ) {
			var chainable = arguments.length && ( defaultExtra || typeof margin !== "boolean" ),
				extra = defaultExtra || ( margin === true || value === true ? "margin" : "border" );

			return access( this, function( elem, type, value ) {
				var doc;

				if ( jQuery.isWindow( elem ) ) {

					// $( window ).outerWidth/Height return w/h including scrollbars (gh-1729)
					return funcName.indexOf( "outer" ) === 0 ?
						elem[ "inner" + name ] :
						elem.document.documentElement[ "client" + name ];
				}

				// Get document width or height
				if ( elem.nodeType === 9 ) {
					doc = elem.documentElement;

					// Either scroll[Width/Height] or offset[Width/Height] or client[Width/Height],
					// whichever is greatest
					return Math.max(
						elem.body[ "scroll" + name ], doc[ "scroll" + name ],
						elem.body[ "offset" + name ], doc[ "offset" + name ],
						doc[ "client" + name ]
					);
				}

				return value === undefined ?

					// Get width or height on the element, requesting but not forcing parseFloat
					jQuery.css( elem, type, extra ) :

					// Set width or height on the element
					jQuery.style( elem, type, value, extra );
			}, type, chainable ? margin : undefined, chainable );
		};
	} );
} );


jQuery.fn.extend( {

	bind: function( types, data, fn ) {
		return this.on( types, null, data, fn );
	},
	unbind: function( types, fn ) {
		return this.off( types, null, fn );
	},

	delegate: function( selector, types, data, fn ) {
		return this.on( types, selector, data, fn );
	},
	undelegate: function( selector, types, fn ) {

		// ( namespace ) or ( selector, types [, fn] )
		return arguments.length === 1 ?
			this.off( selector, "**" ) :
			this.off( types, selector || "**", fn );
	}
} );

jQuery.holdReady = function( hold ) {
	if ( hold ) {
		jQuery.readyWait++;
	} else {
		jQuery.ready( true );
	}
};
jQuery.isArray = Array.isArray;
jQuery.parseJSON = JSON.parse;
jQuery.nodeName = nodeName;




// Register as a named AMD module, since jQuery can be concatenated with other
// files that may use define, but not via a proper concatenation script that
// understands anonymous AMD modules. A named AMD is safest and most robust
// way to register. Lowercase jquery is used because AMD module names are
// derived from file names, and jQuery is normally delivered in a lowercase
// file name. Do this after creating the global so that if an AMD module wants
// to call noConflict to hide this version of jQuery, it will work.

// Note that for maximum portability, libraries that are not jQuery should
// declare themselves as anonymous modules, and avoid setting a global if an
// AMD loader is present. jQuery is a special case. For more information, see
// https://github.com/jrburke/requirejs/wiki/Updating-existing-libraries#wiki-anon

if ( typeof define === "function" && define.amd ) {
	define( "jquery", [], function() {
		return jQuery;
	} );
}




var

	// Map over jQuery in case of overwrite
	_jQuery = window.jQuery,

	// Map over the $ in case of overwrite
	_$ = window.$;

jQuery.noConflict = function( deep ) {
	if ( window.$ === jQuery ) {
		window.$ = _$;
	}

	if ( deep && window.jQuery === jQuery ) {
		window.jQuery = _jQuery;
	}

	return jQuery;
};

// Expose jQuery and $ identifiers, even in AMD
// (#7102#comment:10, https://github.com/jquery/jquery/pull/557)
// and CommonJS for browser emulators (#13566)
if ( !noGlobal ) {
	window.jQuery = window.$ = jQuery;
}




return jQuery;
} );
/*! UIkit 3.0.0-beta.39 | http://www.getuikit.com | (c) 2014 - 2017 YOOtheme | MIT License */

!function(t,e){"object"==typeof exports&&"undefined"!=typeof module?module.exports=e():"function"==typeof define&&define.amd?define("uikit",e):t.UIkit=e()}(this,function(){"use strict";var t=2,e="setImmediate"in window?setImmediate:setTimeout;function i(e){this.state=t,this.value=void 0,this.deferred=[];var i=this;try{e(function(t){i.resolve(t)},function(t){i.reject(t)})}catch(t){i.reject(t)}}i.reject=function(t){return new i(function(e,i){i(t)})},i.resolve=function(t){return new i(function(e,i){e(t)})},i.all=function(t){return new i(function(e,n){var o=0,s=[];function r(i){return function(n){s[i]=n,(o+=1)===t.length&&e(s)}}0===t.length&&e(s);for(var a=0;a<t.length;a+=1)i.resolve(t[a]).then(r(a),n)})},i.race=function(t){return new i(function(e,n){for(var o=0;o<t.length;o+=1)i.resolve(t[o]).then(e,n)})};var n=i.prototype;n.resolve=function(e){var i=this;if(i.state===t){if(e===i)throw new TypeError("Promise settled with itself.");var n=!1;try{var o=e&&e.then;if(null!==e&&ze(e)&&He(o))return void o.call(e,function(t){n||i.resolve(t),n=!0},function(t){n||i.reject(t),n=!0})}catch(t){return void(n||i.reject(t))}i.state=0,i.value=e,i.notify()}},n.reject=function(e){var i=this;if(i.state===t){if(e===i)throw new TypeError("Promise settled with itself.");i.state=1,i.value=e,i.notify()}},n.notify=function(){var i=this;e(function(){if(i.state!==t)for(;i.deferred.length;){var e=i.deferred.shift(),n=e[0],o=e[1],s=e[2],r=e[3];try{0===i.state?He(n)?s(n.call(void 0,i.value)):s(i.value):1===i.state&&(He(o)?s(o.call(void 0,i.value)):r(i.value))}catch(t){r(t)}}})},n.then=function(t,e){var n=this;return new i(function(i,o){n.deferred.push([t,e,i,o]),n.notify()})},n.catch=function(t){return this.then(void 0,t)};var o=window,s=document,r=s.documentElement,a=o.MutationObserver,l=o.requestAnimationFrame,h="ontouchstart"in o,u=o.PointerEvent,c=h||o.DocumentTouch&&s instanceof DocumentTouch||navigator.maxTouchPoints,d=c?"mousedown "+(h?"touchstart":"pointerdown"):"mousedown",f=c?"mousemove "+(h?"touchmove":"pointermove"):"mousemove",p=c?"mouseup "+(h?"touchend":"pointerup"):"mouseup",m=c&&u?"pointerenter":"mouseenter",g=c&&u?"pointerleave":"mouseleave";var v,w={};function b(t,e,i){if(ze(e))for(var n in e)b(t,n,e[n]);else{if(qe(i))return(t=ne(t))&&t.getAttribute(e);oe(t).forEach(function(t){He(i)&&(i=i.call(t,b(t,e))),null===i?x(t,e):t.setAttribute(e,i)})}}function y(t,e){return oe(t).some(function(t){return t.hasAttribute(e)})}function x(t,e){t=oe(t),e.split(" ").forEach(function(e){return t.forEach(function(t){return t.removeAttribute(e)})})}function k(t,e,i,n){b(t,e,function(t){return t?t.replace(i,n):t})}function $(t,e){for(var i=0,n=[e,"data-"+e];i<n.length;i++)if(y(t,n[i]))return b(t,n[i])}function I(t){for(var e=[],i=arguments.length-1;i-- >0;)e[i]=arguments[i+1];A(t,e,"add")}function T(t){for(var e=[],i=arguments.length-1;i-- >0;)e[i]=arguments[i+1];A(t,e,"remove")}function C(t,e){k(t,"class",new RegExp("(^|\\s)"+e+"(?!\\S)","g"),"")}function E(t){for(var e=[],i=arguments.length-1;i-- >0;)e[i]=arguments[i+1];e[0]&&T(t,e[0]),e[1]&&I(t,e[1])}function _(t,e){return w.ClassList&&oe(t).some(function(t){return t.classList.contains(e)})}function S(t){for(var e=[],i=arguments.length-1;i-- >0;)e[i]=arguments[i+1];if(w.ClassList&&e.length){var n=Ve((e=N(e))[e.length-1])?[]:e.pop();e=e.filter(Boolean),oe(t).forEach(function(t){for(var i=t.classList,o=0;o<e.length;o++)w.Force?i.toggle.apply(i,[e[o]].concat(n)):i[(qe(n)?!i.contains(e[o]):n)?"add":"remove"](e[o])})}}function A(t,e,i){e=N(e).filter(Boolean),w.ClassList&&e.length&&oe(t).forEach(function(t){var n=t.classList;w.Multiple?n[i].apply(n,e):e.forEach(function(t){return n[i](t)})})}function N(t){return t.reduce(function(t,e){return t.concat.call(t,Ve(e)&&Oe(e," ")?e.trim().split(" "):e)},[])}(v=s.createElement("_").classList)&&(v.add("a","b"),v.toggle("c",!1),w.Multiple=v.contains("b"),w.Force=!v.contains("c"),w.ClassList=!0),v=null;var D={"animation-iteration-count":!0,"column-count":!0,"fill-opacity":!0,"flex-grow":!0,"flex-shrink":!0,"font-weight":!0,"line-height":!0,opacity:!0,order:!0,orphans:!0,widows:!0,"z-index":!0,zoom:!0};function M(t,e,i){return oe(t).map(function(t){if(Ve(e)){if(e=W(e),qe(i))return O(t,e);i||0===i?t.style[e]=Ye(i)&&!D[e]?i+"px":i:t.style.removeProperty(e)}else{if(Pe(e)){var n=B(t);return e.reduce(function(t,e){return t[e]=n[W(e)],t},{})}ze(e)&&ni(e,function(e,i){return M(t,i,e)})}return t})[0]}function B(t,e){return(t=ne(t)).ownerDocument.defaultView.getComputedStyle(t,e)}function O(t,e,i){return B(t,i)[e]}var P={};function H(t){if(!(t in P)){var e=It(r,s.createElement("div"));I(e,"var-"+t);try{P[t]=O(e,"content",":before").replace(/^["'](.*)["']$/,"$1"),P[t]=JSON.parse(P[t])}catch(t){}r.removeChild(e)}return P[t]}var z={};function W(t){var e=z[t];return e||(e=z[t]=function(t){if((t=ke(t))in j)return t;var e,i=L.length;for(;i--;)if((e="-"+L[i]+"-"+t)in j)return e}(t)||t),e}var L=["webkit","moz","ms"],j=s.createElement("_").style;var F={width:["x","left","right"],height:["y","top","bottom"]};function V(t,e,i,n,o,s,r,a){i=K(i),n=K(n);var l={element:i,target:n};if(!t||!e)return l;var h=Y(t),u=Y(e),c=u;return Q(c,i,h,-1),Q(c,n,u,1),o=tt(o,h.width,h.height),s=tt(s,u.width,u.height),o.x+=s.x,o.y+=s.y,c.left+=o.x,c.top+=o.y,a=Y(a||Z(t)),r&&ni(F,function(t,e){var s=t[0],d=t[1],f=t[2];if(!0===r||Oe(r,s)){var p=i[s]===d?-h[e]:i[s]===f?h[e]:0,m=n[s]===d?u[e]:n[s]===f?-u[e]:0;if(c[d]<a[d]||c[d]+h[e]>a[f]){var g=h[e]/2,v="center"===n[s]?-u[e]/2:0;"center"===i[s]&&(w(g,v)||w(-g,-v))||w(p,m)}}function w(t,i){var n=c[d]+t+i-2*o[s];if(n>=a[d]&&n+h[e]<=a[f])return c[d]=n,["element","target"].forEach(function(i){l[i][s]=t?l[i][s]===F[e][1]?F[e][2]:F[e][1]:l[i][s]}),!0}}),R(t,c),l}function R(t,e){if(t=ne(t),!e)return Y(t);var i=R(t),n=M(t,"position");["left","top"].forEach(function(o){if(o in e){var s=M(t,o);t.style[o]=e[o]-i[o]+Je("absolute"===n&&"auto"===s?q(t)[o]:s)+"px"}})}function Y(t){var e=Z(t=ne(t)),i=e.pageYOffset,n=e.pageXOffset;if(Le(t)){var o=t.innerHeight,s=t.innerWidth;return{top:i,left:n,height:o,width:s,bottom:i+o,right:n+s}}var r=!1;bt(t)||(r=t.style.display,t.style.display="block");var a=t.getBoundingClientRect();return!1!==r&&(t.style.display=r),{height:a.height,width:a.width,top:a.top+i,left:a.left+n,bottom:a.bottom+i,right:a.right+n}}function q(t){var e=function(t){var e=ne(t).offsetParent;for(;e&&"static"===M(e,"position");)e=e.offsetParent;return e||nt(t)}(t=ne(t)),i=e===nt(t)?{top:0,left:0}:R(e),n=["top","left"].reduce(function(n,o){var s=Ce(o);return n[o]-=i[o]+(Je(M(t,"margin"+s))||0)+(Je(M(e,"border"+s+"Width"))||0),n},R(t));return{top:n.top,left:n.left}}var U=J("height"),X=J("width");function J(t){var e=Ce(t);return function(i,n){if(i=ne(i),qe(n)){if(Le(i))return i["inner"+e];if(je(i)){var o=i.documentElement;return Math.max(o.offsetHeight,o.scrollHeight)}return n="auto"===(n=M(i,t))?i["offset"+e]:Je(n)||0,G(t,i,n)}M(i,t,n||0===n?G(t,i,n)+"px":"")}}function G(t,e,i){return"border-box"===M(e,"boxSizing")?F[t].slice(1).map(Ce).reduce(function(t,i){return t-Je(M(e,"padding"+i))-Je(M(e,"border"+i+"Width"))},i):i}function Z(t){return Le(t)?t:it(t).defaultView}function Q(t,e,i,n){ni(F,function(o,s){var r=o[0],a=o[1],l=o[2];e[r]===l?t[a]+=i[s]*n:"center"===e[r]&&(t[a]+=i[s]*n/2)})}function K(t){var e=/left|center|right/,i=/top|center|bottom/;return 1===(t=(t||"").split(" ")).length&&(t=e.test(t[0])?t.concat(["center"]):i.test(t[0])?["center"].concat(t):["center","center"]),{x:e.test(t[0])?t[0]:"center",y:i.test(t[1])?t[1]:"center"}}function tt(t,e,i){var n=(t||"").split(" "),o=n[0],s=n[1];return{x:o?Je(o)*(Ne(o,"%")?e/100:1):0,y:s?Je(s)*(Ne(s,"%")?i/100:1):0}}function et(t){switch(t){case"left":return"right";case"right":return"left";case"top":return"bottom";case"bottom":return"top";default:return t}}function it(t){return ne(t).ownerDocument}function nt(t){return it(t).documentElement}var ot="rtl"===b(r,"dir");function st(){return"complete"===s.readyState||"loading"!==s.readyState&&!r.doScroll}function rt(t){if(st())t();else var e=function(){i(),n(),t()},i=ae(s,"DOMContentLoaded",e),n=ae(o,"load",e)}function at(t,e,i,n){return void 0===i&&(i=400),void 0===n&&(n="linear"),be.all(oe(t).map(function(t){return new be(function(o,s){for(var r in e){var a=M(t,r);""===a&&M(t,r,a)}var l=setTimeout(function(){return ue(t,"transitionend")},i);he(t,"transitionend transitioncanceled",function(e){var i=e.type;clearTimeout(l),T(t,"uk-transition"),M(t,{"transition-property":"","transition-duration":"","transition-timing-function":""}),"transitioncanceled"===i?s():o()},!1,function(e){var i=e.target;return t===i}),I(t,"uk-transition"),M(t,ii({"transition-property":Object.keys(e).map(W).join(","),"transition-duration":i+"ms","transition-timing-function":n},e))})}))}var lt={start:at,stop:function(t){return ue(t,"transitionend"),be.resolve()},cancel:function(t){ue(t,"transitioncanceled")},inProgress:function(t){return _(t,"uk-transition")}},ht="uk-animation-",ut="uk-cancel-animation";function ct(t,e,i,n,o){var s=arguments;return void 0===i&&(i=200),be.all(oe(t).map(function(t){return new be(function(r,a){if(_(t,ut))requestAnimationFrame(function(){return be.resolve().then(function(){return ct.apply(void 0,s).then(r,a)})});else{var l=e+" "+ht+(o?"leave":"enter");Se(e,ht)&&(n&&(l+=" uk-transform-origin-"+n),o&&(l+=" "+ht+"reverse")),h(),he(t,"animationend animationcancel",function(e){var i=!1;"animationcancel"===e.type?(a(),h()):(r(),be.resolve().then(function(){i=!0,h()})),requestAnimationFrame(function(){i||(I(t,ut),requestAnimationFrame(function(){return T(t,ut)}))})},!1,function(e){var i=e.target;return t===i}),M(t,"animationDuration",i+"ms"),I(t,l)}function h(){M(t,"animationDuration",""),C(t,ht+"\\S*")}})}))}var dt=new RegExp(ht+"(enter|leave)"),ft={in:function(t,e,i,n){return ct(t,e,i,n,!1)},out:function(t,e,i,n){return ct(t,e,i,n,!0)},inProgress:function(t){return dt.test(b(t,"class"))},cancel:function(t){ue(t,"animationcancel")}};function pt(t,e,i){return void 0===e&&(e=0),void 0===i&&(i=0),ri(ne(t).getBoundingClientRect(),{top:e,left:i,bottom:e+U(o),right:i+X(o)})}function mt(t,e,i,n){void 0===i&&(i=0),void 0===n&&(n=!1);var o=(e=oe(e)).length;return t=Ye(t)?Xe(t):"next"===t?i+1:"previous"===t?i-1:Ot(e,t),n?oi(t,0,o-1):(t%=o)<0?t+o:t}var gt={area:!0,base:!0,br:!0,col:!0,embed:!0,hr:!0,img:!0,input:!0,keygen:!0,link:!0,menuitem:!0,meta:!0,param:!0,source:!0,track:!0,wbr:!0};function vt(t){return gt[ne(t).tagName.toLowerCase()]}var wt={ratio:function(t,e,i){var n,o="width"===e?"height":"width";return(n={})[o]=Math.round(i*t[o]/t[e]),n[e]=i,n},contain:function(t,e){var i=this;return ni(t=ii({},t),function(n,o){return t=t[o]>e[o]?i.ratio(t,o,e[o]):t}),t},cover:function(t,e){var i=this;return ni(t=this.contain(t,e),function(n,o){return t=t[o]<e[o]?i.ratio(t,o,e[o]):t}),t}};function bt(t){return oe(t).some(function(t){return t.offsetHeight||t.getBoundingClientRect().height})}var yt="input,select,textarea,button";function xt(t){return oe(t).some(function(t){return Gt(t,yt)})}function kt(t){return(t=ne(t)).innerHTML="",t}function $t(t,e){return t=ne(t),qe(e)?t.innerHTML:It(t.hasChildNodes()?kt(t):t,e)}function It(t,e){return t=ne(t),Et(e,function(e){return t.appendChild(e)})}function Tt(t,e){return t=ne(t),Et(e,function(e){return t.parentNode.insertBefore(e,t)})}function Ct(t,e){return t=ne(t),Et(e,function(e){return t.nextSibling?Tt(t.nextSibling,e):It(t.parentNode,e)})}function Et(t,e){return(t=Ve(t)?Bt(t):t)?"length"in t?oe(t).map(e):e(t):null}function _t(t){oe(t).map(function(t){return t.parentNode&&t.parentNode.removeChild(t)})}function St(t,e){for(e=ne(Tt(t,e));e.firstChild;)e=e.firstChild;return It(e,t),e}function At(t,e){return oe(oe(t).map(function(t){return t.hasChildNodes?St(oe(t.childNodes),e):It(t,e)}))}function Nt(t){oe(t).map(function(t){return t.parentNode}).filter(function(t,e,i){return i.indexOf(t)===e}).forEach(function(t){Tt(t,t.childNodes),_t(t)})}var Dt=/^\s*<(\w+|!)[^>]*>/,Mt=/^<(\w+)\s*\/?>(?:<\/\1>)?$/;function Bt(t){var e;if(e=Mt.exec(t))return s.createElement(e[1]);var i=s.createElement("div");return Dt.test(t)?i.insertAdjacentHTML("beforeend",t.trim()):i.textContent=t,i.childNodes.length>1?oe(i.childNodes):i.firstChild}function Ot(t,e){return e?oe(t).indexOf(ne(e)):oe((t=ne(t))&&t.parentNode.children).indexOf(t)}var Pt=Array.prototype;function Ht(t,e){return Ve(t)?Wt(t)?ne(Bt(t)):ne(Ft(t,e,"querySelector")):ne(t)}function zt(t,e){return Ve(t)?Wt(t)?oe(Bt(t)):oe(Ft(t,e,"querySelectorAll")):oe(t)}function Wt(t){return"<"===t[0]||t.match(/^\s*</)}function Lt(t,e){return Ht(t,Ut(t)?e:s)}function jt(t,e){return zt(t,Ut(t)?e:s)}function Ft(t,e,i){if(void 0===e&&(e=s),!t||!Ve(t))return null;var n;Ut(t=t.replace(qt,"$1 *"))&&(n=[],t=t.split(",").map(function(t,i){var o=e;if("!"===(t=t.trim())[0]){var s=t.substr(1).trim().split(" ");o=Qt(e.parentNode,s[0]),t=s.slice(1).join(" ")}return o?(o.id||(o.id="uk-"+Date.now()+i,n.push(function(){return x(o,"id")})),"#"+re(o.id)+" "+t):null}).filter(Boolean).join(","),e=s);try{return e[i](t)}catch(t){return null}finally{n&&n.forEach(function(t){return t()})}}function Vt(t,e){return zt(t).filter(function(t){return Gt(t,e)})}function Rt(t,e){return Ve(e)?Gt(t,e)||Qt(t,e):t===e||ne(e).contains(ne(t))}var Yt=/(^|,)\s*[!>+~]/,qt=/([!>+~])(?=\s+[!>+~]|\s*$)/g;function Ut(t){return Ve(t)&&t.match(Yt)}var Xt=Element.prototype,Jt=Xt.matches||Xt.webkitMatchesSelector||Xt.msMatchesSelector;function Gt(t,e){return oe(t).some(function(t){return Jt.call(t,e)})}var Zt=Xt.closest||function(t){var e=this;do{if(Gt(e,t))return e;e=e.parentNode}while(e&&1===e.nodeType)};function Qt(t,e){return Se(e,">")&&(e=e.slice(1)),ee(t)?t.parentNode&&Zt.call(t,e):oe(t).map(function(t){return t.parentNode&&Zt.call(t,e)}).filter(Boolean)}function Kt(t,e){for(var i=[],n=ne(t).parentNode;n&&1===n.nodeType;)Gt(n,e)&&i.push(n),n=n.parentNode;return i}function te(t){return ze(t)&&!!t.jquery}function ee(t){return t instanceof Node||ze(t)&&1===t.nodeType}function ie(t){return t instanceof NodeList||t instanceof HTMLCollection}function ne(t){return ee(t)||Le(t)||je(t)?t:ie(t)||te(t)?t[0]:Pe(t)?ne(t[0]):null}function oe(t){return ee(t)?[t]:ie(t)?Pt.slice.call(t):Pe(t)?t.map(ne).filter(Boolean):te(t)?t.toArray():[]}var se=o.CSS&&CSS.escape||function(t){return t.replace(/([^\x7f-\uFFFF\w-])/g,function(t){return"\\"+t})};function re(t){return Ve(t)?se.call(null,t):""}function ae(){for(var t=[],e=arguments.length;e--;)t[e]=arguments[e];var i,n=de(t),o=n[0],s=n[1],r=n[2],a=n[3],l=n[4];return o=pe(o),r&&(a=function(t,e,i){var n=this;return function(o){var s=o.target,r=">"===e[0]?zt(e,t).reverse().filter(function(t){return Rt(s,t)})[0]:Qt(s,e);r&&(o.delegate=t,o.current=r,i.call(n,o))}}(o,r,a)),a.length>1&&(i=a,a=function(t){return Pe(t.detail)?i.apply(i,[t].concat(t.detail)):i(t)}),s.split(" ").forEach(function(t){return o&&o.addEventListener(t,a,l)}),function(){return le(o,s,a,l)}}function le(t,e,i,n){void 0===n&&(n=!1),(t=pe(t))&&e.split(" ").forEach(function(e){return t.removeEventListener(e,i,n)})}function he(){for(var t=[],e=arguments.length;e--;)t[e]=arguments[e];var i=de(t),n=i[0],o=i[1],s=i[2],r=i[3],a=i[4],l=i[5],h=ae(n,o,s,function(t){var e=!l||l(t);e&&(h(),r(t,e))},a);return h}function ue(t,e,i){return me(t).reduce(function(t,n){return t&&n.dispatchEvent(ce(e,!0,!0,i))},!0)}function ce(t,e,i,n){if(void 0===e&&(e=!0),void 0===i&&(i=!1),Ve(t)){var o=s.createEvent("CustomEvent");o.initCustomEvent(t,e,i,n),t=o}return t}function de(t){return Ve(t[0])&&(t[0]=Ht(t[0])),He(t[2])&&t.splice(2,0,!1),t}function fe(t){return"EventTarget"in o?t instanceof EventTarget:t&&"addEventListener"in t}function pe(t){return fe(t)?t:ne(t)}function me(t){return fe(t)?[t]:Pe(t)?t.map(pe).filter(Boolean):oe(t)}function ge(t,e){return function(i){var n=arguments.length;return n?n>1?t.apply(e,arguments):t.call(e,i):t.call(e)}}var ve=Object.prototype.hasOwnProperty;function we(t,e){return ve.call(t,e)}var be="Promise"in window?window.Promise:i,ye=/(?:^|[-_\/])(\w)/g;var xe=/([a-z\d])([A-Z])/g;function ke(t){return t.replace(xe,"$1-$2").toLowerCase()}var $e=/-(\w)/g;function Ie(t){return t.replace($e,Te)}function Te(t,e){return e?e.toUpperCase():""}function Ce(t){return t.length?Te(0,t.charAt(0))+t.slice(1):""}var Ee=String.prototype,_e=Ee.startsWith||function(t){return 0===this.lastIndexOf(t,0)};function Se(t,e){return _e.call(t,e)}var Ae=Ee.endsWith||function(t){return this.substr(-t.length)===t};function Ne(t,e){return Ae.call(t,e)}var De=function(t){return~this.indexOf(t)},Me=Ee.includes||De,Be=Array.prototype.includes||De;function Oe(t,e){return t&&(Ve(t)?Me:Be).call(t,e)}var Pe=Array.isArray;function He(t){return"function"==typeof t}function ze(t){return null!==t&&"object"==typeof t}function We(t){return ze(t)&&Object.getPrototypeOf(t)===Object.prototype}function Le(t){return ze(t)&&t===t.window}function je(t){return ze(t)&&9===t.nodeType}function Fe(t){return"boolean"==typeof t}function Ve(t){return"string"==typeof t}function Re(t){return"number"==typeof t}function Ye(t){return Re(t)||Ve(t)&&!isNaN(t-parseFloat(t))}function qe(t){return void 0===t}function Ue(t){return Fe(t)?t:"true"===t||"1"===t||""===t||"false"!==t&&"0"!==t&&t}function Xe(t){var e=Number(t);return!isNaN(e)&&e}function Je(t){return parseFloat(t)||0}function Ge(t){return Pe(t)?t:Ve(t)?t.split(/,(?![^(]*\))/).map(function(t){return Ye(t)?Xe(t):Ue(t.trim())}):[t]}var Ze={};function Qe(t){if(Ve(t))if("@"===t[0]){var e="media-"+t.substr(1);t=Ze[e]||(Ze[e]=Je(H(e)))}else if(isNaN(t))return t;return!(!t||isNaN(t))&&"(min-width: "+t+"px)"}function Ke(t,e,i){return t===Boolean?Ue(e):t===Number?Xe(e):"query"===t?Lt(e,i):"list"===t?Ge(e):"media"===t?Qe(e):t?t(e):e}function ti(t){return t?Ne(t,"ms")?Je(t):1e3*Je(t):0}function ei(t,e,i){return t.replace(new RegExp(e+"|"+i,"mg"),function(t){return t===e?i:e})}var ii=Object.assign||function(t){for(var e=[],i=arguments.length-1;i-- >0;)e[i]=arguments[i+1];t=Object(t);for(var n=0;n<e.length;n++){var o=e[n];if(null!==o)for(var s in o)we(o,s)&&(t[s]=o[s])}return t};function ni(t,e){for(var i in t)if(!1===e.call(t[i],t[i],i))break}function oi(t,e,i){return void 0===e&&(e=0),void 0===i&&(i=1),Math.min(Math.max(t,e),i)}function si(){}function ri(t,e){return t.left<=e.right&&e.left<=t.right&&t.top<=e.bottom&&e.top<=t.bottom}function ai(t,e){return ri({top:t.y,bottom:t.y,left:t.x,right:t.x},e)}function li(t,e){return new be(function(i,n){var o=ii({data:null,method:"GET",headers:{},xhr:new XMLHttpRequest,beforeSend:si,responseType:""},e),s=o.xhr;for(var r in o.beforeSend(o),o)if(r in s)try{s[r]=o[r]}catch(t){}for(var a in s.open(o.method.toUpperCase(),t),o.headers)s.setRequestHeader(a,o.headers[a]);ae(s,"load",function(){0===s.status||s.status>=200&&s.status<300||304===s.status?i(s):n(ii(Error(s.statusText),{xhr:s,status:s.status}))}),ae(s,"error",function(){return n(ii(Error("Network Error"),{xhr:s}))}),ae(s,"timeout",function(){return n(ii(Error("Network Timeout"),{xhr:s}))}),s.send(o.data)})}var hi={reads:[],writes:[],read:function(t){return this.reads.push(t),ui(),t},write:function(t){return this.writes.push(t),ui(),t},clear:function(t){return di(this.reads,t)||di(this.writes,t)},flush:function(){ci(this.reads),ci(this.writes.splice(0,this.writes.length)),this.scheduled=!1,(this.reads.length||this.writes.length)&&ui()}};function ui(){hi.scheduled||(hi.scheduled=!0,l(hi.flush.bind(hi)))}function ci(t){for(var e;e=t.shift();)e()}function di(t,e){var i=t.indexOf(e);return!!~i&&!!t.splice(i,1)}function fi(){}function pi(t,e){return(e.y-t.y)/(e.x-t.x)}fi.prototype={positions:[],position:null,init:function(){var t=this;this.positions=[],this.position=null;var e=!1;this.unbind=ae(s,"mousemove",function(i){e||(setTimeout(function(){var n=Date.now(),o=t.positions.length;o&&n-t.positions[o-1].time>100&&t.positions.splice(0,o),t.positions.push({time:n,x:i.pageX,y:i.pageY}),t.positions.length>5&&t.positions.shift(),e=!1},5),e=!0)})},cancel:function(){this.unbind&&this.unbind()},movesTo:function(t){if(this.positions.length<2)return!1;var e=R(t),i=this.positions[this.positions.length-1],n=this.positions[0];if(e.left<=i.x&&i.x<=e.right&&e.top<=i.y&&i.y<=e.bottom)return!1;var o=[[{x:e.left,y:e.top},{x:e.right,y:e.bottom}],[{x:e.right,y:e.top},{x:e.left,y:e.bottom}]];return e.right<=i.x||(e.left>=i.x?(o[0].reverse(),o[1].reverse()):e.bottom<=i.y?o[0].reverse():e.top>=i.y&&o[1].reverse()),!!o.reduce(function(t,e){return t+(pi(n,e[0])<pi(i,e[0])&&pi(n,e[1])>pi(i,e[1]))},0)}};var mi={};mi.args=mi.events=mi.init=mi.created=mi.beforeConnect=mi.connected=mi.ready=mi.beforeDisconnect=mi.disconnected=mi.destroy=function(t,e){return t=t&&!Pe(t)?[t]:t,e?t?t.concat(e):Pe(e)?e:[e]:t},mi.update=function(t,e){return mi.args(t,He(e)?{read:e}:e)},mi.props=function(t,e){return Pe(e)&&(e=e.reduce(function(t,e){return t[e]=String,t},{})),mi.methods(t,e)},mi.computed=mi.defaults=mi.methods=function(t,e){return e?t?ii({},t,e):e:t};var gi=function(t,e){return qe(e)?t:e};function vi(t,e){var i,n={};if(e.mixins)for(var o=0,s=e.mixins.length;o<s;o++)t=vi(t,e.mixins[o]);for(i in t)r(i);for(i in e)we(t,i)||r(i);function r(i){n[i]=(mi[i]||gi)(t[i],e[i])}return n}var wi=0,bi=function(t){this.id=++wi,this.el=ne(t)};function yi(t,e){try{t.contentWindow.postMessage(JSON.stringify(ii({event:"command"},e)),"*")}catch(t){}}bi.prototype.isVideo=function(){return this.isYoutube()||this.isVimeo()||this.isHTML5()},bi.prototype.isHTML5=function(){return"VIDEO"===this.el.tagName},bi.prototype.isIFrame=function(){return"IFRAME"===this.el.tagName},bi.prototype.isYoutube=function(){return this.isIFrame()&&!!this.el.src.match(/\/\/.*?youtube(-nocookie)?\.[a-z]+\/(watch\?v=[^&\s]+|embed)|youtu\.be\/.*/)},bi.prototype.isVimeo=function(){return this.isIFrame()&&!!this.el.src.match(/vimeo\.com\/video\/.*/)},bi.prototype.enableApi=function(){var t=this;if(this.ready)return this.ready;var e,n=this.isYoutube(),s=this.isVimeo();return n||s?this.ready=new i(function(r){var a;he(t.el,"load",function(){if(n){var i=function(){return yi(t.el,{event:"listening",id:t.id})};e=setInterval(i,100),i()}}),(a=function(e){return n&&e.id===t.id&&"onReady"===e.event||s&&Number(e.player_id)===t.id},new i(function(t){he(o,"message",function(e,i){return t(i)},!1,function(t){var e=t.data;if(e&&Ve(e)){try{e=JSON.parse(e)}catch(t){return}return e&&a(e)}})})).then(function(){r(),e&&clearInterval(e)}),b(t.el,"src",t.el.src+(Oe(t.el.src,"?")?"&":"?")+(n?"enablejsapi=1":"api=1&player_id="+wi))}):i.resolve()},bi.prototype.play=function(){var t=this;if(this.isVideo())if(this.isIFrame())this.enableApi().then(function(){return yi(t.el,{func:"playVideo",method:"play"})});else if(this.isHTML5())try{this.el.play()}catch(t){}},bi.prototype.pause=function(){var t=this;this.isVideo()&&(this.isIFrame()?this.enableApi().then(function(){return yi(t.el,{func:"pauseVideo",method:"pause"})}):this.isHTML5()&&this.el.pause())},bi.prototype.mute=function(){var t=this;this.isVideo()&&(this.isIFrame()?this.enableApi().then(function(){return yi(t.el,{func:"mute",method:"setVolume",value:0})}):this.isHTML5()&&(this.el.muted=!0,b(this.el,"muted","")))};var xi,ki,$i,Ii,Ti={};function Ci(){xi&&clearTimeout(xi),ki&&clearTimeout(ki),$i&&clearTimeout($i),xi=ki=$i=null,Ti={}}rt(function(){ae(s,"click",function(){return Ii=!0},!0),ae(s,d,function(t){var e=t.target,i=Si(t),n=i.x,o=i.y,s=Date.now(),r=Ai(t.type);Ti.type&&Ti.type!==r||(Ti.el="tagName"in e?e:e.parentNode,xi&&clearTimeout(xi),Ti.x1=n,Ti.y1=o,Ti.last&&s-Ti.last<=250&&(Ti={}),Ti.type=r,Ti.last=s,Ii=t.button>0)}),ae(s,f,function(t){var e=Si(t),i=e.x,n=e.y;Ti.x2=i,Ti.y2=n}),ae(s,p,function(t){var e=t.type,i=t.target;Ti.type===Ai(e)&&(Ti.x2&&Math.abs(Ti.x1-Ti.x2)>30||Ti.y2&&Math.abs(Ti.y1-Ti.y2)>30?ki=setTimeout(function(){var t,e,i,n,o;Ti.el&&(ue(Ti.el,"swipe"),ue(Ti.el,"swipe"+(e=(t=Ti).x1,i=t.x2,n=t.y1,o=t.y2,Math.abs(e-i)>=Math.abs(n-o)?e-i>0?"Left":"Right":n-o>0?"Up":"Down"))),Ti={}}):"last"in Ti?($i=setTimeout(function(){return ue(Ti.el,"tap")}),Ti.el&&"mouseup"!==e&&Rt(i,Ti.el)&&(xi=setTimeout(function(){xi=null,Ti.el&&!Ii&&ue(Ti.el,"click"),Ti={}},350))):Ti={})}),ae(s,"touchcancel",Ci),ae(o,"scroll",Ci)});var Ei=!1;function _i(t){return Ei||"touch"===t.pointerType}function Si(t){var e=t.touches,i=t.changedTouches,n=e&&e[0]||i&&i[0]||t;return{x:n.pageX,y:n.pageY}}function Ai(t){return t.slice(0,5)}ae(s,"touchstart",function(){return Ei=!0},!0),ae(s,"click",function(){Ei=!1}),ae(s,"touchcancel",function(){return Ei=!1},!0);var Ni=Object.freeze({bind:ge,hasOwn:we,Promise:be,Deferred:function(){var t=this;this.promise=new be(function(e,i){t.reject=i,t.resolve=e})},classify:function(t){return t.replace(ye,function(t,e){return e?e.toUpperCase():""})},hyphenate:ke,camelize:Ie,ucfirst:Ce,startsWith:Se,endsWith:Ne,includes:Oe,isArray:Pe,isFunction:He,isObject:ze,isPlainObject:We,isWindow:Le,isDocument:je,isBoolean:Fe,isString:Ve,isNumber:Re,isNumeric:Ye,isUndefined:qe,toBoolean:Ue,toNumber:Xe,toFloat:Je,toList:Ge,toMedia:Qe,coerce:Ke,toMs:ti,swap:ei,assign:ii,each:ni,sortBy:function(t,e){return t.sort(function(t,i){return t[e]>i[e]?1:i[e]>t[e]?-1:0})},clamp:oi,noop:si,intersectRect:ri,pointInRect:ai,ajax:li,$:Ht,$$:zt,query:Lt,queryAll:jt,filter:Vt,within:Rt,matches:Gt,closest:Qt,parents:Kt,isJQuery:te,toNode:ne,toNodes:oe,escape:re,attr:b,hasAttr:y,removeAttr:x,filterAttr:k,data:$,isRtl:ot,isReady:st,ready:rt,transition:at,Transition:lt,animate:ct,Animation:ft,isInView:pt,scrolledOver:function(t){var e=(t=ne(t)).offsetHeight,i=function(t){var e=0;do{e+=t.offsetTop}while(t=t.offsetParent);return e}(t),n=U(o),r=n+Math.min(0,i-n),a=Math.max(0,n-(U(s)-(i+e)));return oi((r+o.pageYOffset-i)/((r+(e-(a<n?a:0)))/100)/100)},getIndex:mt,isVoidElement:vt,Dimensions:wt,preventClick:function(){var t=setTimeout(he(s,"click",function(e){e.preventDefault(),e.stopImmediatePropagation(),clearTimeout(t)},!0))},isVisible:bt,selInput:yt,isInput:xt,empty:kt,html:$t,prepend:function(t,e){return(t=ne(t)).hasChildNodes()?Et(e,function(e){return t.insertBefore(e,t.firstChild)}):It(t,e)},append:It,before:Tt,after:Ct,remove:_t,wrapAll:St,wrapInner:At,unwrap:Nt,fragment:Bt,index:Ot,css:M,getStyles:B,getStyle:O,getCssVar:H,propName:W,addClass:I,removeClass:T,removeClasses:C,replaceClass:E,hasClass:_,toggleClass:S,win:o,doc:s,docEl:r,Observer:a,requestAnimationFrame:l,hasTouch:c,pointerDown:d,pointerMove:f,pointerUp:p,pointerEnter:m,pointerLeave:g,getImage:function(t){return new i(function(e,i){var n=new Image;n.onerror=i,n.onload=function(){return e(n)},n.src=t})},supports:w,on:ae,off:le,once:he,trigger:ue,createEvent:ce,toEventTargets:me,fastdom:hi,MouseTracker:fi,mergeOptions:vi,Player:bi,positionAt:V,offset:R,position:q,height:U,width:X,flipPosition:et,isTouch:_i,getPos:Si});function Di(t){return!(!Se(t,"uk-")&&!Se(t,"data-uk-"))&&Ie(t.replace("data-uk-","").replace("uk-",""))}var Mi,Bi,Oi,Pi,Hi,zi=function(t){this._init(t)};zi.util=Ni,zi.data="__uikit__",zi.prefix="uk-",zi.options={},zi.instances={},zi.elements=[],function(t){var e,i=t.data;function n(t,e){if(t)for(var i in t)t[i]._isReady&&t[i]._callUpdate(e)}t.use=function(t){if(!t.installed)return t.call(null,this),t.installed=!0,this},t.mixin=function(e,i){i=(Ve(i)?t.components[i]:i)||this,(e=vi({},e)).mixins=i.options.mixins,delete i.options.mixins,i.options=vi(e,i.options)},t.extend=function(t){t=t||{};var e=function(t){this._init(t)};return(e.prototype=Object.create(this.prototype)).constructor=e,e.options=vi(this.options,t),e.super=this,e.extend=this.extend,e},t.update=function(e,o,s){if(void 0===s&&(s=!1),e=ce(e||"update"),o)if(o=ne(o),s)do{n(o[i],e),o=o.parentNode}while(o);else!function t(e,i){if(1===e.nodeType)for(i(e),e=e.firstElementChild;e;)t(e,i),e=e.nextElementSibling}(o,function(t){return n(t[i],e)});else n(t.instances,e)},Object.defineProperty(t,"container",{get:function(){return e||s.body},set:function(t){e=Ht(t)}})}(zi),(Mi=zi).prototype._callHook=function(t){var e=this,i=this.$options[t];i&&i.forEach(function(t){return t.call(e)})},Mi.prototype._callConnected=function(){var t=this;this._connected||(Oe(Mi.elements,this.$options.el)||Mi.elements.push(this.$options.el),Mi.instances[this._uid]=this,this._data={},this._callHook("beforeConnect"),this._connected=!0,this._initEvents(),this._initObserver(),this._callHook("connected"),this._isReady||rt(function(){return t._callReady()}),this._callUpdate())},Mi.prototype._callDisconnected=function(){if(this._connected){this._callHook("beforeDisconnect"),this._observer&&(this._observer.disconnect(),this._observer=null);var t=Mi.elements.indexOf(this.$options.el);~t&&Mi.elements.splice(t,1),delete Mi.instances[this._uid],this._unbindEvents(),this._callHook("disconnected"),this._connected=!1}},Mi.prototype._callReady=function(){this._isReady||(this._isReady=!0,this._callHook("ready"),this._resetComputeds(),this._callUpdate())},Mi.prototype._callUpdate=function(t){var e=this,i=(t=ce(t||"update")).type,n=t.detail;"update"===i&&n&&n.mutation&&this._resetComputeds();var o=this.$options.update,s=this._frames,r=s.reads,a=s.writes;o&&o.forEach(function(n,o){var s=n.read,l=n.write,h=n.events;("update"===i||Oe(h,i))&&(s&&!Oe(hi.reads,r[o])&&(r[o]=hi.read(function(){var i=s.call(e,e._data,t);!1===i&&l?(hi.clear(a[o]),delete a[o]):We(i)&&ii(e._data,i),delete r[o]})),l&&!Oe(hi.writes,a[o])&&(a[o]=hi.write(function(){l.call(e,e._data,t),delete a[o]})))})},function(t){var e=0;function i(t,e){var i={},n=t.args;void 0===n&&(n=[]);var o=t.props;void 0===o&&(o={});var s,r,a=t.el;if(!o)return i;for(s in o)if(y(a,r=ke(s))){var l=Ke(o[s],b(a,r),a);if("target"===r&&(!l||Se(l,"_")))continue;i[s]=l}var h=function(t,e){var i;void 0===e&&(e=[]);try{return t?Se(t,"{")?JSON.parse(t):e.length&&!Oe(t,":")?((i={})[e[0]]=t,i):t.split(";").reduce(function(t,e){var i=e.split(/:(.+)/),n=i[0],o=i[1];return n&&o&&(t[n.trim()]=o.trim()),t},{}):{}}catch(t){return{}}}($(a,e),n);for(s in h)void 0!==o[r=Ie(s)]&&(i[r]=Ke(o[r],h[s],a));return i}function n(t,e,i){Object.defineProperty(t,e,{enumerable:!0,get:function(){var n=t._computeds,o=t.$props,s=t.$el;return we(n,e)||(n[e]=i.call(t,o,s)),n[e]},set:function(i){t._computeds[e]=i}})}function o(t,e,i){We(e)||(e={name:i,handler:e});var n,s,r=e.name,a=e.el,l=e.handler,h=e.capture,u=e.delegate,c=e.filter,d=e.self;a=He(a)?a.call(t):a||t.$el,Pe(a)?a.forEach(function(n){return o(t,ii({},e,{el:n}),i)}):!a||c&&!c.call(t)||(n=Ve(l)?t[l]:ge(l,t),l=function(t){return Pe(t.detail)?n.apply(void 0,[t].concat(t.detail)):n(t)},d&&(s=l,l=function(t){if(t.target===t.currentTarget||t.target===t.current)return s.call(null,t)}),t._events.push(ae(a,r,u?Ve(u)?u:u.call(t):null,l,h)))}function s(t,e){return t.every(function(t){return!t||!we(t,e)})}t.prototype.props={},t.prototype._init=function(i){i=i||{},i=this.$options=vi(this.constructor.options,i),this.$el=null,this.$name=t.prefix+ke(this.$options.name),this.$props={},this._frames={reads:{},writes:{}},this._events=[],this._uid=e++,this._initData(),this._initMethods(),this._initComputeds(),this._callHook("created"),i.el&&this.$mount(i.el)},t.prototype._initData=function(){var t=this.$options,e=t.defaults,i=t.data;void 0===i&&(i={});var n=t.args;void 0===n&&(n=[]);var o=t.props;void 0===o&&(o={});var s=t.el;for(var r in n.length&&Pe(i)&&(i=i.slice(0,n.length).reduce(function(t,e,i){return We(e)?ii(t,e):t[n[i]]=e,t},{})),ii({},e,o))this.$props[r]=this[r]=we(i,r)&&!qe(i[r])?Ke(o[r],i[r],s):e?e[r]&&Pe(e[r])?e[r].concat():e[r]:null},t.prototype._initMethods=function(){var t=this.$options.methods;if(t)for(var e in t)this[e]=ge(t[e],this)},t.prototype._initComputeds=function(){var t=this.$options.computed;if(this._resetComputeds(),t)for(var e in t)n(this,e,t[e])},t.prototype._resetComputeds=function(){this._computeds={}},t.prototype._initProps=function(t){var e;for(e in this._resetComputeds(),t=t||i(this.$options,this.$name))qe(t[e])||(this.$props[e]=t[e]);var n=[this.$options.computed,this.$options.methods];for(e in this.$props)e in t&&s(n,e)&&(this[e]=this.$props[e])},t.prototype._initEvents=function(){var t=this,e=this.$options.events;e&&e.forEach(function(e){if(we(e,"handler"))o(t,e);else for(var i in e)o(t,e[i],i)})},t.prototype._unbindEvents=function(){this._events.forEach(function(t){return t()}),this._events=[]},t.prototype._initObserver=function(){var t=this,e=this.$options,n=e.attrs,o=e.props,s=e.el;!this._observer&&o&&n&&a&&(n=Pe(n)?n:Object.keys(o).map(function(t){return ke(t)}),this._observer=new a(function(){var e=i(t.$options,t.$name);n.some(function(i){return!qe(e[i])&&e[i]!==t.$props[i]})&&t.$reset(e)}),this._observer.observe(s,{attributes:!0,attributeFilter:n.concat([this.$name,"data-"+this.$name])}))}}(zi),Oi=(Bi=zi).data,Bi.prototype.$mount=function(t){var e=this.$options.name;t[Oi]||(t[Oi]={}),t[Oi][e]||(t[Oi][e]=this,this.$el=this.$options.el=this.$options.el||t,this._initProps(),this._callHook("init"),Rt(t,r)&&this._callConnected())},Bi.prototype.$emit=function(t){this._callUpdate(t)},Bi.prototype.$update=function(t,e){Bi.update(t,this.$options.el,e)},Bi.prototype.$reset=function(t){this._callDisconnected(),this._initProps(t),this._callConnected()},Bi.prototype.$destroy=function(t){void 0===t&&(t=!1);var e=this.$options,i=e.el,n=e.name;i&&this._callDisconnected(),this._callHook("destroy"),i&&i[Oi]&&(delete i[Oi][n],Object.keys(i[Oi]).length||delete i[Oi],t&&_t(this.$el))},Hi=(Pi=zi).data,Pi.components={},Pi.component=function(t,e){var i=Ie(t);if(We(e))e.name=i,e=Pi.extend(e);else{if(qe(e))return Pi.components[i];e.options.name=i}return Pi.components[i]=e,Pi[i]=function(t,e){for(var n=arguments.length,o=Array(n);n--;)o[n]=arguments[n];return We(t)?new Pi.components[i]({data:t}):Pi.components[i].options.functional?new Pi.components[i]({data:[].concat(o)}):t&&t.nodeType?s(t):zt(t).map(s)[0];function s(t){var n=Pi.getComponent(t,i);return n&&e&&n.$reset(e),n||new Pi.components[i]({el:t,data:e||{}})}},Pi._initialized&&!e.options.functional&&hi.read(function(){return Pi[i]("[uk-"+t+"],[data-uk-"+t+"]")}),Pi.components[i]},Pi.getComponents=function(t){return t&&(t=te(t)?t[0]:t)&&t[Hi]||{}},Pi.getComponent=function(t,e){return Pi.getComponents(t)[e]},Pi.connect=function(t){var e;if(t[Hi])for(e in t[Hi])t[Hi][e]._callConnected();for(var i=0;i<t.attributes.length;i++)(e=Di(t.attributes[i].name))&&e in Pi.components&&Pi[e](t)},Pi.disconnect=function(t){for(var e in t[Hi])t[Hi][e]._callDisconnected()};var Wi,Li,ji={init:function(){I(this.$el,this.$name)}},Fi={props:{container:Boolean},defaults:{container:!0},computed:{container:function(t){var e=t.container;return!0===e&&zi.container||e&&Ht(e)}}},Vi={props:{cls:Boolean,animation:"list",duration:Number,origin:String,transition:String,queued:Boolean},defaults:{cls:!1,animation:[!1],duration:200,origin:!1,transition:"linear",queued:!1,initProps:{overflow:"",height:"",paddingTop:"",paddingBottom:"",marginTop:"",marginBottom:""},hideProps:{overflow:"hidden",height:0,paddingTop:0,paddingBottom:0,marginTop:0,marginBottom:0}},computed:{hasAnimation:function(t){return!!t.animation[0]},hasTransition:function(t){var e=t.animation;return this.hasAnimation&&!0===e[0]}},methods:{toggleElement:function(t,e,i){var n=this;return new be(function(o){var r,a=function(t){return be.all(t.map(function(t){return n._toggleElement(t,e,i)}))},l=(t=oe(t)).filter(function(t){return n.isToggled(t)}),h=t.filter(function(t){return!Oe(l,t)});if(n.queued&&qe(i)&&qe(e)&&n.hasAnimation&&!(t.length<2)){var u=s.body,c=u.scrollTop,d=l[0],f=ft.inProgress(d)&&_(d,"uk-animation-leave")||lt.inProgress(d)&&"0px"===d.style.height;r=a(l),f||(r=r.then(function(){var t=a(h);return u.scrollTop=c,t}))}else r=a(h.concat(l));r.then(o,si)})},toggleNow:function(t,e){var i=this;return new be(function(n){return be.all(oe(t).map(function(t){return i._toggleElement(t,e,!1)})).then(n,si)})},isToggled:function(t){var e=oe(t||this.$el);return this.cls?_(e,this.cls.split(" ")[0]):!y(e,"hidden")},updateAria:function(t){!1===this.cls&&b(t,"aria-hidden",!this.isToggled(t))},_toggleElement:function(t,e,i){var n=this;if(e=Fe(e)?e:ft.inProgress(t)?_(t,"uk-animation-leave"):lt.inProgress(t)?"0px"===t.style.height:!this.isToggled(t),!ue(t,"before"+(e?"show":"hide"),[this]))return be.reject();var o=(!1!==i&&this.hasAnimation?this.hasTransition?this._toggleHeight:this._toggleAnimation:this._toggleImmediate)(t,e);return ue(t,e?"show":"hide",[this]),o.then(function(){ue(t,e?"shown":"hidden",[n]),zi.update(null,t)})},_toggle:function(t,e){t&&(this.cls?S(t,this.cls,Oe(this.cls," ")?void 0:e):b(t,"hidden",e?null:""),zt("[autofocus]",t).some(function(t){return bt(t)&&(t.focus()||!0)}),this.updateAria(t),zi.update(null,t))},_toggleImmediate:function(t,e){return this._toggle(t,e),be.resolve()},_toggleHeight:function(t,e){var i,n=this,o=lt.inProgress(t),s=t.hasChildNodes?Je(M(t.firstElementChild,"marginTop"))+Je(M(t.lastElementChild,"marginBottom")):0,r=bt(t)?U(t)+(o?0:s):0;return lt.cancel(t),this.isToggled(t)||this._toggle(t,!0),U(t,""),hi.flush(),i=U(t)+(o?0:s),U(t,r),(e?lt.start(t,ii({},this.initProps,{overflow:"hidden",height:i}),Math.round(this.duration*(1-r/i)),this.transition):lt.start(t,this.hideProps,Math.round(this.duration*(r/i)),this.transition).then(function(){return n._toggle(t,!1)})).then(function(){return M(t,n.initProps)})},_toggleAnimation:function(t,e){var i=this;return ft.cancel(t),e?(this._toggle(t,!0),ft.in(t,this.animation[0],this.duration,this.origin)):ft.out(t,this.animation[1]||this.animation[0],this.duration,this.origin).then(function(){return i._toggle(t,!1)})}}},Ri={mixins:[ji,Fi,Vi],props:{clsPanel:String,selClose:String,escClose:Boolean,bgClose:Boolean,stack:Boolean},defaults:{cls:"uk-open",escClose:!0,bgClose:!0,overlay:!0,stack:!1},computed:{panel:function(t,e){return Ht("."+t.clsPanel,e)},transitionElement:function(){return this.panel},transitionDuration:function(){return ti(M(this.transitionElement,"transitionDuration"))}},events:[{name:"click",delegate:function(){return this.selClose},handler:function(t){t.preventDefault(),this.hide()}},{name:"toggle",self:!0,handler:function(t){t.defaultPrevented||(t.preventDefault(),this.toggle())}},{name:"beforeshow",self:!0,handler:function(t){var e=Wi&&Wi!==this&&Wi;if(Wi=this,e){if(!this.stack)return e.hide().then(this.show),void t.preventDefault();this.prev=e}!function(){if(Li)return;Li=[ae(r,"click",function(t){var e=t.target,i=t.defaultPrevented;Wi&&Wi.bgClose&&!i&&!Rt(e,Wi.panel||Wi.$el)&&Wi.hide()}),ae(s,"keydown",function(t){27===t.keyCode&&Wi&&Wi.escClose&&(t.preventDefault(),Wi.hide())})]}()}},{name:"beforehide",self:!0,handler:function(){(Wi=Wi&&Wi!==this&&Wi||this.prev)||(Li&&Li.forEach(function(t){return t()}),Li=null)}},{name:"show",self:!0,handler:function(){_(r,this.clsPage)||(this.scrollbarWidth=X(o)-r.offsetWidth,M(s.body,"overflowY",this.scrollbarWidth&&this.overlay?"scroll":"")),I(r,this.clsPage)}},{name:"hidden",self:!0,handler:function(){for(var t,e=this.prev;e;){if(e.clsPage===this.clsPage){t=!0;break}e=e.prev}t||T(r,this.clsPage),!this.prev&&M(s.body,"overflowY","")}}],methods:{toggle:function(){return this.isToggled()?this.hide():this.show()},show:function(){if(!this.isToggled())return this.container&&this.$el.parentNode!==this.container&&(It(this.container,this.$el),this._callConnected()),this.toggleNow(this.$el,!0)},hide:function(){if(this.isToggled())return this.toggleNow(this.$el,!1)},getActive:function(){return Wi},_toggleImmediate:function(t,e){var i=this;return new be(function(n){return l(function(){i._toggle(t,e),i.transitionDuration?he(i.transitionElement,"transitionend",n,!1,function(t){return t.target===i.transitionElement}):n()})})}}};var Yi={props:{pos:String,offset:null,flip:Boolean,clsPos:String},defaults:{pos:"bottom-"+(ot?"right":"left"),flip:!0,offset:!1,clsPos:""},computed:{pos:function(t){var e=t.pos;return(e+(Oe(e,"-")?"":"-center")).split("-")},dir:function(){return this.pos[0]},align:function(){return this.pos[1]}},methods:{positionAt:function(t,e,i){this._resetComputeds(),C(t,this.clsPos+"-(top|bottom|left|right)(-[a-z]+)?"),M(t,{top:"",left:""});var n,o=this.offset,s=this.getAxis();o=Ye(o)?o:(n=Ht(o))?R(n)["x"===s?"left":"top"]-R(e)["x"===s?"right":"bottom"]:0;var r=V(t,e,"x"===s?et(this.dir)+" "+this.align:this.align+" "+et(this.dir),"x"===s?this.dir+" "+this.align:this.align+" "+this.dir,"x"===s?""+("left"===this.dir?-o:o):" "+("top"===this.dir?-o:o),null,this.flip,i).target,a=r.x,l=r.y;this.dir="x"===s?a:l,this.align="x"===s?l:a,S(t,this.clsPos+"-"+this.dir+"-"+this.align,!1===this.offset)},getAxis:function(){return"top"===this.dir||"bottom"===this.dir?"y":"x"}}};function qi(t){t.component("accordion",{mixins:[ji,Vi],props:{targets:String,active:null,collapsible:Boolean,multiple:Boolean,toggle:String,content:String,transition:String},defaults:{targets:"> *",active:!1,animation:[!0],collapsible:!0,multiple:!1,clsOpen:"uk-open",toggle:"> .uk-accordion-title",content:"> .uk-accordion-content",transition:"ease"},computed:{items:function(t,e){return zt(t.targets,e)}},events:[{name:"click",delegate:function(){return this.targets+" "+this.$props.toggle},handler:function(t){t.preventDefault(),this.toggle(Ot(zt(this.targets+" "+this.$props.toggle,this.$el),t.current))}}],connected:function(){if(!1!==this.active){var t=this.items[Number(this.active)];t&&!_(t,this.clsOpen)&&this.toggle(t,!1)}},update:function(){var t=this;this.items.forEach(function(e){return t._toggleImmediate(Ht(t.content,e),_(e,t.clsOpen))});var e=!this.collapsible&&!_(this.items,this.clsOpen)&&this.items[0];e&&this.toggle(e,!1)},methods:{toggle:function(t,e){var i=this,n=mt(t,this.items),o=Vt(this.items,"."+this.clsOpen);(t=this.items[n])&&[t].concat(!this.multiple&&!Oe(o,t)&&o||[]).forEach(function(n){var s=n===t,r=s&&!_(n,i.clsOpen);if(r||!s||i.collapsible||!(o.length<2)){S(n,i.clsOpen,r);var a=n._wrapper?n._wrapper.firstElementChild:Ht(i.content,n);n._wrapper||(n._wrapper=St(a,"<div>"),b(n._wrapper,"hidden",r?"":null)),i._toggleImmediate(a,!0),i.toggleElement(n._wrapper,r,e).then(function(){_(n,i.clsOpen)===r&&(r||i._toggleImmediate(a,!1),n._wrapper=null,Nt(a))})}})}}})}function Ui(t){t.component("alert",{attrs:!0,mixins:[ji,Vi],args:"animation",props:{close:String},defaults:{animation:[!0],selClose:".uk-alert-close",duration:150,hideProps:ii({opacity:0},Vi.defaults.hideProps)},events:[{name:"click",delegate:function(){return this.selClose},handler:function(t){t.preventDefault(),this.close()}}],methods:{close:function(){var t=this;this.toggleElement(this.$el).then(function(){return t.$destroy(!0)})}}})}function Xi(t){rt(function(){var e=0,i=0;if(ae(o,"load resize",t.update),ae(o,"scroll",function(i){i.dir=e<=o.pageYOffset?"down":"up",i.scrollY=e=o.pageYOffset,t.update(i)}),ae(s,"animationstart",function(t){var e=t.target;(M(e,"animationName")||"").match(/^uk-.*(left|right)/)&&(i++,s.body.style.overflowX="hidden",setTimeout(function(){--i||(s.body.style.overflowX="")},ti(M(e,"animationDuration"))+100))},!0),c){var n="uk-hover";ae(s,"tap",function(t){var e=t.target;return zt("."+n).forEach(function(t){return!Rt(e,t)&&T(t,n)})}),Object.defineProperty(t,"hoverSelector",{set:function(t){ae(s,"tap",t,function(t){return I(t.current,n)})}}),t.hoverSelector=".uk-animation-toggle, .uk-transition-toggle, [uk-hover]"}})}function Ji(t){t.component("cover",{mixins:[ji,t.components.video.options],props:{width:Number,height:Number},defaults:{automute:!0},update:{write:function(){var t=this.$el;if(bt(t)){var e=t.parentNode,i=e.offsetHeight,n=e.offsetWidth;M(M(t,{width:"",height:""}),wt.cover({width:this.width||t.clientWidth,height:this.height||t.clientHeight},{width:n+(n%2?1:0),height:i+(i%2?1:0)}))}},events:["load","resize"]},events:{loadedmetadata:function(){this.$emit()}}})}function Gi(t){var e,i;t.component("drop",{mixins:[Yi,Vi],args:"pos",props:{mode:"list",toggle:Boolean,boundary:"query",boundaryAlign:Boolean,delayShow:Number,delayHide:Number,clsDrop:String},defaults:{mode:["click","hover"],toggle:!0,boundary:o,boundaryAlign:!1,delayShow:0,delayHide:800,clsDrop:!1,hoverIdle:200,animation:["uk-animation-fade"],cls:"uk-open"},computed:{clsDrop:function(t){var e=t.clsDrop;return e||"uk-"+this.$options.name},clsPos:function(){return this.clsDrop}},init:function(){this.tracker=new fi,I(this.$el,this.clsDrop)},connected:function(){var e=this.$props.toggle;this.toggle=e&&t.toggle(Ve(e)?Lt(e,this.$el):this.$el.previousElementSibling,{target:this.$el,mode:this.mode}),this.updateAria(this.$el)},events:[{name:"click",delegate:function(){return"."+this.clsDrop+"-close"},handler:function(t){t.preventDefault(),this.hide(!1)}},{name:"click",delegate:function(){return'a[href^="#"]'},handler:function(t){if(!t.defaultPrevented){var e=t.target.hash;e||t.preventDefault(),e&&Rt(e,this.$el)||this.hide(!1)}}},{name:"beforescroll",handler:function(){this.hide(!1)}},{name:"toggle",self:!0,handler:function(t,e){t.preventDefault(),this.isToggled()?this.hide(!1):this.show(e,!1)}},{name:m,filter:function(){return Oe(this.mode,"hover")},handler:function(t){_i(t)||(e&&e!==this&&e.toggle&&Oe(e.toggle.mode,"hover")&&!Rt(t.target,e.toggle.$el)&&!ai({x:t.pageX,y:t.pageY},R(e.$el))&&e.hide(!1),t.preventDefault(),this.show(this.toggle))}},{name:"toggleshow",handler:function(t,e){e&&!Oe(e.target,this.$el)||(t.preventDefault(),this.show(e||this.toggle))}},{name:"togglehide "+g,handler:function(t,e){_i(t)||e&&!Oe(e.target,this.$el)||(t.preventDefault(),this.toggle&&Oe(this.toggle.mode,"hover")&&this.hide())}},{name:"beforeshow",self:!0,handler:function(){this.clearTimers(),this.position()}},{name:"show",self:!0,handler:function(){this.tracker.init(),I(this.toggle.$el,this.cls),b(this.toggle.$el,"aria-expanded","true"),function(){if(i)return;i=!0,ae(r,"click",function(t){var i,n=t.target,o=t.defaultPrevented;if(!o)for(;e&&e!==i&&!Rt(n,e.$el)&&(!e.toggle||!Rt(n,e.toggle.$el));)i=e,e.hide(!1)})}()}},{name:"beforehide",self:!0,handler:function(){this.clearTimers()}},{name:"hide",handler:function(t){var i=t.target;this.$el===i?(e=this.isActive()?null:e,T(this.toggle.$el,this.cls),b(this.toggle.$el,"aria-expanded","false"),this.toggle.$el.blur(),zt("a, button",this.toggle.$el).forEach(function(t){return t.blur()}),this.tracker.cancel()):e=null===e&&Rt(i,this.$el)&&this.isToggled()?this:e}}],update:{write:function(){this.isToggled()&&!ft.inProgress(this.$el)&&this.position()},events:["resize"]},methods:{show:function(t,i){var n=this;void 0===i&&(i=!0);var o=function(){return!n.isToggled()&&n.toggleElement(n.$el,!0)},s=function(){if(n.toggle=t||n.toggle,n.clearTimers(),!n.isActive())if(i&&e&&e!==n&&e.isDelaying)n.showTimer=setTimeout(n.show,10);else{if(n.isParentOf(e)){if(!e.hideTimer)return;e.hide(!1)}else if(e&&!n.isChildOf(e)&&!n.isParentOf(e))for(var s;e&&e!==s&&!n.isChildOf(e);)s=e,e.hide(!1);i&&n.delayShow?n.showTimer=setTimeout(o,n.delayShow):o(),e=n}};t&&this.toggle&&t.$el!==this.toggle.$el?(he(this.$el,"hide",s),this.hide(!1)):s()},hide:function(t){var e=this;void 0===t&&(t=!0);var i=function(){return e.toggleNow(e.$el,!1)};this.clearTimers(),this.isDelaying=this.tracker.movesTo(this.$el),t&&this.isDelaying?this.hideTimer=setTimeout(this.hide,this.hoverIdle):t&&this.delayHide?this.hideTimer=setTimeout(i,this.delayHide):i()},clearTimers:function(){clearTimeout(this.showTimer),clearTimeout(this.hideTimer),this.showTimer=null,this.hideTimer=null,this.isDelaying=!1},isActive:function(){return e===this},isChildOf:function(t){return t&&t!==this&&Rt(this.$el,t.$el)},isParentOf:function(t){return t&&t!==this&&Rt(t.$el,this.$el)},position:function(){C(this.$el,this.clsDrop+"-(stack|boundary)"),M(this.$el,{top:"",left:"",display:"block"}),S(this.$el,this.clsDrop+"-boundary",this.boundaryAlign);var t=R(this.boundary),e=this.boundaryAlign?t:R(this.toggle.$el);if("justify"===this.align){var i="y"===this.getAxis()?"width":"height";M(this.$el,i,e[i])}else this.$el.offsetWidth>Math.max(t.right-e.left,e.right-t.left)&&I(this.$el,this.clsDrop+"-stack");this.positionAt(this.$el,this.boundaryAlign?this.boundary:this.toggle.$el,this.boundary),M(this.$el,"display","")}}}),t.drop.getActive=function(){return e}}function Zi(t){t.component("dropdown",t.components.drop.extend({name:"dropdown"}))}function Qi(t){t.component("form-custom",{mixins:[ji],args:"target",props:{target:Boolean},defaults:{target:!1},computed:{input:function(t,e){return Ht(yt,e)},state:function(){return this.input.nextElementSibling},target:function(t,e){var i=t.target;return i&&(!0===i&&this.input.parentNode===e&&this.input.nextElementSibling||Lt(i,e))}},connected:function(){ue(this.input,"change")},events:[{name:"focusin focusout mouseenter mouseleave",delegate:yt,handler:function(t){var e=t.type;t.current===this.input&&S(this.state,"uk-"+(Oe(e,"focus")?"focus":"hover"),Oe(["focusin","mouseenter"],e))}},{name:"change",handler:function(){var t,e=this.target,i=this.input;e&&(e[xt(e)?"value":"textContent"]=i.files&&i.files[0]?i.files[0].name:Gt(i,"select")&&(t=zt("option",i).filter(function(t){return t.selected})[0])?t.textContent:i.value)}}]})}function Ki(t){t.component("gif",{update:{read:function(t){var e=pt(this.$el);if(!e||t.isInView===e)return!1;t.isInView=e},write:function(){this.$el.src=this.$el.src},events:["scroll","load","resize"]}})}function tn(t){t.component("grid",t.components.margin.extend({mixins:[ji],name:"grid",defaults:{margin:"uk-grid-margin",clsStack:"uk-grid-stack"},update:{write:function(t){var e=t.stacks;S(this.$el,this.clsStack,e)},events:["load","resize"]}}))}function en(t){t.component("height-match",{args:"target",props:{target:String,row:Boolean},defaults:{target:"> *",row:!0},computed:{elements:function(t,e){return zt(t.target,e)}},update:{read:function(){var t=this,e=!1;return M(this.elements,"minHeight",""),{rows:this.row?this.elements.reduce(function(t,i){return e!==i.offsetTop?t.push([i]):t[t.length-1].push(i),e=i.offsetTop,t},[]).map(function(e){return t.match(e)}):[this.match(this.elements)]}},write:function(t){t.rows.forEach(function(t){var e=t.height;return M(t.elements,"minHeight",e)})},events:["load","resize"]},methods:{match:function(t){if(t.length<2)return{};var e=0,i=[];return t.forEach(function(t){var n,o;bt(t)||(n=b(t,"style"),o=b(t,"hidden"),b(t,{style:(n||"")+";display:block !important;",hidden:null})),e=Math.max(e,t.offsetHeight),i.push(t.offsetHeight),qe(n)||b(t,{style:n,hidden:o})}),t=t.filter(function(t,n){return i[n]<e}),{height:e,elements:t}}}})}function nn(t){function e(t){return t&&t.offsetHeight||0}t.component("height-viewport",{props:{expand:Boolean,offsetTop:Boolean,offsetBottom:Boolean,minHeight:Number},defaults:{expand:!1,offsetTop:!1,offsetBottom:!1,minHeight:0},update:{write:function(){M(this.$el,"boxSizing","border-box");var t,i=U(o),n=0;if(this.expand){M(this.$el,{height:"",minHeight:""});var s=i-e(r);s>0&&(t=e(this.$el)+s)}else{var a=R(this.$el).top;a<i/2&&this.offsetTop&&(n+=a),!0===this.offsetBottom?n+=e(this.$el.nextElementSibling):Ye(this.offsetBottom)?n+=i/100*this.offsetBottom:this.offsetBottom&&Ne(this.offsetBottom,"px")?n+=Je(this.offsetBottom):Ve(this.offsetBottom)&&(n+=e(Lt(this.offsetBottom,this.$el))),t=n?"calc(100vh - "+n+"px)":"100vh"}if(t){M(this.$el,{height:"",minHeight:t});var l=this.$el.offsetHeight;this.minHeight&&this.minHeight>l&&M(this.$el,"minHeight",this.minHeight),i-n>=l&&M(this.$el,"height",t)}},events:["load","resize"]}})}var on,sn='<svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg"><line fill="none" stroke="#000" stroke-width="1.1" x1="1" y1="1" x2="13" y2="13"/><line fill="none" stroke="#000" stroke-width="1.1" x1="13" y1="1" x2="1" y2="13"/></svg>',rn='<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><line fill="none" stroke="#000" stroke-width="1.4" x1="1" y1="1" x2="19" y2="19"/><line fill="none" stroke="#000" stroke-width="1.4" x1="19" y1="1" x2="1" y2="19"/></svg>',an='<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><rect x="9" y="4" width="1" height="11"/><rect x="4" y="9" width="11" height="1"/></svg>',ln='<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><rect y="9" width="20" height="2"/><rect y="3" width="20" height="2"/><rect y="15" width="20" height="2"/></svg>',hn='<svg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"><rect x="19" y="0" width="1" height="40"/><rect x="0" y="19" width="40" height="1"/></svg>',un='<svg width="7" height="12" viewBox="0 0 7 12" xmlns="http://www.w3.org/2000/svg"><polyline fill="none" stroke="#000" stroke-width="1.2" points="1 1 6 6 1 11"/></svg>',cn='<svg width="7" height="12" viewBox="0 0 7 12" xmlns="http://www.w3.org/2000/svg"><polyline fill="none" stroke="#000" stroke-width="1.2" points="6 1 1 6 6 11"/></svg>',dn='<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><circle fill="none" stroke="#000" stroke-width="1.1" cx="9" cy="9" r="7"/><path fill="none" stroke="#000" stroke-width="1.1" d="M14,14 L18,18 L14,14 Z"/></svg>',fn='<svg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg"><circle fill="none" stroke="#000" stroke-width="1.8" cx="17.5" cy="17.5" r="16.5"/><line fill="none" stroke="#000" stroke-width="1.8" x1="38" y1="39" x2="29" y2="30"/></svg>',pn='<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><circle fill="none" stroke="#000" stroke-width="1.1" cx="10.5" cy="10.5" r="9.5"/><line fill="none" stroke="#000" stroke-width="1.1" x1="23" y1="23" x2="17" y2="17"/></svg>',mn='<svg width="14px" height="24px" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg"><polyline fill="none" stroke="#000" stroke-width="1.4" points="1.225,23 12.775,12 1.225,1 "/></svg>',gn='<svg width="25px" height="40px" viewBox="0 0 25 40" xmlns="http://www.w3.org/2000/svg"><polyline fill="none" stroke="#000" stroke-width="2" points="4.002,38.547 22.527,20.024 4,1.5 "/></svg>',vn='<svg width="14px" height="24px" viewBox="0 0 14 24" xmlns="http://www.w3.org/2000/svg"><polyline fill="none" stroke="#000" stroke-width="1.4" points="12.775,1 1.225,12 12.775,23 "/></svg>',wn='<svg width="25px" height="40px" viewBox="0 0 25 40" xmlns="http://www.w3.org/2000/svg"><polyline fill="none" stroke="#000" stroke-width="2" points="20.527,1.5 2,20.024 20.525,38.547 "/></svg>',bn='<svg width="30" height="30" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg"><circle fill="none" stroke="#000" cx="15" cy="15" r="14"/></svg>',yn='<svg width="18" height="10" viewBox="0 0 18 10" xmlns="http://www.w3.org/2000/svg"><polyline fill="none" stroke="#000" stroke-width="1.2" points="1 9 9 1 17 9 "/></svg>';function xn(t){var e={},i={spinner:bn,totop:yn,marker:an,"close-icon":sn,"close-large":rn,"navbar-toggle-icon":ln,"overlay-icon":hn,"pagination-next":un,"pagination-previous":cn,"search-icon":dn,"search-large":fn,"search-navbar":pn,"slidenav-next":mn,"slidenav-next-large":gn,"slidenav-previous":vn,"slidenav-previous-large":wn};function n(e,i){t.component(e,t.components.icon.extend({name:e,mixins:i?[i]:[],defaults:{icon:e}}))}t.component("icon",t.components.svg.extend({attrs:["icon","ratio"],mixins:[ji],name:"icon",args:"icon",props:["icon"],defaults:{exclude:["id","style","class","src","icon"]},init:function(){I(this.$el,"uk-icon"),ot&&(this.icon=ei(ei(this.icon,"left","right"),"previous","next"))},methods:{getSvg:function(){var t=function(t){if(!i[t])return null;e[t]||(e[t]=Ht(i[t].trim()));return e[t]}(this.icon);return t?be.resolve(t):be.reject("Icon not found.")}}})),["marker","navbar-toggle-icon","overlay-icon","pagination-previous","pagination-next","totop"].forEach(function(t){return n(t)}),["slidenav-previous","slidenav-next"].forEach(function(t){return n(t,{init:function(){I(this.$el,"uk-slidenav"),_(this.$el,"uk-slidenav-large")&&(this.icon+="-large")}})}),n("search-icon",{init:function(){_(this.$el,"uk-search-icon")&&Kt(this.$el,".uk-search-large").length?this.icon="search-large":Kt(this.$el,".uk-search-navbar").length&&(this.icon="search-navbar")}}),n("close",{init:function(){this.icon="close-"+(_(this.$el,"uk-close-large")?"large":"icon")}}),n("spinner",{connected:function(){var t=this;this.svg.then(function(e){return 1!==t.ratio&&M(Ht("circle",e),"stroke-width",1/t.ratio)},si)}}),t.icon.add=function(n){Object.keys(n).forEach(function(t){i[t]=n[t],delete e[t]}),t._initialized&&ni(t.instances,function(t){"icon"===t.$options.name&&t.$reset()})}}function kn(t){t.component("leader",{mixins:[ji],props:{fill:String,media:"media"},defaults:{fill:"",media:!1,clsWrapper:"uk-leader-fill",clsHide:"uk-leader-hide",attrFill:"data-fill"},computed:{fill:function(t){var e=t.fill;return e||H("leader-fill")}},connected:function(){this.wrapper=At(this.$el,'<span class="'+this.clsWrapper+'">')[0]},disconnected:function(){Nt(this.wrapper.childNodes)},update:[{read:function(t){var e=t.changed,i=t.width,n=i;return{width:i=Math.floor(this.$el.offsetWidth/2),changed:e||n!==i,hide:this.media&&!o.matchMedia(this.media).matches}},write:function(t){S(this.wrapper,this.clsHide,t.hide),t.changed&&(t.changed=!1,b(this.wrapper,this.attrFill,new Array(t.width).join(this.fill)))},events:["load","resize"]}]})}function $n(t){t.component("margin",{props:{margin:String,firstColumn:Boolean},defaults:{margin:"uk-margin-small-top",firstColumn:"uk-first-column"},update:{read:function(t){var e=this.$el.children;if(!e.length||!bt(this.$el))return t.rows=!1;t.stacks=!0;for(var i=[[]],n=0;n<e.length;n++){var o=e[n],s=o.getBoundingClientRect();if(s.height)for(var r=i.length-1;r>=0;r--){var a=i[r];if(!a[0]){a.push(o);break}var l=a[0].getBoundingClientRect();if(s.top>=Math.floor(l.bottom)){i.push([o]);break}if(Math.floor(s.bottom)>l.top){if(t.stacks=!1,s.left<l.left&&!ot){a.unshift(o);break}a.push(o);break}if(0===r){i.unshift([o]);break}}}t.rows=i},write:function(t){var e=this;t.rows.forEach(function(t,i){return t.forEach(function(t,n){S(t,e.margin,0!==i),S(t,e.firstColumn,0===n)})})},events:["load","resize"]}})}function In(t){t.component("modal",{mixins:[Ri],defaults:{clsPage:"uk-modal-page",clsPanel:"uk-modal-dialog",selClose:".uk-modal-close, .uk-modal-close-default, .uk-modal-close-outside, .uk-modal-close-full"},events:[{name:"show",self:!0,handler:function(){_(this.panel,"uk-margin-auto-vertical")?I(this.$el,"uk-flex"):M(this.$el,"display","block"),U(this.$el)}},{name:"hidden",self:!0,handler:function(){M(this.$el,"display",""),T(this.$el,"uk-flex")}}]}),t.component("overflow-auto",{mixins:[ji],computed:{modal:function(t,e){return Qt(e,".uk-modal")},panel:function(t,e){return Qt(e,".uk-modal-dialog")}},connected:function(){M(this.$el,"minHeight",150)},update:{write:function(){if(this.panel&&this.modal){var t=M(this.$el,"maxHeight");M(M(this.$el,"maxHeight",150),"maxHeight",Math.max(150,150+U(this.modal)-this.panel.offsetHeight)),t!==M(this.$el,"maxHeight")&&ue(this.$el,"resize")}},events:["load","resize"]}}),t.modal.dialog=function(e,i){var n=t.modal(' <div class="uk-modal"> <div class="uk-modal-dialog">'+e+"</div> </div> ",i);return n.show(),ae(n.$el,"hidden",function(t){t.target===t.currentTarget&&n.$destroy(!0)}),n},t.modal.alert=function(e,i){return i=ii({bgClose:!1,escClose:!1,labels:t.modal.labels},i),new be(function(n){return ae(t.modal.dialog(' <div class="uk-modal-body">'+(Ve(e)?e:$t(e))+'</div> <div class="uk-modal-footer uk-text-right"> <button class="uk-button uk-button-primary uk-modal-close" autofocus>'+i.labels.ok+"</button> </div> ",i).$el,"hide",n)})},t.modal.confirm=function(e,i){return i=ii({bgClose:!1,escClose:!0,labels:t.modal.labels},i),new be(function(n,o){var s=!1,r=t.modal.dialog(' <form> <div class="uk-modal-body">'+(Ve(e)?e:$t(e))+'</div> <div class="uk-modal-footer uk-text-right"> <button class="uk-button uk-button-default uk-modal-close" type="button">'+i.labels.cancel+'</button> <button class="uk-button uk-button-primary" autofocus>'+i.labels.ok+"</button> </div> </form> ",i);ae(r.$el,"submit","form",function(t){t.preventDefault(),n(),s=!0,r.hide()}),ae(r.$el,"hide",function(){s||o()})})},t.modal.prompt=function(e,i,n){return n=ii({bgClose:!1,escClose:!0,labels:t.modal.labels},n),new be(function(o){var s=!1,r=t.modal.dialog(' <form class="uk-form-stacked"> <div class="uk-modal-body"> <label>'+(Ve(e)?e:$t(e))+'</label> <input class="uk-input" autofocus> </div> <div class="uk-modal-footer uk-text-right"> <button class="uk-button uk-button-default uk-modal-close" type="button">'+n.labels.cancel+'</button> <button class="uk-button uk-button-primary">'+n.labels.ok+"</button> </div> </form> ",n),a=Ht("input",r.$el);a.value=i,ae(r.$el,"submit","form",function(t){t.preventDefault(),o(a.value),s=!0,r.hide()}),ae(r.$el,"hide",function(){s||o(null)})})},t.modal.labels={ok:"Ok",cancel:"Cancel"}}function Tn(t){t.component("nav",t.components.accordion.extend({name:"nav",defaults:{targets:"> .uk-parent",toggle:"> a",content:"> ul"}}))}function Cn(t){t.component("navbar",{mixins:[ji],props:{dropdown:String,mode:"list",align:String,offset:Number,boundary:Boolean,boundaryAlign:Boolean,clsDrop:String,delayShow:Number,delayHide:Number,dropbar:Boolean,dropbarMode:String,dropbarAnchor:"query",duration:Number},defaults:{dropdown:".uk-navbar-nav > li",align:ot?"right":"left",clsDrop:"uk-navbar-dropdown",mode:void 0,offset:void 0,delayShow:void 0,delayHide:void 0,boundaryAlign:void 0,flip:"x",boundary:!0,dropbar:!1,dropbarMode:"slide",dropbarAnchor:!1,duration:200},computed:{boundary:function(t,e){var i=t.boundary,n=t.boundaryAlign;return!0===i||n?e:i},pos:function(t){return"bottom-"+t.align}},beforeConnect:function(){var t=this.$props.dropbar;this.dropbar=t&&(Ve(t)&&Lt(t,this.$el)||Ht("<div></div>")),this.dropbar&&(I(this.dropbar,"uk-navbar-dropbar"),"slide"===this.dropbarMode&&I(this.dropbar,"uk-navbar-dropbar-slide"))},disconnected:function(){this.dropbar&&_t(this.dropbar)},update:function(){t.drop(zt(this.dropdown+" ."+this.clsDrop,this.$el).filter(function(e){return!t.getComponent(e,"drop")&&!t.getComponent(e,"dropdown")}),ii({},this.$props,{boundary:this.boundary,pos:this.pos,offset:this.dropbar||this.offset}))},events:[{name:"mouseover",delegate:function(){return this.dropdown},handler:function(t){var e=t.current,i=this.getActive();i&&i.toggle&&!Rt(i.toggle.$el,e)&&!i.tracker.movesTo(i.$el)&&i.hide(!1)}},{name:"mouseleave",el:function(){return this.dropbar},handler:function(){var t=this.getActive();t&&!Gt(this.dropbar,":hover")&&t.hide()}},{name:"beforeshow",capture:!0,filter:function(){return this.dropbar},handler:function(){this.dropbar.parentNode||Ct(this.dropbarAnchor||this.$el,this.dropbar)}},{name:"show",capture:!0,filter:function(){return this.dropbar},handler:function(t,e){var i=e.$el;this.clsDrop&&I(i,this.clsDrop+"-dropbar"),this.transitionTo(i.offsetHeight+Je(M(i,"margin-top"))+Je(M(i,"margin-bottom")),i)}},{name:"beforehide",filter:function(){return this.dropbar},handler:function(t,e){var i=e.$el,n=this.getActive();Gt(this.dropbar,":hover")&&n&&n.$el===i&&t.preventDefault()}},{name:"hide",filter:function(){return this.dropbar},handler:function(t,e){var i=e.$el,n=this.getActive();(!n||n&&n.$el===i)&&this.transitionTo(0)}}],methods:{getActive:function(){var e=t.drop.getActive();return e&&Oe(e.mode,"hover")&&Rt(e.toggle.$el,this.$el)&&e},transitionTo:function(t,e){var i=this.dropbar,n=bt(i)?U(i):0;return M(e=n<t&&e,{height:n,overflow:"hidden"}),U(i,n),lt.cancel([e,i]),lt.start([e,i],{height:t},this.duration).catch(si).finally(function(){return M(e,{height:"",overflow:""})})}}})}function En(t){t.component("offcanvas",{mixins:[Ri],args:"mode",props:{content:String,mode:String,flip:Boolean,overlay:Boolean},defaults:{content:".uk-offcanvas-content",mode:"slide",flip:!1,overlay:!1,clsPage:"uk-offcanvas-page",clsContainer:"uk-offcanvas-container",clsPanel:"uk-offcanvas-bar",clsFlip:"uk-offcanvas-flip",clsContent:"uk-offcanvas-content",clsContentAnimation:"uk-offcanvas-content-animation",clsSidebarAnimation:"uk-offcanvas-bar-animation",clsMode:"uk-offcanvas",clsOverlay:"uk-offcanvas-overlay",selClose:".uk-offcanvas-close"},computed:{content:function(t){var e=t.content;return Ht(e)||s.body},clsFlip:function(t){var e=t.flip,i=t.clsFlip;return e?i:""},clsOverlay:function(t){var e=t.overlay,i=t.clsOverlay;return e?i:""},clsMode:function(t){var e=t.mode,i=t.clsMode;return i+"-"+e},clsSidebarAnimation:function(t){var e=t.mode,i=t.clsSidebarAnimation;return"none"===e||"reveal"===e?"":i},clsContentAnimation:function(t){var e=t.mode,i=t.clsContentAnimation;return"push"!==e&&"reveal"!==e?"":i},transitionElement:function(t){return"reveal"===t.mode?this.panel.parentNode:this.panel}},update:{write:function(){this.getActive()===this&&((this.overlay||this.clsContentAnimation)&&X(this.content,X(o)-this.scrollbarWidth),this.overlay&&(U(this.content,U(o)),on&&(this.content.scrollTop=on.y)))},events:["resize"]},events:[{name:"click",delegate:function(){return'a[href^="#"]'},handler:function(t){var e=t.current;e.hash&&Ht(e.hash,this.content)&&(on=null,this.hide())}},{name:"beforescroll",filter:function(){return this.overlay},handler:function(t,e,i){e&&i&&this.isToggled()&&Ht(i,this.content)&&(he(this.$el,"hidden",function(){return e.scrollTo(i)}),t.preventDefault())}},{name:"show",self:!0,handler:function(){on=on||{x:o.pageXOffset,y:o.pageYOffset},"reveal"!==this.mode||_(this.panel,this.clsMode)||(St(this.panel,"<div>"),I(this.panel.parentNode,this.clsMode)),M(r,"overflowY",(!this.clsContentAnimation||this.flip)&&this.scrollbarWidth&&this.overlay?"scroll":""),I(s.body,this.clsContainer,this.clsFlip,this.clsOverlay),U(s.body),I(this.content,this.clsContentAnimation),I(this.panel,this.clsSidebarAnimation+" "+("reveal"!==this.mode?this.clsMode:"")),I(this.$el,this.clsOverlay),M(this.$el,"display","block"),U(this.$el)}},{name:"hide",self:!0,handler:function(){T(this.content,this.clsContentAnimation);var t=this.getActive();("none"===this.mode||t&&t!==this&&t!==this.prev)&&ue(this.panel,"transitionend")}},{name:"hidden",self:!0,handler:function(){if("reveal"===this.mode&&Nt(this.panel),this.overlay){if(!on){var t=this.content,e=t.scrollLeft,i=t.scrollTop;on={x:e,y:i}}}else on={x:o.pageXOffset,y:o.pageYOffset};T(this.panel,this.clsSidebarAnimation,this.clsMode),T(this.$el,this.clsOverlay),M(this.$el,"display",""),T(s.body,this.clsContainer,this.clsFlip,this.clsOverlay),s.body.scrollTop=on.y,M(r,"overflow-y",""),X(this.content,""),U(this.content,""),o.scrollTo(on.x,on.y),on=null}},{name:"swipeLeft swipeRight",handler:function(t){this.isToggled()&&_i(t)&&("swipeLeft"===t.type&&!this.flip||"swipeRight"===t.type&&this.flip)&&this.hide()}}]})}function _n(t){t.component("responsive",{props:["width","height"],init:function(){I(this.$el,"uk-responsive-width")},update:{read:function(){return!!(bt(this.$el)&&this.width&&this.height)&&{width:X(this.$el.parentNode),height:this.height}},write:function(t){U(this.$el,wt.contain({height:this.height,width:this.width},t).height)},events:["load","resize"]}})}function Sn(t){t.component("scroll",{props:{duration:Number,offset:Number},defaults:{duration:1e3,offset:0},methods:{scrollTo:function(t){var e=this,i=R(t=t&&Ht(t)||s.body).top-this.offset,n=U(s),r=U(o);if(i+r>n&&(i=n-r),ue(this.$el,"beforescroll",[this,t])){var a=Date.now(),h=o.pageYOffset,u=function(){var n,s=h+(i-h)*(n=oi((Date.now()-a)/e.duration),.5*(1-Math.cos(Math.PI*n)));o.scrollTo(o.pageXOffset,s),s!==i?l(u):ue(e.$el,"scrolled",[e,t])};u()}}},events:{click:function(t){t.defaultPrevented||(t.preventDefault(),this.scrollTo(re(this.$el.hash).substr(1)))}}})}function An(t){t.component("scrollspy",{args:"cls",props:{cls:"list",target:String,hidden:Boolean,offsetTop:Number,offsetLeft:Number,repeat:Boolean,delay:Number},defaults:{cls:["uk-scrollspy-inview"],target:!1,hidden:!0,offsetTop:0,offsetLeft:0,repeat:!1,delay:0,inViewClass:"uk-scrollspy-inview"},computed:{elements:function(t,e){var i=t.target;return i?zt(i,e):[e]}},update:[{write:function(){this.hidden&&M(Vt(this.elements,":not(."+this.inViewClass+")"),"visibility","hidden")}},{read:function(e){var i=this;if(!t._initialized)return!1;this.elements.forEach(function(t,n){var o=e[n];if(!o){var s=$(t,"uk-scrollspy-class");o={toggles:s&&s.split(",")||i.cls}}o.show=pt(t,i.offsetTop,i.offsetLeft),e[n]=o})},write:function(e){var i=this,n=1===this.elements.length?1:0;this.elements.forEach(function(o,s){var r=e[s],a=r.toggles[s]||r.toggles[0];if(r.show){if(!r.inview&&!r.timer){var l=function(){M(o,"visibility",""),I(o,i.inViewClass),S(o,a),ue(o,"inview"),t.update(null,o),r.inview=!0,delete r.timer};i.delay&&n?r.timer=setTimeout(l,i.delay*n):l(),n++}}else r.inview&&i.repeat&&(r.timer&&(clearTimeout(r.timer),delete r.timer),M(o,"visibility",i.hidden?"hidden":""),T(o,i.inViewClass),S(o,a),ue(o,"outview"),t.update(null,o),r.inview=!1)})},events:["scroll","load","resize"]}]})}function Nn(t){t.component("scrollspy-nav",{props:{cls:String,closest:String,scroll:Boolean,overflow:Boolean,offset:Number},defaults:{cls:"uk-active",closest:!1,scroll:!1,overflow:!0,offset:0},computed:{links:function(t,e){return zt('a[href^="#"]',e).filter(function(t){return t.hash})},elements:function(){return this.closest?Qt(this.links,this.closest):this.links},targets:function(){return zt(this.links.map(function(t){return t.hash}).join(","))}},update:[{read:function(){this.scroll&&t.scroll(this.links,{offset:this.offset||0})}},{read:function(t){var e=this,i=o.pageYOffset+this.offset+1,n=U(s)-U(o)+this.offset;t.active=!1,this.targets.every(function(o,s){var r=R(o).top,a=s+1===e.targets.length;if(!e.overflow&&(0===s&&r>i||a&&r+o.offsetTop<i))return!1;if(!a&&R(e.targets[s+1]).top<=i)return!0;if(i>=n)for(var l=e.targets.length-1;l>s;l--)if(pt(e.targets[l])){o=e.targets[l];break}return!(t.active=Ht(Vt(e.links,'[href="#'+o.id+'"]')))})},write:function(t){var e=t.active;this.links.forEach(function(t){return t.blur()}),T(this.elements,this.cls),e&&ue(this.$el,"active",[e,I(this.closest?Qt(e,this.closest):e,this.cls)])},events:["scroll","load","resize"]}]})}function Dn(t){t.component("sticky",{mixins:[ji],attrs:!0,props:{top:null,bottom:Boolean,offset:Number,animation:String,clsActive:String,clsInactive:String,clsFixed:String,clsBelow:String,selTarget:String,widthElement:"query",showOnUp:Boolean,media:"media",target:Number},defaults:{top:0,bottom:!1,offset:0,animation:"",clsActive:"uk-active",clsInactive:"",clsFixed:"uk-sticky-fixed",clsBelow:"uk-sticky-below",selTarget:"",widthElement:!1,showOnUp:!1,media:!1,target:!1},computed:{selTarget:function(t,e){var i=t.selTarget;return i&&Ht(i,e)||e}},connected:function(){this.placeholder=Ht('<div class="uk-sticky-placeholder"></div>'),this.widthElement=this.$props.widthElement||this.placeholder,this.isActive||this.hide()},disconnected:function(){this.isActive&&(this.isActive=!1,this.hide(),T(this.selTarget,this.clsInactive)),_t(this.placeholder),this.placeholder=null,this.widthElement=null},ready:function(){var t=this;if(this.target&&location.hash&&o.pageYOffset>0){var e=Ht(location.hash);e&&hi.read(function(){var i=R(e).top,n=R(t.$el).top,s=t.$el.offsetHeight;n+s>=i&&n<=i+e.offsetHeight&&o.scrollTo(0,i-s-t.target-t.offset)})}},events:[{name:"active",self:!0,handler:function(){E(this.selTarget,this.clsInactive,this.clsActive)}},{name:"inactive",self:!0,handler:function(){E(this.selTarget,this.clsActive,this.clsInactive)}}],update:[{write:function(){var t,e=this,i=this.placeholder,n=(this.isActive?i:this.$el).offsetHeight;M(i,ii({height:"absolute"!==M(this.$el,"position")?n:""},M(this.$el,["marginTop","marginBottom","marginLeft","marginRight"]))),Rt(i,r)||(Ct(this.$el,i),b(i,"hidden","")),b(this.widthElement,"hidden",null),this.width=this.widthElement.offsetWidth,b(this.widthElement,"hidden",this.isActive?null:""),this.topOffset=R(this.isActive?i:this.$el).top,this.bottomOffset=this.topOffset+n,["top","bottom"].forEach(function(i){e[i]=e.$props[i],e[i]&&(Ye(e[i])?e[i]=e[i+"Offset"]+Je(e[i]):Ve(e[i])&&e[i].match(/^-?\d+vh$/)?e[i]=U(o)*Je(e[i])/100:(t=!0===e[i]?e.$el.parentNode:Lt(e[i],e.$el))&&(e[i]=R(t).top+t.offsetHeight))}),this.top=Math.max(Je(this.top),this.topOffset)-this.offset,this.bottom=this.bottom&&this.bottom-n,this.inactive=this.media&&!o.matchMedia(this.media).matches,this.isActive&&this.update()},events:["load","resize"]},{read:function(t,e){var i=e.scrollY;return void 0===i&&(i=o.pageYOffset),{scroll:this.scroll=i,visible:bt(this.$el)}},write:function(t,e){var i=this,n=t.visible,o=t.scroll;void 0===e&&(e={});var s=e.dir;if(!(o<0||!n||this.disabled||this.showOnUp&&!s))if(this.inactive||o<this.top||this.showOnUp&&(o<=this.top||"down"===s||"up"===s&&!this.isActive&&o<=this.bottomOffset)){if(!this.isActive)return;this.isActive=!1,this.animation&&o>this.topOffset?(ft.cancel(this.$el),ft.out(this.$el,this.animation).then(function(){return i.hide()},si)):this.hide()}else this.isActive?this.update():this.animation?(ft.cancel(this.$el),this.show(),ft.in(this.$el,this.animation).catch(si)):this.show()},events:["scroll"]}],methods:{show:function(){this.isActive=!0,this.update(),b(this.placeholder,"hidden",null)},hide:function(){this.isActive&&!_(this.selTarget,this.clsActive)||ue(this.$el,"inactive"),T(this.$el,this.clsFixed,this.clsBelow),M(this.$el,{position:"",top:"",width:""}),b(this.placeholder,"hidden","")},update:function(){var t=Math.max(0,this.offset),e=0!==this.top||this.scroll>this.top;this.bottom&&this.scroll>this.bottom-this.offset&&(t=this.bottom-this.scroll),M(this.$el,{position:"fixed",top:t+"px",width:this.width}),_(this.selTarget,this.clsActive)?e||ue(this.$el,"inactive"):e&&ue(this.$el,"active"),S(this.$el,this.clsBelow,this.scroll>this.bottomOffset),I(this.$el,this.clsFixed)}}})}var Mn,Bn,On={};function Pn(t){t.component("svg",{attrs:!0,props:{id:String,icon:String,src:String,style:String,width:Number,height:Number,ratio:Number,class:String},defaults:{ratio:1,id:!1,exclude:["src"],class:""},init:function(){this.class+=" uk-svg"},connected:function(){var t=this;if(!this.icon&&Oe(this.src,"#")){var n=this.src.split("#");n.length>1&&(this.src=n[0],this.icon=n[1])}this.svg=this.getSvg().then(function(n){var o;if(Ve(n)?(t.icon&&Oe(n,"<symbol")&&(n=function(t,n){if(!i[t]){var o;for(i[t]={};o=e.exec(t);)i[t][o[3]]='<svg xmlns="http://www.w3.org/2000/svg"'+o[1]+"svg>"}return i[t][n]}(n,t.icon)||n),o=Ht(n.substr(n.indexOf("<svg")))):o=n.cloneNode(!0),!o)return be.reject("SVG not found.");var s=b(o,"viewBox");for(var r in s&&(s=s.split(" "),t.width=t.$props.width||s[2],t.height=t.$props.height||s[3]),t.width*=t.ratio,t.height*=t.ratio,t.$options.props)t[r]&&!Oe(t.exclude,r)&&b(o,r,t[r]);t.id||x(o,"id"),t.width&&!t.height&&x(o,"height"),t.height&&!t.width&&x(o,"width");var a=t.$el;if(vt(a)||"CANVAS"===a.tagName){b(a,{hidden:!0,id:null});var l=a.nextElementSibling;l&&o.isEqualNode(l)?o=l:Ct(a,o)}else{var h=a.lastElementChild;h&&o.isEqualNode(h)?o=h:It(a,o)}return t.svgEl=o,o},si)},disconnected:function(){var t=this;vt(this.$el)&&b(this.$el,{hidden:null,id:this.id||null}),this.svg&&this.svg.then(function(e){return(!t._connected||e!==t.svgEl)&&_t(e)},si),this.svg=this.svgEl=null},methods:{getSvg:function(){var t=this;return this.src?On[this.src]?On[this.src]:(On[this.src]=new be(function(e,i){Se(t.src,"data:")?e(decodeURIComponent(t.src.split(",")[1])):li(t.src).then(function(t){return e(t.response)},function(){return i("SVG not found.")})}),On[this.src]):be.reject()}}});var e=/<symbol(.*?id=(['"])(.*?)\2[^]*?<\/)symbol>/g,i={}}function Hn(t){t.component("switcher",{mixins:[Vi],args:"connect",props:{connect:String,toggle:String,active:Number,swiping:Boolean},defaults:{connect:"~.uk-switcher",toggle:"> *",active:0,swiping:!0,cls:"uk-active",clsContainer:"uk-switcher",attrItem:"uk-switcher-item",queued:!0},computed:{connects:function(t,e){return jt(t.connect,e)},toggles:function(t,e){return zt(t.toggle,e)}},events:[{name:"click",delegate:function(){return this.toggle+":not(.uk-disabled)"},handler:function(t){t.preventDefault(),this.show(t.current)}},{name:"click",el:function(){return this.connects},delegate:function(){return"["+this.attrItem+"],[data-"+this.attrItem+"]"},handler:function(t){t.preventDefault(),this.show($(t.current,this.attrItem))}},{name:"swipeRight swipeLeft",filter:function(){return this.swiping},el:function(){return this.connects},handler:function(t){_i(t)&&(t.preventDefault(),o.getSelection().toString()||this.show("swipeLeft"===t.type?"next":"previous"))}}],update:function(){var t=this;this.connects.forEach(function(e){return t.updateAria(e.children)}),this.show(Vt(this.toggles,"."+this.cls)[0]||this.toggles[this.active]||this.toggles[0])},methods:{show:function(t){for(var e,i=this,n=this.toggles.length,o=!!this.connects.length&&Ot(Vt(this.connects[0].children,"."+this.cls)[0]),s=o>=0,r=mt(t,this.toggles,o),a="previous"===t?-1:1,l=0;l<n;l++,r=(r+a+n)%n)if(!Gt(i.toggles[r],".uk-disabled, [disabled]")){e=i.toggles[r];break}!e||o>=0&&_(e,this.cls)||o===r||(T(this.toggles,this.cls),b(this.toggles,"aria-expanded",!1),I(e,this.cls),b(e,"aria-expanded",!0),this.connects.forEach(function(t){s?i.toggleElement([t.children[o],t.children[r]]):i.toggleNow(t.children[r])}))}}})}function zn(t){t.component("tab",t.components.switcher.extend({mixins:[ji],name:"tab",props:{media:"media"},defaults:{media:960,attrItem:"uk-tab-item"},init:function(){var e=_(this.$el,"uk-tab-left")?"uk-tab-left":!!_(this.$el,"uk-tab-right")&&"uk-tab-right";e&&t.toggle(this.$el,{cls:e,mode:"media",media:this.media})}}))}function Wn(t){t.component("toggle",{mixins:[t.mixin.togglable],args:"target",props:{href:String,target:null,mode:"list",media:"media"},defaults:{href:!1,target:!1,mode:"click",queued:!0,media:!1},computed:{target:function(t,e){var i=t.href,n=t.target;return n=jt(n||i,e),n.length&&n||[e]}},events:[{name:m+" "+g,filter:function(){return Oe(this.mode,"hover")},handler:function(t){_i(t)||this.toggle("toggle"+(t.type===m?"show":"hide"))}},{name:"click",filter:function(){return Oe(this.mode,"click")||c},handler:function(t){var e;(_i(t)||Oe(this.mode,"click"))&&((Qt(t.target,'a[href="#"], button')||(e=Qt(t.target,"a[href]"))&&(this.cls||!bt(this.target)||e.hash&&Gt(this.target,e.hash)))&&he(s,"click",function(t){return t.preventDefault()}),this.toggle())}}],update:{write:function(){if(Oe(this.mode,"media")&&this.media){var t=this.isToggled(this.target);(o.matchMedia(this.media).matches?!t:t)&&this.toggle()}},events:["load","resize"]},methods:{toggle:function(t){ue(this.target,t||"toggle",[this])&&this.toggleElement(this.target)}}})}function Ln(t){t.component("video",{props:{automute:Boolean,autoplay:Boolean},defaults:{automute:!1,autoplay:!0},computed:{inView:function(t){return"inview"===t.autoplay}},ready:function(){this.player=new bi(this.$el),this.automute&&this.player.mute()},update:[{read:function(t,e){var i=e.type;return!(!this.player||!("scroll"!==i&&"resize"!==i||this.inView))&&{visible:bt(this.$el)&&"hidden"!==M(this.$el,"visibility"),inView:this.inView&&pt(this.$el)}},write:function(t){var e=t.visible,i=t.inView;!e||this.inView&&!i?this.player.pause():(!0===this.autoplay||this.inView&&i)&&this.player.play()},events:["load","resize","scroll"]}]})}function jn(t,e){return void 0===t&&(t=0),void 0===e&&(e="%"),"translateX("+t+(t?e:"")+")"}function Fn(t){return"scale3d("+t+", "+t+", 1)"}function Vn(t){if(!Vn.installed){var e,i,n,o,s,r,a,l,h,u,c,d,f,p,m,g,v,w,b,y,x,k,$,I,T,C,E,_=t.util,S=_.$,A=_.assign,N=_.clamp,D=_.fastdom,M=_.getIndex,B=_.hasClass,O=_.isNumber,P=_.isRtl,H=_.Promise,z=_.toNodes,W=_.trigger;t.mixin.slider={attrs:!0,mixins:[(I=t,T=I.util,C=T.doc,E=T.pointerDown,{props:{autoplay:Boolean,autoplayInterval:Number,pauseOnHover:Boolean},defaults:{autoplay:!1,autoplayInterval:7e3,pauseOnHover:!0},connected:function(){this.startAutoplay()},disconnected:function(){this.stopAutoplay()},events:[{name:"visibilitychange",el:C,handler:function(){C.hidden?this.stopAutoplay():this.startAutoplay()}},{name:E,handler:"stopAutoplay"},{name:"mouseenter",filter:function(){return this.autoplay},handler:function(){this.isHovering=!0}},{name:"mouseleave",filter:function(){return this.autoplay},handler:function(){this.isHovering=!1}}],methods:{startAutoplay:function(){var t=this;this.stopAutoplay(),this.autoplay&&(this.interval=setInterval(function(){return!(t.isHovering&&t.pauseOnHover)&&!t.stack.length&&t.show("next")},this.autoplayInterval))},stopAutoplay:function(){this.interval&&clearInterval(this.interval)}}}),(h=t,u=h.util,c=u.doc,d=u.getPos,f=u.includes,p=u.isRtl,m=u.isTouch,g=u.off,v=u.on,w=u.pointerDown,b=u.pointerMove,y=u.pointerUp,x=u.preventClick,k=u.trigger,$=u.win,{defaults:{threshold:10,preventCatch:!1},init:function(){var t=this;["start","move","end"].forEach(function(e){var i=t[e];t[e]=function(e){var n=d(e).x*(p?-1:1);t.prevPos=n!==t.pos?t.pos:t.prevPos,t.pos=n,i(e)}})},events:[{name:w,delegate:function(){return this.slidesSelector},handler:function(t){var e;!m(t)&&!(e=t.target).children.length&&e.childNodes.length||t.button>0||this.length<2||this.preventCatch||this.start(t)}},{name:"dragstart",handler:function(t){t.preventDefault()}}],methods:{start:function(){this.drag=this.pos,this._transitioner?(this.percent=this._transitioner.percent(),this.drag+=this._transitioner.getDistance()*this.percent*this.dir,this._transitioner.translate(this.percent),this._transitioner.cancel(),this.dragging=!0,this.stack=[]):this.prevIndex=this.index,this.unbindMove=v(c,b,this.move,{capture:!0,passive:!1}),v($,"scroll",this.unbindMove),v(c,y,this.end,!0)},move:function(t){var e=this,i=this.pos-this.drag;if(!(0===i||this.prevPos===this.pos||!this.dragging&&Math.abs(i)<this.threshold)){t.cancelable&&t.preventDefault(),this.dragging=!0,this.dir=i<0?1:-1;for(var n=this.slides,o=this.prevIndex,s=Math.abs(i),r=this.getIndex(o+this.dir,o),a=this._getDistance(o,r)||n[o].offsetWidth;r!==o&&s>a;)e.drag-=a*e.dir,o=r,s-=a,r=e.getIndex(o+e.dir,o),a=e._getDistance(o,r)||n[o].offsetWidth;this.percent=s/a;var l,h=n[o],u=n[r],c=this.index!==r,d=o===r;[this.index,this.prevIndex].filter(function(t){return!f([r,o],t)}).forEach(function(t){k(n[t],"itemhidden",[e]),l=!0,d&&(e.prevIndex=o)}),(this.index===o&&this.prevIndex!==o||l&&d)&&k(n[this.index],"itemshown",[this]),c&&(this.prevIndex=o,this.index=r,!d&&k(h,"beforeitemhide",[this]),k(u,"beforeitemshow",[this])),l&&this._transitioner&&this._transitioner.reset(),this._transitioner=this._translate(Math.abs(this.percent),h,!d&&u),c&&(!d&&k(h,"itemhide",[this]),k(u,"itemshow",[this]))}},end:function(){if(g($,"scroll",this.unbindMove),this.unbindMove(),g(c,y,this.end,!0),this.dragging){if(this.dragging=null,this.index===this.prevIndex)this.percent=1-this.percent,this.dir*=-1,this._show(!1,this.index,!0),this._transitioner=null;else{var t=(p?this.dir*(p?1:-1):this.dir)<0==this.prevPos>this.pos;this.index=t?this.index:this.prevIndex,t&&(this.percent=1-this.percent),this.show(this.dir>0&&!t||this.dir<0&&t?"next":"previous",!0)}x()}this.drag=this.percent=null}}}),(e=t,i=e.util,n=i.$,o=i.$$,s=i.data,r=i.html,a=i.toggleClass,l=i.toNumber,{defaults:{selNav:!1},computed:{nav:function(t,e){var i=t.selNav;return n(i,e)},navItemSelector:function(t){var e=t.attrItem;return"["+e+"],[data-"+e+"]"},navItems:function(t,e){return o(this.navItemSelector,e)}},update:[{write:function(){var t=this;this.nav&&this.length!==this.nav.children.length&&r(this.nav,this.slides.map(function(e,i){return"<li "+t.attrItem+'="'+i+'"><a href="#"></a></li>'}).join("")),a(o(this.navItemSelector,this.$el).concat(this.nav),"uk-hidden",!this.maxIndex),this.updateNav()},events:["load","resize"]}],events:[{name:"click",delegate:function(){return this.navItemSelector},handler:function(t){t.preventDefault(),t.current.blur(),this.show(s(t.current,this.attrItem))}},{name:"itemshow",handler:"updateNav"}],methods:{updateNav:function(){var t=this,e=this.getValidIndex();this.navItems.forEach(function(i){var n=s(i,t.attrItem);a(i,t.clsActive,l(n)===e),a(i,"uk-invisible",t.finite&&("previous"===n&&0===e||"next"===n&&e>=t.maxIndex))})}}})],props:{clsActivated:Boolean,easing:String,index:Number,finite:Boolean,velocity:Number},defaults:{easing:"ease",finite:!1,velocity:1,index:0,stack:[],percent:0,clsActive:"uk-active",clsActivated:!1,Transitioner:!1,transitionOptions:{}},computed:{duration:function(t,e){var i=t.velocity;return Rn(e.offsetWidth/i)},length:function(){return this.slides.length},list:function(t,e){var i=t.selList;return S(i,e)},maxIndex:function(){return this.length-1},slidesSelector:function(t){return t.selList+" > *"},slides:function(){return z(this.list.children)}},update:[{read:function(){this._resetComputeds()},events:["load","resize"]}],methods:{show:function(t,e){var i=this;if(void 0===e&&(e=!1),!this.dragging&&this.length){var n=this.stack,o=e?0:n.length,s=function(){n.splice(o,1),n.length&&i.show(n.shift(),!0)};if(n[e?"unshift":"push"](t),!e&&n.length>1)2===n.length&&this._transitioner.forward(Math.min(this.duration,200));else{var r=this.index,a=B(this.slides,this.clsActive)&&this.slides[r],l=this.getIndex(t,this.index),h=this.slides[l];if(a!==h){var u;if(this.dir="next"===(u=t)?1:"previous"===u?-1:u<r?-1:1,this.prevIndex=r,this.index=l,a&&W(a,"beforeitemhide",[this]),!W(h,"beforeitemshow",[this,a]))return this.index=this.prevIndex,void s();var c=this._show(a,h,e).then(function(){return a&&W(a,"itemhidden",[i]),W(h,"itemshown",[i]),new H(function(t){D.write(function(){n.shift(),n.length?i.show(n.shift(),!0):i._transitioner=null,t()})})});return a&&W(a,"itemhide",[this]),W(h,"itemshow",[this]),c}s()}}},getIndex:function(t,e){return void 0===t&&(t=this.index),void 0===e&&(e=this.index),N(M(t,this.slides,e,this.finite),0,this.maxIndex)},getValidIndex:function(t,e){return void 0===t&&(t=this.index),void 0===e&&(e=this.prevIndex),this.getIndex(t,e)},_show:function(t,e,i){if(this._transitioner=this._getTransitioner(t,e,this.dir,A({easing:i?e.offsetWidth<600?"cubic-bezier(0.25, 0.46, 0.45, 0.94)":"cubic-bezier(0.165, 0.84, 0.44, 1)":this.easing},this.transitionOptions)),!i&&!t)return this._transitioner.translate(1),H.resolve();var n=this.stack.length;return this._transitioner[n>1?"forward":"show"](n>1?Math.min(this.duration,75+75/(n-1)):this.duration,this.percent)},_getDistance:function(t,e){return new this._getTransitioner(t,t!==e&&e).getDistance()},_translate:function(t,e,i){void 0===e&&(e=this.prevIndex),void 0===i&&(i=this.index);var n=this._getTransitioner(e!==i&&e,i);return n.translate(t),n},_getTransitioner:function(t,e,i,n){return void 0===t&&(t=this.prevIndex),void 0===e&&(e=this.index),void 0===i&&(i=this.dir||1),void 0===n&&(n=this.transitionOptions),new this.Transitioner(O(t)?this.slides[t]:t,O(e)?this.slides[e]:e,i*(P?-1:1),n)}}}}}function Rn(t){return.5*t+300}function Yn(t){if(!Yn.installed){t.use(Vn);var e,i,n=t.mixin,o=t.util,s=o.addClass,r=o.assign,a=o.fastdom,l=o.isNumber,h=o.removeClass,u=(e=t.util.css,i={slide:{show:function(t){return[{transform:jn(-100*t)},{transform:jn()}]},percent:function(t){return i.translated(t)},translate:function(t,e){return[{transform:jn(-100*e*t)},{transform:jn(100*e*(1-t))}]}},translated:function(t){return Math.abs(e(t,"transform").split(",")[4]/t.offsetWidth)||0}}),c=function(t){var e=t.util,i=e.createEvent,n=e.clamp,o=e.css,s=e.Deferred,r=e.noop,a=e.Promise,l=e.Transition,h=e.trigger;function u(t,e,n){h(t,i(e,!1,!1,n))}return function(t,e,i,h){var c=h.animation,d=h.easing,f=c.percent,p=c.translate,m=c.show;void 0===m&&(m=r);var g=m(i),v=new s;return{dir:i,show:function(o,s,h){var c=this;void 0===s&&(s=0);var f=h?"linear":d;return o-=Math.round(o*n(s,-1,1)),this.translate(s),u(e,"itemin",{percent:s,duration:o,timing:f,dir:i}),u(t,"itemout",{percent:1-s,duration:o,timing:f,dir:i}),a.all([l.start(e,g[1],o,f),l.start(t,g[0],o,f)]).then(function(){c.reset(),v.resolve()},r),v.promise},stop:function(){return l.stop([e,t])},cancel:function(){l.cancel([e,t])},reset:function(){for(var i in g[0])o([e,t],i,"")},forward:function(i,n){return void 0===n&&(n=this.percent()),l.cancel([e,t]),this.show(i,n,!0)},translate:function(n){var s=p(n,i);o(e,s[1]),o(t,s[0]),u(e,"itemtranslatein",{percent:n,dir:i}),u(t,"itemtranslateout",{percent:1-n,dir:i})},percent:function(){return f(t||e,e,i)},getDistance:function(){return t.offsetWidth}}}}(t);t.mixin.slideshow={mixins:[n.slider],props:{animation:String},defaults:{animation:"slide",clsActivated:"uk-transition-active",Animations:u,Transitioner:c},computed:{animation:function(t){var e=t.animation,i=t.Animations;return r(e in i?i[e]:i.slide,{name:e})},transitionOptions:function(){return{animation:this.animation}}},events:{"itemshow itemhide itemshown itemhidden":function(e){var i=e.target;t.update(null,i)},itemshow:function(){l(this.prevIndex)&&a.flush()},beforeitemshow:function(t){var e=t.target;s(e,this.clsActive)},itemshown:function(t){var e=t.target;s(e,this.clsActivated)},itemhidden:function(t){var e=t.target;h(e,this.clsActive,this.clsActivated)}}}}}function qn(t){if(!qn.installed){t.use(Yn);var e,i,n,o,s,r=t.mixin,a=t.util,l=a.$,h=a.addClass,u=a.ajax,c=a.append,d=a.assign,f=a.attr,p=a.css,m=a.doc,g=a.getImage,v=a.html,w=a.index,b=a.on,y=a.pointerDown,x=a.pointerMove,k=a.removeClass,$=a.Transition,I=a.trigger,T=(i=(e=t).mixin,n=e.util,o=n.assign,s=n.css,o({},i.slideshow.defaults.Animations,{fade:{show:function(){return[{opacity:0},{opacity:1}]},percent:function(t){return 1-s(t,"opacity")},translate:function(t){return[{opacity:1-t},{opacity:t}]}},scale:{show:function(){return[{opacity:0,transform:Fn(.8)},{opacity:1,transform:Fn(1)}]},percent:function(t){return 1-s(t,"opacity")},translate:function(t){return[{opacity:1-t,transform:Fn(1-.2*t)},{opacity:t,transform:Fn(.8+.2*t)}]}}}));t.component("lightbox-panel",{mixins:[r.container,r.modal,r.togglable,r.slideshow],functional:!0,defaults:{preload:1,videoAutoplay:!1,delayControls:3e3,items:[],cls:"uk-open",clsPage:"uk-lightbox-page",selList:".uk-lightbox-items",attrItem:"uk-lightbox-item",selClose:".uk-close-large",pauseOnHover:!1,velocity:2,Animations:T,template:'<div class="uk-lightbox uk-overflow-hidden"> <ul class="uk-lightbox-items"></ul> <div class="uk-lightbox-toolbar uk-position-top uk-text-right uk-transition-slide-top uk-transition-opaque"> <button class="uk-lightbox-toolbar-icon uk-close-large" type="button" uk-close></button> </div> <a class="uk-lightbox-button uk-position-center-left uk-position-medium uk-transition-fade" href="#" uk-slidenav-previous uk-lightbox-item="previous"></a> <a class="uk-lightbox-button uk-position-center-right uk-position-medium uk-transition-fade" href="#" uk-slidenav-next uk-lightbox-item="next"></a> <div class="uk-lightbox-toolbar uk-lightbox-caption uk-position-bottom uk-text-center uk-transition-slide-bottom uk-transition-opaque"></div> </div>'},created:function(){var t=this;this.$mount(c(this.container,this.template)),this.caption=l(".uk-lightbox-caption",this.$el),this.items.forEach(function(){return c(t.list,"<li></li>")})},events:[{name:x+" "+y+" keydown",handler:"showControls"},{name:"click",self:!0,delegate:function(){return this.slidesSelector},handler:function(t){t.preventDefault(),this.hide()}},{name:"shown",self:!0,handler:"showControls"},{name:"hide",self:!0,handler:function(){this.hideControls(),k(this.slides,this.clsActive),$.stop(this.slides),delete this.index,delete this.percent,delete this._transitioner}},{name:"keyup",el:function(){return m},handler:function(t){if(this.isToggled(this.$el))switch(t.keyCode){case 37:this.show("previous");break;case 39:this.show("next")}}},{name:"beforeitemshow",handler:function(t){this.isToggled()||(this.preventCatch=!0,t.preventDefault(),this.animation=T.scale,k(t.target,this.clsActive),this.stack.splice(1,0,this.index),this.toggleNow(this.$el,!0))}},{name:"itemshow",handler:function(t){var e=t.target,i=w(e),n=this.getItem(i).caption;p(this.caption,"display",n?"":"none"),v(this.caption,n);for(var o=0;o<=this.preload;o++)this.loadItem(this.getIndex(i+o)),this.loadItem(this.getIndex(i-o));delete this._computeds.animation}},{name:"itemshown",handler:function(){this.preventCatch=!1}},{name:"itemload",handler:function(t,e){var i,n=this,o=e.source,s=e.type,r=e.alt;if(this.setItem(e,"<span uk-spinner></span>"),o)if("image"===s||o.match(/\.(jp(e)?g|png|gif|svg)$/i))g(o).then(function(t){return n.setItem(e,'<img width="'+t.width+'" height="'+t.height+'" src="'+o+'" alt="'+(r||"")+'">')},function(){return n.setError(e)});else if("video"===s||o.match(/\.(mp4|webm|ogv)$/i)){var a=l("<video controls playsinline"+(e.poster?' poster="'+e.poster+'"':"")+' uk-video="autoplay: '+this.videoAutoplay+'"></video>');f(a,"src",o),b(a,"error",function(){return n.setError(e)}),b(a,"loadedmetadata",function(){f(a,{width:a.videoWidth,height:a.videoHeight}),n.setItem(e,a)})}else if("iframe"===s)this.setItem(e,'<iframe class="uk-lightbox-iframe" src="'+o+'" frameborder="0" allowfullscreen></iframe>');else if(i=o.match(/\/\/.*?youtube(-nocookie)?\.[a-z]+\/watch\?v=([^&\s]+)/)||o.match(/(y)outu\.be\/(.*)/)){var h=i[2],c=function(t,o){return void 0===t&&(t=640),void 0===o&&(o=450),n.setItem(e,C("//www.youtube"+(i[1]||"")+".com/embed/"+h,t,o,n.videoAutoplay))};g("//img.youtube.com/vi/"+h+"/maxresdefault.jpg").then(function(t){var e=t.width,i=t.height;120===e&&90===i?g("//img.youtube.com/vi/"+h+"/0.jpg").then(function(t){var e=t.width,i=t.height;return c(e,i)},c):c(e,i)},c)}else(i=o.match(/(\/\/.*?)vimeo\.[a-z]+\/([0-9]+).*?/))&&u("//vimeo.com/api/oembed.json?maxwidth=1920&url="+encodeURI(o),{responseType:"json"}).then(function(t){var o=t.response,s=o.height,r=o.width;return n.setItem(e,C("//player.vimeo.com/video/"+i[2],r,s,n.videoAutoplay))})}}],methods:{loadItem:function(t){void 0===t&&(t=this.index);var e=this.getItem(t);e.content||I(this.$el,"itemload",[e])},getItem:function(t){return void 0===t&&(t=this.index),this.items[t]||{}},setItem:function(e,i){d(e,{content:i});var n=v(this.slides[this.items.indexOf(e)],i);I(this.$el,"itemloaded",[this,n]),t.update(null,n)},setError:function(t){this.setItem(t,'<span uk-icon="icon: bolt; ratio: 2"></span>')},showControls:function(){clearTimeout(this.controlsTimer),this.controlsTimer=setTimeout(this.hideControls,this.delayControls),h(this.$el,"uk-active","uk-transition-active")},hideControls:function(){k(this.$el,"uk-active","uk-transition-active")}}})}function C(t,e,i,n){return'<iframe src="'+t+'" width="'+e+'" height="'+i+'" style="max-width: 100%; box-sizing: border-box;" frameborder="0" allowfullscreen uk-video="autoplay: '+n+'" uk-responsive></iframe>'}}function Un(t){if(!Un.installed){var e=t.mixin,i=t.util,n=i.css,o=i.Dimensions,s=i.each,r=i.getImage,a=i.includes,l=i.isNumber,h=i.isUndefined,u=i.toFloat,c=i.win,d=["x","y","bgx","bgy","rotate","scale","color","backgroundColor","borderColor","opacity","blur","hue","grayscale","invert","saturate","sepia","fopacity"];e.parallax={props:d.reduce(function(t,e){return t[e]="list",t},{media:"media"}),defaults:d.reduce(function(t,e){return t[e]=void 0,t},{media:!1}),computed:{props:function(t,e){var i=this;return d.reduce(function(o,s){if(h(t[s]))return o;var r,l,c,d=s.match(/color/i),f=d||"opacity"===s,p=t[s].slice(0);f&&n(e,s,""),p.length<2&&p.unshift(("scale"===s?1:f?n(e,s):0)||0);var m=a(p.join(""),"%")?"%":"px";if(d){var g=e.style.color;p=p.map(function(t){return n(n(e,"color",t),"color").split(/[(),]/g).slice(1,-1).concat(1).slice(0,4).map(function(t){return u(t)})}),e.style.color=g}else p=p.map(u);if(s.match(/^bg/))if(n(e,"background-position-"+s[2],""),l=n(e,"backgroundPosition").split(" ")["x"===s[2]?0:1],i.covers){var v=Math.min.apply(Math,p),w=Math.max.apply(Math,p),b=p.indexOf(v)<p.indexOf(w);c=w-v,p=p.map(function(t){return t-(b?v:w)}),r=(b?-c:0)+"px"}else r=l;return o[s]={steps:p,unit:m,pos:r,bgPos:l,diff:c},o},{})},bgProps:function(){var t=this;return["bgx","bgy"].filter(function(e){return e in t.props})},covers:function(t,e){return"cover"===n(""!==e.style.backgroundSize?n(e,"backgroundSize",""):e,"backgroundSize")}},disconnected:function(){delete this._image},update:[{read:function(t){var e=this;if(this._resetComputeds(),t.active=!this.media||c.matchMedia(this.media).matches,t.image&&(t.image.dimEl={width:this.$el.offsetWidth,height:this.$el.offsetHeight}),!("image"in t)&&this.covers&&this.bgProps.length){var i=n(this.$el,"backgroundImage").replace(/^none|url\(["']?(.+?)["']?\)$/,"$1");i&&(t.image=!1,r(i).then(function(i){t.image={width:i.naturalWidth,height:i.naturalHeight},e.$emit()}))}},write:function(t){var e=this,i=t.image,s=t.active;if(i)if(s){var r=i.dimEl,a=o.cover(i,r);this.bgProps.forEach(function(t){var n=e.props[t],s=n.diff,l=n.bgPos,h=n.steps,u="bgy"===t?"height":"width",c=a[u]-r[u];l.match(/%$|0px/)&&(c<s?r[u]=a[u]+s-c:c>s&&(l=parseFloat(l))&&(e.props[t].steps=h.map(function(t){return t-(c-s)/(100/l)})),a=o.cover(i,r))}),n(this.$el,{backgroundSize:a.width+"px "+a.height+"px",backgroundRepeat:"no-repeat"})}else n(this.$el,{backgroundSize:"",backgroundRepeat:""})},events:["load","resize"]}],methods:{reset:function(){var t=this;s(this.getCss(0),function(e,i){return n(t.$el,i,"")})},getCss:function(t){var e=!1,i=this.props;return Object.keys(i).reduce(function(n,o){var s=i[o],r=s.steps,a=s.unit,l=s.pos,h=p(r,t);switch(o){case"x":case"y":if(e)break;var c=["x","y"].map(function(e){return o===e?h+a:i[e]?p(i[e].steps,t)+i[e].unit:0}),d=c[0],m=c[1];e=n.transform+=" translate3d("+d+", "+m+", 0)";break;case"rotate":n.transform+=" rotate("+h+"deg)";break;case"scale":n.transform+=" scale("+h+")";break;case"bgy":case"bgx":n["background-position-"+o[2]]="calc("+l+" + "+(h+a)+")";break;case"color":case"backgroundColor":case"borderColor":var g=f(r,t),v=g[0],w=g[1],b=g[2];n[o]="rgba("+v.map(function(t,e){return t+=b*(w[e]-t),3===e?u(t):parseInt(t,10)}).join(",")+")";break;case"blur":n.filter+=" blur("+h+"px)";break;case"hue":n.filter+=" hue-rotate("+h+"deg)";break;case"fopacity":n.filter+=" opacity("+h+"%)";break;case"grayscale":case"invert":case"saturate":case"sepia":n.filter+=" "+o+"("+h+"%)";break;default:n[o]=h}return n},{transform:"",filter:""})}}}}function f(t,e){var i=t.length-1,n=Math.min(Math.floor(i*e),i-1),o=t.slice(n,n+2);return o.push(1===e?1:e%(1/i)*i),o}function p(t,e){var i=f(t,e),n=i[0],o=i[1],s=i[2];return(l(n)?n+Math.abs(n-o)*s*(n<o?1:-1):+o).toFixed(2)}}function Xn(t){var e=t.util,i=e.fastdom,n=e.removeClass;return{ready:function(){var t=this;i.write(function(){return t.show(t.getValidIndex())})},update:[{read:function(){this._resetComputeds()},write:function(){if(!this.stack.length&&!this.dragging){var t=this.getValidIndex();delete this.index,n(this.slides,this.clsActive,this.clsActivated),this.show(t)}},events:["load","resize"]}]}}function Jn(t,e){t.use(Un);var i=t.mixin,n=t.util,o=n.closest,s=n.css,r=n.endsWith,a=n.noop,l=n.Transition;return{mixins:[i.parallax],computed:{item:function(){var i=t.getComponent(o(this.$el,".uk-"+e),e);return i&&o(this.$el,i.slidesSelector)}},events:[{name:"itemshown",self:!0,el:function(){return this.item},handler:function(){s(this.$el,this.getCss(.5))}},{name:"itemin itemout",self:!0,el:function(){return this.item},handler:function(t){var e=t.type,i=t.detail,n=i.percent,o=i.duration,r=i.timing,c=i.dir;l.cancel(this.$el),s(this.$el,this.getCss(u(e,c,n))),l.start(this.$el,this.getCss(h(e)?.5:c>0?1:0),o,r).catch(a)}},{name:"transitioncanceled transitionend",self:!0,el:function(){return this.item},handler:function(){l.cancel(this.$el)}},{name:"itemtranslatein itemtranslateout",self:!0,el:function(){return this.item},handler:function(t){var e=t.type,i=t.detail,n=i.percent,o=i.dir;l.cancel(this.$el),s(this.$el,this.getCss(u(e,o,n)))}}]};function h(t){return r(t,"in")}function u(t,e,i){return i/=2,h(t)?e<0?1-i:i:e<0?i:1-i}}return zi.version="3.0.0-beta.39",(Mn=zi).mixin.class=ji,Mn.mixin.container=Fi,Mn.mixin.modal=Ri,Mn.mixin.position=Yi,Mn.mixin.togglable=Vi,(Bn=zi).use(Wn),Bn.use(qi),Bn.use(Ui),Bn.use(Ln),Bn.use(Ji),Bn.use(Gi),Bn.use(Zi),Bn.use(Qi),Bn.use(en),Bn.use(nn),Bn.use($n),Bn.use(Ki),Bn.use(tn),Bn.use(kn),Bn.use(In),Bn.use(Tn),Bn.use(Cn),Bn.use(En),Bn.use(_n),Bn.use(Sn),Bn.use(An),Bn.use(Nn),Bn.use(Dn),Bn.use(Pn),Bn.use(xn),Bn.use(Hn),Bn.use(zn),Bn.use(Xi),zi.use(function t(e){if(!t.installed){var i=e.util,n=i.$,o=i.doc,s=i.empty,r=i.html;e.component("countdown",{mixins:[e.mixin.class],attrs:!0,props:{date:String,clsWrapper:String},defaults:{date:"",clsWrapper:".uk-countdown-%unit%"},computed:{date:function(t){var e=t.date;return Date.parse(e)},days:function(t,e){var i=t.clsWrapper;return n(i.replace("%unit%","days"),e)},hours:function(t,e){var i=t.clsWrapper;return n(i.replace("%unit%","hours"),e)},minutes:function(t,e){var i=t.clsWrapper;return n(i.replace("%unit%","minutes"),e)},seconds:function(t,e){var i=t.clsWrapper;return n(i.replace("%unit%","seconds"),e)},units:function(){var t=this;return["days","hours","minutes","seconds"].filter(function(e){return t[e]})}},connected:function(){this.start()},disconnected:function(){var t=this;this.stop(),this.units.forEach(function(e){return s(t[e])})},events:[{name:"visibilitychange",el:o,handler:function(){o.hidden?this.stop():this.start()}}],update:{write:function(){var t,e,i=this,n=(t=this.date,{total:e=t-Date.now(),seconds:e/1e3%60,minutes:e/1e3/60%60,hours:e/1e3/60/60%24,days:e/1e3/60/60/24});n.total<=0&&(this.stop(),n.days=n.hours=n.minutes=n.seconds=0),this.units.forEach(function(t){var e=String(Math.floor(n[t]));e=e.length<2?"0"+e:e;var o=i[t];o.textContent!==e&&((e=e.split("")).length!==o.children.length&&r(o,e.map(function(){return"<span></span>"}).join("")),e.forEach(function(t,e){return o.children[e].textContent=t}))})}},methods:{start:function(){var t=this;this.stop(),this.date&&this.units.length&&(this.$emit(),this.timer=setInterval(function(){return t.$emit()},1e3))},stop:function(){this.timer&&(clearInterval(this.timer),this.timer=null)}}})}}),zi.use(function t(e){if(!t.installed){var i=e.util,n=i.addClass,o=i.css,s=i.scrolledOver,r=i.sortBy,a=i.toFloat;e.component("grid-parallax",e.components.grid.extend({props:{target:String,translate:Number},defaults:{target:!1,translate:150},computed:{translate:function(t){var e=t.translate;return Math.abs(e)}},init:function(){n(this.$el,"uk-grid")},disconnected:function(){this.reset(),o(this.$el,"marginBottom","")},update:[{read:function(t){var e=t.rows;return{columns:e&&e[0]&&e[0].length||0,rows:e&&e.map(function(t){return r(t,"offsetLeft")})}},write:function(t){var e=t.columns;o(this.$el,"marginBottom",e>1?this.translate+a(o(o(this.$el,"marginBottom",""),"marginBottom")):"")},events:["load","resize"]},{read:function(){return{scrolled:s(this.$el)*this.translate}},write:function(t){var e=t.rows,i=t.columns,n=t.scrolled;if(!e||1===i||!n)return this.reset();e.forEach(function(t){return t.forEach(function(t,e){return o(t,"transform","translateY("+(e%2?n:n/8)+"px)")})})},events:["scroll","load","resize"]}],methods:{reset:function(){o(this.$el.children,"transform","")}}})),e.components.gridParallax.options.update.unshift({read:function(){this.reset()},events:["load","resize"]})}}),zi.use(function t(e){if(!t.installed){e.use(qn);var i=e.util,n=i.$$,o=i.assign,s=i.data,r=i.index,a=e.components.lightboxPanel.options;e.component("lightbox",{attrs:!0,props:o({toggle:String},a.props),defaults:o({toggle:"a"},Object.keys(a.props).reduce(function(t,e){return t[e]=a.defaults[e],t},{})),computed:{toggles:function(t,e){var i=t.toggle;return n(i,e)}},disconnected:function(){this._destroy()},events:[{name:"click",delegate:function(){return this.toggle+":not(.uk-disabled)"},handler:function(t){t.preventDefault(),t.current.blur(),this.show(r(this.toggles,t.current))}}],update:function(t){var e,i;this.panel&&this.animation&&(this.panel.$props.animation=this.animation,this.panel.$emit()),!this.panel||t.toggles&&(e=t.toggles,i=this.toggles,e.length===i.length&&e.every(function(t,e){return t!==i[e]}))||(t.toggles=this.toggles,this._destroy(),this._init())},methods:{_init:function(){return this.panel=this.panel||e.lightboxPanel(o({},this.$props,{items:this.toggles.reduce(function(t,e){return t.push(["href","caption","type","poster","alt"].reduce(function(t,i){return t["href"===i?"source":i]=s(e,i),t},{})),t},[])}))},_destroy:function(){this.panel&&(this.panel.$destroy(!0),this.panel=null)},show:function(t){return this.panel||this._init(),this.panel.show(t)},hide:function(){return this.panel&&this.panel.hide()}}})}}),zi.use(function t(e){var i;if(!t.installed){var n=e.util,o=n.append,s=n.closest,r=n.css,a=n.each,l=n.pointerEnter,h=n.pointerLeave,u=n.remove,c=n.toFloat,d=n.Transition,f=n.trigger,p={};e.component("notification",{functional:!0,args:["message","status"],defaults:{message:"",status:"",timeout:5e3,group:null,pos:"top-center",clsClose:"uk-notification-close",clsMsg:"uk-notification-message"},created:function(){p[this.pos]||(p[this.pos]=o(e.container,'<div class="uk-notification uk-notification-'+this.pos+'"></div>'));var t=r(p[this.pos],"display","block");this.$mount(o(t,'<div class="'+this.clsMsg+(this.status?" "+this.clsMsg+"-"+this.status:"")+'"> <a href="#" class="'+this.clsClose+'" data-uk-close></a> <div>'+this.message+"</div> </div>"))},ready:function(){var t=this,e=c(r(this.$el,"marginBottom"));d.start(r(this.$el,{opacity:0,marginTop:-this.$el.offsetHeight,marginBottom:0}),{opacity:1,marginTop:0,marginBottom:e}).then(function(){t.timeout&&(t.timer=setTimeout(t.close,t.timeout))})},events:(i={click:function(t){s(t.target,'a[href="#"]')&&t.preventDefault(),this.close()}},i[l]=function(){this.timer&&clearTimeout(this.timer)},i[h]=function(){this.timeout&&(this.timer=setTimeout(this.close,this.timeout))},i),methods:{close:function(t){var e=this,i=function(){f(e.$el,"close",[e]),u(e.$el),p[e.pos].children.length||r(p[e.pos],"display","none")};this.timer&&clearTimeout(this.timer),t?i():d.start(this.$el,{opacity:0,marginTop:-this.$el.offsetHeight,marginBottom:0}).then(i)}}}),e.notification.closeAll=function(t,i){a(e.instances,function(e){"notification"!==e.$options.name||t&&t!==e.group||e.close(i)})}}}),zi.use(function t(e){if(!t.installed){e.use(Un);var i=e.mixin,n=e.util,o=n.clamp,s=n.css,r=n.scrolledOver,a=n.query;e.component("parallax",{mixins:[i.parallax],props:{target:String,viewport:Number,easing:Number},defaults:{target:!1,viewport:1,easing:1},computed:{target:function(t,e){var i=t.target;return i&&a(i,e)||e}},update:[{read:function(t){var e,i;return{prev:t.percent,percent:(e=r(this.target)/(this.viewport||1),i=this.easing,o(e*(1-(i-i*e))))}},write:function(t,e){var i=t.prev,n=t.percent,o=t.active;"scroll"!==e.type&&(i=!1),o?i!==n&&s(this.$el,this.getCss(n)):this.reset()},events:["scroll","load","resize"]}]})}}),zi.use(function t(e){if(!t.installed){e.use(Vn);var i=e.mixin,n=e.util,o=n.$,s=n.$$,r=n.addClass,a=n.css,l=n.data,h=n.includes,u=n.isNumeric,c=n.isUndefined,d=n.toggleClass,f=n.toFloat,p=function(t){var e=t.util,i=e.assign,n=e.clamp,o=e.createEvent,s=e.css,r=e.Deferred,a=e.includes,l=e.index,h=e.isRtl,u=e.noop,c=e.sortBy,d=e.toNodes,f=e.Transition,p=e.trigger,m=i(function(t,e,i,o){var d=o.center,p=o.easing,w=o.list,b=new r,y=t?m.getLeft(t,w,d):m.getLeft(e,w,d)+e.offsetWidth*i,x=e?m.getLeft(e,w,d):y+t.offsetWidth*i*(h?-1:1);return{dir:i,show:function(e,o,s){void 0===o&&(o=0);var r=s?"linear":p;return e-=Math.round(e*n(o,-1,1)),this.translate(o),t&&this.updateTranslates(),o=t?o:n(o,0,1),g(this.getItemIn(),"itemin",{percent:o,duration:e,timing:r,dir:i}),t&&g(this.getItemIn(!0),"itemout",{percent:1-o,duration:e,timing:r,dir:i}),f.start(w,{transform:jn(-x*(h?-1:1),"px")},e,r).then(b.resolve,u),b.promise},stop:function(){return f.stop(w)},cancel:function(){f.cancel(w)},reset:function(){s(w,"transform","")},forward:function(t,e){return void 0===e&&(e=this.percent()),f.cancel(w),this.show(t,e,!0)},translate:function(e){var o=this.getDistance()*i*(h?-1:1);s(w,"transform",jn(n(o-o*e-x,-m.getWidth(w),w.offsetWidth)*(h?-1:1),"px")),this.updateTranslates(),t&&(e=n(e,-1,1),g(this.getItemIn(),"itemtranslatein",{percent:e,dir:i}),g(this.getItemIn(!0),"itemtranslateout",{percent:1-e,dir:i}))},percent:function(){return Math.abs((s(w,"transform").split(",")[4]*(h?-1:1)+y)/(x-y))},getDistance:function(){return Math.abs(x-y)},getItemIn:function(e){void 0===e&&(e=!1);var n=this.getActives(),o=c(v(w),"offsetLeft"),s=l(o,n[i*(e?-1:1)>0?n.length-1:0]);return~s&&o[s+(t&&!e?i:0)]},getActives:function(){var i=m.getLeft(t||e,w,d);return c(v(w).filter(function(t){var e=m.getElLeft(t,w);return e>=i&&e+t.offsetWidth<=w.offsetWidth+i}),"offsetLeft")},updateTranslates:function(){var t=this.getActives();v(w).forEach(function(i){var n=a(t,i);g(i,"itemtranslate"+(n?"in":"out"),{percent:n?1:0,dir:i.offsetLeft<=e.offsetLeft?1:-1})})}}},{getLeft:function(t,e,i){var n=this.getElLeft(t,e);return i?n-this.center(t,e):Math.min(n,this.getMax(e))},getMax:function(t){return Math.max(0,this.getWidth(t)-t.offsetWidth)},getWidth:function(t){return v(t).reduce(function(t,e){return e.offsetWidth+t},0)},getMaxWidth:function(t){return v(t).reduce(function(t,e){return Math.max(t,e.offsetWidth)},0)},center:function(t,e){return e.offsetWidth/2-t.offsetWidth/2},getElLeft:function(t,e){return(t.offsetLeft+(h?t.offsetWidth-e.offsetWidth:0))*(h?-1:1)}});function g(t,e,i){p(t,o(e,!1,!1,i))}function v(t){return d(t.children)}return m}(e);e.component("slider-parallax",Jn(e,"slider")),e.component("slider",{mixins:[i.class,i.slider,Xn(e)],props:{center:Boolean,sets:Boolean},defaults:{center:!1,sets:!1,attrItem:"uk-slider-item",selList:".uk-slider-items",selNav:".uk-slider-nav",clsContainer:"uk-slider-container",Transitioner:p},computed:{avgWidth:function(){return p.getWidth(this.list)/this.length},finite:function(t){var e=t.finite;return e||p.getWidth(this.list)<this.list.offsetWidth+p.getMaxWidth(this.list)+this.center},maxIndex:function(){if(!this.finite||this.center&&!this.sets)return this.length-1;if(this.center)return this.sets[this.sets.length-1];a(this.slides,"order","");for(var t=p.getMax(this.list),e=this.length;e--;)if(p.getElLeft(this.list.children[e],this.list)<t)return Math.min(e+1,this.length-1);return 0},sets:function(t){var e=this,i=t.sets,n=this.list.offsetWidth/(this.center?2:1),o=0,s=n;return a(this.slides,"order",""),i=i&&this.slides.reduce(function(t,i,r){var a=i.offsetWidth,l=p.getElLeft(i,e.list);if(l+a>o&&(!e.center&&r>e.maxIndex&&(r=e.maxIndex),!h(t,r))){var u=e.slides[r+1];e.center&&u&&a<s-u.offsetWidth/2?s-=a:(s=n,t.push(r),o=l+n+(e.center?a/2:0))}return t},[]),i&&i.length&&i},transitionOptions:function(){return{center:this.center,list:this.list}}},connected:function(){d(this.$el,this.clsContainer,!o("."+this.clsContainer,this.$el))},update:{write:function(){var t=this;s("["+this.attrItem+"],[data-"+this.attrItem+"]",this.$el).forEach(function(e){var i=l(e,t.attrItem);t.maxIndex&&d(e,"uk-hidden",u(i)&&(t.sets&&!h(t.sets,f(i))||i>t.maxIndex))})},events:["load","resize"]},events:{beforeitemshow:function(t){!this.dragging&&this.sets&&this.stack.length<2&&!h(this.sets,this.index)&&(this.index=this.getValidIndex());var e=Math.abs(this.index-this.prevIndex+(this.dir>0&&this.index<this.prevIndex||this.dir<0&&this.index>this.prevIndex?(this.maxIndex+1)*this.dir:0));if(!this.dragging&&e>1){for(var i=0;i<e;i++)this.stack.splice(1,0,this.dir>0?"next":"previous");t.preventDefault()}else this.duration=Rn(this.avgWidth/this.velocity)*((this.dir<0||!this.slides[this.prevIndex]?this.slides[this.index]:this.slides[this.prevIndex]).offsetWidth/this.avgWidth),this.reorder()},itemshow:function(){!c(this.prevIndex)&&r(this._getTransitioner().getItemIn(),this.clsActive)},itemshown:function(){var t=this,e=this._getTransitioner(this.index).getActives();this.slides.forEach(function(i){return d(i,t.clsActive,h(e,i))}),(!this.sets||h(this.sets,f(this.index)))&&this.slides.forEach(function(i){return d(i,t.clsActivated,h(e,i))})}},methods:{reorder:function(){var t=this;if(a(this.slides,"order",""),!this.finite&&(this.slides.forEach(function(e,i){return a(e,"order",t.dir>0&&i<t.prevIndex?1:t.dir<0&&i>=t.index?-1:"")}),this.center))for(var e=this.dir>0&&this.slides[this.prevIndex]?this.prevIndex:this.index,i=this.slides[e],n=this.list.offsetWidth/2-i.offsetWidth/2,o=0;n>0;){var s=t.getIndex(--o+e,e),r=t.slides[s];a(r,"order",s>e?-2:-1),n-=r.offsetWidth}},getValidIndex:function(t,e){var i;if(void 0===t&&(t=this.index),void 0===e&&(e=this.prevIndex),t=this.getIndex(t,e),!this.sets)return t;do{if(h(this.sets,t))return t;i=t,t=this.getIndex(t+this.dir,e)}while(t!==i);return t}}})}}),zi.use(function t(e){if(!t.installed){e.use(Yn);var i,n,o,s,r,a,l=e.mixin,h=e.util.height,u=(n=(i=e).mixin,o=i.util,s=o.assign,r=o.css,a=s({},n.slideshow.defaults.Animations,{fade:{show:function(){return[{opacity:0,zIndex:0},{zIndex:-1}]},percent:function(t){return 1-r(t,"opacity")},translate:function(t){return[{opacity:1-t,zIndex:0},{zIndex:-1}]}},scale:{show:function(){return[{opacity:0,transform:Fn(1.5),zIndex:0},{zIndex:-1}]},percent:function(t){return 1-r(t,"opacity")},translate:function(t){return[{opacity:1-t,transform:Fn(1+.5*t),zIndex:0},{zIndex:-1}]}},pull:{show:function(t){return t<0?[{transform:jn(30),zIndex:-1},{transform:jn(),zIndex:0}]:[{transform:jn(-100),zIndex:0},{transform:jn(),zIndex:-1}]},percent:function(t,e,i){return i<0?1-a.translated(e):a.translated(t)},translate:function(t,e){return e<0?[{transform:jn(30*t),zIndex:-1},{transform:jn(-100*(1-t)),zIndex:0}]:[{transform:jn(100*-t),zIndex:0},{transform:jn(30*(1-t)),zIndex:-1}]}},push:{show:function(t){return t<0?[{transform:jn(100),zIndex:0},{transform:jn(),zIndex:-1}]:[{transform:jn(-30),zIndex:-1},{transform:jn(),zIndex:0}]},percent:function(t,e,i){return i>0?1-a.translated(e):a.translated(t)},translate:function(t,e){return e<0?[{transform:jn(100*t),zIndex:0},{transform:jn(-30*(1-t)),zIndex:-1}]:[{transform:jn(-30*t),zIndex:-1},{transform:jn(100*(1-t)),zIndex:0}]}}}));e.component("slideshow-parallax",Jn(e,"slideshow")),e.component("slideshow",{mixins:[l.class,l.slideshow,Xn(e)],props:{ratio:String,minHeight:Boolean,maxHeight:Boolean},defaults:{ratio:"16:9",minHeight:!1,maxHeight:!1,selList:".uk-slideshow-items",attrItem:"uk-slideshow-item",selNav:".uk-slideshow-nav",Animations:u},update:{read:function(){var t=this.ratio.split(":").map(Number),e=t[0],i=t[1];return i=i*this.$el.offsetWidth/e,this.minHeight&&(i=Math.max(this.minHeight,i)),this.maxHeight&&(i=Math.min(this.maxHeight,i)),{height:i}},write:function(t){var e=t.height;h(this.list,Math.floor(e))},events:["load","resize"]}})}}),zi.use(function t(e){var i;if(!t.installed){var n=e.mixin,o=e.util,s=o.addClass,r=o.after,a=o.assign,l=o.append,h=o.attr,u=o.before,c=o.closest,d=o.css,f=o.doc,p=o.docEl,m=o.height,g=o.fastdom,v=o.getPos,w=o.includes,b=o.index,y=o.isInput,x=o.noop,k=o.offset,$=o.off,I=o.on,T=o.pointerDown,C=o.pointerMove,E=o.pointerUp,_=o.position,S=o.preventClick,A=o.Promise,N=o.remove,D=o.removeClass,M=o.toggleClass,B=o.toNodes,O=o.Transition,P=o.trigger,H=o.win,z=o.within;e.component("sortable",{mixins:[n.class],props:{group:String,animation:Number,threshold:Number,clsItem:String,clsPlaceholder:String,clsDrag:String,clsDragState:String,clsBase:String,clsNoDrag:String,clsEmpty:String,clsCustom:String,handle:String},defaults:{group:!1,animation:150,threshold:5,clsItem:"uk-sortable-item",clsPlaceholder:"uk-sortable-placeholder",clsDrag:"uk-sortable-drag",clsDragState:"uk-drag",clsBase:"uk-sortable",clsNoDrag:"uk-sortable-nodrag",clsEmpty:"uk-sortable-empty",clsCustom:"",handle:!1},init:function(){var t=this;["init","start","move","end"].forEach(function(e){var i=t[e];t[e]=function(e){t.scrollY=H.pageYOffset;var n=v(e),o=n.x,s=n.y;t.pos={x:o,y:s},i(e)}})},events:(i={},i[T]="init",i),update:{write:function(){if(this.clsEmpty&&M(this.$el,this.clsEmpty,!this.$el.children.length),this.drag){k(this.drag,{top:this.pos.y+this.origin.top,left:this.pos.x+this.origin.left});var t,e=k(this.drag).top,i=e+this.drag.offsetHeight;e>0&&e<this.scrollY?t=this.scrollY-5:i<m(f)&&i>m(H)+this.scrollY&&(t=this.scrollY+5),t&&setTimeout(function(){return H.scrollTo(H.scrollX,t)},5)}}},methods:{init:function(t){var e=t.target,i=t.button,n=t.defaultPrevented,o=B(this.$el.children).filter(function(t){return z(e,t)})[0];!o||y(t.target)||this.handle&&!z(e,this.handle)||i>0||z(e,"."+this.clsNoDrag)||n||(t.preventDefault(),this.touched=[this],this.placeholder=o,this.origin=a({target:e,index:b(o)},this.pos),I(p,C,this.move),I(p,E,this.end),I(H,"scroll",this.scroll),this.threshold||this.start(t))},start:function(t){this.drag=l(e.container,this.placeholder.outerHTML.replace(/^<li/i,"<div").replace(/li>$/i,"div>")),d(this.drag,a({boxSizing:"border-box",width:this.placeholder.offsetWidth,height:this.placeholder.offsetHeight},d(this.placeholder,["paddingLeft","paddingRight","paddingTop","paddingBottom"]))),h(this.drag,"uk-no-boot",""),s(this.drag,this.clsDrag,this.clsCustom),m(this.drag.firstElementChild,m(this.placeholder.firstElementChild));var i=k(this.placeholder),n=i.left,o=i.top;a(this.origin,{left:n-this.pos.x,top:o-this.pos.y}),s(this.placeholder,this.clsPlaceholder),s(this.$el.children,this.clsItem),s(p,this.clsDragState),P(this.$el,"start",[this,this.placeholder,this.drag]),this.move(t)},move:function(t){if(this.drag){this.$emit();var e="mousemove"===t.type?t.target:f.elementFromPoint(this.pos.x-f.body.scrollLeft,this.pos.y-f.body.scrollTop),i=W(e),n=W(this.placeholder),o=i!==n;if(i&&!z(e,this.placeholder)&&(!o||i.group&&i.group===n.group)){if(e=i.$el===e.parentNode&&e||B(i.$el.children).filter(function(t){return z(e,t)})[0],o)n.remove(this.placeholder);else if(!e)return;i.insert(this.placeholder,e),w(this.touched,i)||this.touched.push(i)}}else(Math.abs(this.pos.x-this.origin.x)>this.threshold||Math.abs(this.pos.y-this.origin.y)>this.threshold)&&this.start(t)},scroll:function(){var t=H.pageYOffset;t!==this.scrollY&&(this.pos.y+=t-this.scrollY,this.scrollY=t,this.$emit())},end:function(t){if($(p,C,this.move),$(p,E,this.end),$(H,"scroll",this.scroll),this.drag){S();var e=W(this.placeholder);this===e?this.origin.index!==b(this.placeholder)&&P(this.$el,"moved",[this,this.placeholder]):(P(e.$el,"added",[e,this.placeholder]),P(this.$el,"removed",[this,this.placeholder])),P(this.$el,"stop",[this]),N(this.drag),this.drag=null;var i=this.touched.map(function(t){return t.clsPlaceholder+" "+t.clsItem}).join(" ");this.touched.forEach(function(t){return D(t.$el.children,i)}),D(p,this.clsDragState)}else"mouseup"!==t.type&&z(t.target,"a[href]")&&(location.href=c(t.target,"a[href]").href)},insert:function(t,e){var i=this;s(this.$el.children,this.clsItem);var n=function(){var n,o;e?!z(t,i.$el)||(o=e,(n=t).parentNode===o.parentNode&&b(n)>b(o))?u(e,t):r(e,t):l(i.$el,t)};this.animation?this.animate(n):n()},remove:function(t){z(t,this.$el)&&(this.animation?this.animate(function(){return N(t)}):N(t))},animate:function(t){var e=this,i=[],n=B(this.$el.children),o={position:"",width:"",height:"",pointerEvents:"",top:"",left:"",bottom:"",right:""};n.forEach(function(t){i.push(a({position:"absolute",pointerEvents:"none",width:t.offsetWidth,height:t.offsetHeight},_(t)))}),t(),n.forEach(O.cancel),d(this.$el.children,o),this.$update("update",!0),g.flush(),d(this.$el,"minHeight",m(this.$el));var s=n.map(function(t){return _(t)});A.all(n.map(function(t,n){return O.start(d(t,i[n]),s[n],e.animation)})).then(function(){d(e.$el,"minHeight",""),d(n,o),e.$update("update",!0),g.flush()},x)}}})}function W(t){return t&&(e.getComponent(t,"sortable")||W(t.parentNode))}}),zi.use(function t(e){var i;if(!t.installed){var n=e.util,o=e.mixin,s=n.append,r=n.attr,a=n.doc,l=n.flipPosition,h=n.hasAttr,u=n.includes,c=n.isTouch,d=n.isVisible,f=n.matches,p=n.on,m=n.pointerDown,g=n.pointerEnter,v=n.pointerLeave,w=n.remove,b=n.within,y=[];e.component("tooltip",{attrs:!0,args:"title",mixins:[o.container,o.togglable,o.position],props:{delay:Number,title:String},defaults:{pos:"top",title:"",delay:0,animation:["uk-animation-scale-up"],duration:100,cls:"uk-active",clsPos:"uk-tooltip"},beforeConnect:function(){this._hasTitle=h(this.$el,"title"),r(this.$el,{title:"","aria-expanded":!1})},disconnected:function(){this.hide(),r(this.$el,{title:this._hasTitle?this.title:null,"aria-expanded":null})},methods:{show:function(){var t=this;u(y,this)||(y.forEach(function(t){return t.hide()}),y.push(this),this._unbind=p(a,"click",function(e){return!b(e.target,t.$el)&&t.hide()}),clearTimeout(this.showTimer),this.tooltip=s(this.container,'<div class="'+this.clsPos+'" aria-hidden><div class="'+this.clsPos+'-inner">'+this.title+"</div></div>"),r(this.$el,"aria-expanded",!0),this.positionAt(this.tooltip,this.$el),this.origin="y"===this.getAxis()?l(this.dir)+"-"+this.align:this.align+"-"+l(this.dir),this.showTimer=setTimeout(function(){t.toggleElement(t.tooltip,!0),t.hideTimer=setInterval(function(){d(t.$el)||t.hide()},150)},this.delay))},hide:function(){var t=y.indexOf(this);!~t||f(this.$el,"input")&&this.$el===a.activeElement||(y.splice(t,1),clearTimeout(this.showTimer),clearInterval(this.hideTimer),r(this.$el,"aria-expanded",!1),this.toggleElement(this.tooltip,!1),this.tooltip&&w(this.tooltip),this.tooltip=!1,this._unbind())}},events:(i={},i["focus "+g+" "+m]=function(t){t.type===m&&c(t)||this.show()},i.blur="hide",i[v]=function(t){c(t)||this.hide()},i)})}}),zi.use(function t(e){if(!t.installed){var i=e.util,n=i.addClass,o=i.ajax,s=i.matches,r=i.noop,a=i.on,l=i.removeClass,h=i.trigger;e.component("upload",{props:{allow:String,clsDragover:String,concurrent:Number,maxSize:Number,mime:String,msgInvalidMime:String,msgInvalidName:String,msgInvalidSize:String,multiple:Boolean,name:String,params:Object,type:String,url:String},defaults:{allow:!1,clsDragover:"uk-dragover",concurrent:1,maxSize:0,mime:!1,msgInvalidMime:"Invalid File Type: %s",msgInvalidName:"Invalid File Name: %s",msgInvalidSize:"Invalid File Size: %s Bytes Max",multiple:!1,name:"files[]",params:{},type:"POST",url:"",abort:r,beforeAll:r,beforeSend:r,complete:r,completeAll:r,error:r,fail:r,load:r,loadEnd:r,loadStart:r,progress:r},events:{change:function(t){s(t.target,'input[type="file"]')&&(t.preventDefault(),t.target.files&&this.upload(t.target.files),t.target.value="")},drop:function(t){c(t);var e=t.dataTransfer;e&&e.files&&(l(this.$el,this.clsDragover),this.upload(e.files))},dragenter:function(t){c(t)},dragover:function(t){c(t),n(this.$el,this.clsDragover)},dragleave:function(t){c(t),l(this.$el,this.clsDragover)}},methods:{upload:function(t){var e=this;if(t.length){h(this.$el,"upload",[t]);for(var i=0;i<t.length;i++){if(e.maxSize&&1e3*e.maxSize<t[i].size)return void e.fail(e.msgInvalidSize.replace("%s",e.allow));if(e.allow&&!u(e.allow,t[i].name))return void e.fail(e.msgInvalidName.replace("%s",e.allow));if(e.mime&&!u(e.mime,t[i].type))return void e.fail(e.msgInvalidMime.replace("%s",e.mime))}this.multiple||(t=[t[0]]),this.beforeAll(this,t);var n=function(t,e){for(var i=[],n=0;n<t.length;n+=e){for(var o=[],s=0;s<e;s++)o.push(t[n+s]);i.push(o)}return i}(t,this.concurrent),s=function(t){var i=new FormData;for(var r in t.forEach(function(t){return i.append(e.name,t)}),e.params)i.append(r,e.params[r]);o(e.url,{data:i,method:e.type,beforeSend:function(t){var i=t.xhr;i.upload&&a(i.upload,"progress",e.progress),["loadStart","load","loadEnd","abort"].forEach(function(t){return a(i,t.toLowerCase(),e[t])}),e.beforeSend(t)}}).then(function(t){e.complete(t),n.length?s(n.shift()):e.completeAll(t)},function(t){return e.error(t.message)})};s(n.shift())}}}})}function u(t,e){return e.match(new RegExp("^"+t.replace(/\//g,"\\/").replace(/\*\*/g,"(\\/[^\\/]+)*").replace(/\*/g,"[^\\/]+").replace(/((?!\\))\?/g,"$1.")+"$","i"))}function c(t){t.preventDefault(),t.stopPropagation()}}),function(t){var e=t.connect,i=t.disconnect;function n(){l(s.body,e),hi.flush(),new a(function(t){return t.forEach(o)}).observe(r,{childList:!0,subtree:!0,characterData:!0,attributes:!0}),t._initialized=!0}function o(n){var o=n.target;("attributes"!==n.type?function(t){var n,o=t.addedNodes,s=t.removedNodes;for(n=0;n<o.length;n++)l(o[n],e);for(n=0;n<s.length;n++)l(s[n],i);return!0}(n):function(e){var i=e.target,n=e.attributeName;if("href"===n)return!0;var o=Di(n);if(o&&o in t.components){if(y(i,n))return t[o](i),!0;var s=t.getComponent(i,o);return s?(s.$destroy(),!0):void 0}}(n))&&t.update(ce("update",!0,!1,{mutation:!0}),o,!0)}function l(t,e){if(1===t.nodeType&&!y(t,"uk-no-boot"))for(e(t),t=t.firstElementChild;t;){var i=t.nextElementSibling;l(t,e),t=i}}a&&(s.body?n():new a(function(){s.body&&(this.disconnect(),n())}).observe(r,{childList:!0,subtree:!0}))}(zi),zi});/*! UIkit 3.0.0-beta.39 | http://www.getuikit.com | (c) 2014 - 2017 YOOtheme | MIT License */

!function(t,i){"object"==typeof exports&&"undefined"!=typeof module?module.exports=i():"function"==typeof define&&define.amd?define("uikiticons",i):t.UIkitIcons=i()}(this,function(){"use strict";var t={album:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect x="5" y="2" width="10" height="1" /> <rect x="3" y="4" width="14" height="1" /> <rect fill="none" stroke="#000" x="1.5" y="6.5" width="17" height="11" /></svg>',ban:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#000" stroke-width="1.1" cx="10" cy="10" r="9" /> <line fill="none" stroke="#000" stroke-width="1.1" x1="4" y1="3.5" x2="16" y2="16.5" /></svg>',behance:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M9.5,10.6c-0.4-0.5-0.9-0.9-1.6-1.1c1.7-1,2.2-3.2,0.7-4.7C7.8,4,6.3,4,5.2,4C3.5,4,1.7,4,0,4v12c1.7,0,3.4,0,5.2,0 c1,0,2.1,0,3.1-0.5C10.2,14.6,10.5,12.3,9.5,10.6L9.5,10.6z M5.6,6.1c1.8,0,1.8,2.7-0.1,2.7c-1,0-2,0-2.9,0V6.1H5.6z M2.6,13.8v-3.1 c1.1,0,2.1,0,3.2,0c2.1,0,2.1,3.2,0.1,3.2L2.6,13.8z" /> <path d="M19.9,10.9C19.7,9.2,18.7,7.6,17,7c-4.2-1.3-7.3,3.4-5.3,7.1c0.9,1.7,2.8,2.3,4.7,2.1c1.7-0.2,2.9-1.3,3.4-2.9h-2.2 c-0.4,1.3-2.4,1.5-3.5,0.6c-0.4-0.4-0.6-1.1-0.6-1.7H20C20,11.7,19.9,10.9,19.9,10.9z M13.5,10.6c0-1.6,2.3-2.7,3.5-1.4 c0.4,0.4,0.5,0.9,0.6,1.4H13.5L13.5,10.6z" /> <rect x="13" y="4" width="5" height="1.4" /></svg>',bell:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" stroke-width="1.1" d="M17,15.5 L3,15.5 C2.99,14.61 3.79,13.34 4.1,12.51 C4.58,11.3 4.72,10.35 5.19,7.01 C5.54,4.53 5.89,3.2 7.28,2.16 C8.13,1.56 9.37,1.5 9.81,1.5 L9.96,1.5 C9.96,1.5 11.62,1.41 12.67,2.17 C14.08,3.2 14.42,4.54 14.77,7.02 C15.26,10.35 15.4,11.31 15.87,12.52 C16.2,13.34 17.01,14.61 17,15.5 L17,15.5 Z" /> <path fill="none" stroke="#000" d="M12.39,16 C12.39,17.37 11.35,18.43 9.91,18.43 C8.48,18.43 7.42,17.37 7.42,16" /></svg>',bold:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M5,15.3 C5.66,15.3 5.9,15 5.9,14.53 L5.9,5.5 C5.9,4.92 5.56,4.7 5,4.7 L5,4 L8.95,4 C12.6,4 13.7,5.37 13.7,6.9 C13.7,7.87 13.14,9.17 10.86,9.59 L10.86,9.7 C13.25,9.86 14.29,11.28 14.3,12.54 C14.3,14.47 12.94,16 9,16 L5,16 L5,15.3 Z M9,9.3 C11.19,9.3 11.8,8.5 11.85,7 C11.85,5.65 11.3,4.8 9,4.8 L7.67,4.8 L7.67,9.3 L9,9.3 Z M9.185,15.22 C11.97,15 12.39,14 12.4,12.58 C12.4,11.15 11.39,10 9,10 L7.67,10 L7.67,15 L9.18,15 Z" /></svg>',bolt:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M4.74,20 L7.73,12 L3,12 L15.43,1 L12.32,9 L17.02,9 L4.74,20 L4.74,20 L4.74,20 Z M9.18,11 L7.1,16.39 L14.47,10 L10.86,10 L12.99,4.67 L5.61,11 L9.18,11 L9.18,11 L9.18,11 Z" /></svg>',bookmark:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon fill="none" stroke="#000" points="5.5 1.5 15.5 1.5 15.5 17.5 10.5 12.5 5.5 17.5" /></svg>',calendar:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M 2,3 2,17 18,17 18,3 2,3 Z M 17,16 3,16 3,8 17,8 17,16 Z M 17,7 3,7 3,4 17,4 17,7 Z" /> <rect width="1" height="3" x="6" y="2" /> <rect width="1" height="3" x="13" y="2" /></svg>',camera:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#000" stroke-width="1.1" cx="10" cy="10.8" r="3.8" /> <path fill="none" stroke="#000" d="M1,4.5 C0.7,4.5 0.5,4.7 0.5,5 L0.5,17 C0.5,17.3 0.7,17.5 1,17.5 L19,17.5 C19.3,17.5 19.5,17.3 19.5,17 L19.5,5 C19.5,4.7 19.3,4.5 19,4.5 L13.5,4.5 L13.5,2.9 C13.5,2.6 13.3,2.5 13,2.5 L7,2.5 C6.7,2.5 6.5,2.6 6.5,2.9 L6.5,4.5 L1,4.5 L1,4.5 Z" /></svg>',cart:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle cx="7.3" cy="17.3" r="1.4" /> <circle cx="13.3" cy="17.3" r="1.4" /> <polyline fill="none" stroke="#000" points="0 2 3.2 4 5.3 12.5 16 12.5 18 6.5 8 6.5" /></svg>',check:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polyline fill="none" stroke="#000" stroke-width="1.1" points="4,10 8,15 17,4" /></svg>',clock:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#000" stroke-width="1.1" cx="10" cy="10" r="9" /> <rect x="9" y="4" width="1" height="7" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M13.018,14.197 L9.445,10.625" /></svg>',close:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" stroke-width="1.06" d="M16,16 L4,4" /> <path fill="none" stroke="#000" stroke-width="1.06" d="M16,4 L4,16" /></svg>',code:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polyline fill="none" stroke="#000" stroke-width="1.01" points="13,4 19,10 13,16" /> <polyline fill="none" stroke="#000" stroke-width="1.01" points="7,4 1,10 7,16" /></svg>',cog:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#000" cx="9.997" cy="10" r="3.31" /> <path fill="none" stroke="#000" d="M18.488,12.285 L16.205,16.237 C15.322,15.496 14.185,15.281 13.303,15.791 C12.428,16.289 12.047,17.373 12.246,18.5 L7.735,18.5 C7.938,17.374 7.553,16.299 6.684,15.791 C5.801,15.27 4.655,15.492 3.773,16.237 L1.5,12.285 C2.573,11.871 3.317,10.999 3.317,9.991 C3.305,8.98 2.573,8.121 1.5,7.716 L3.765,3.784 C4.645,4.516 5.794,4.738 6.687,4.232 C7.555,3.722 7.939,2.637 7.735,1.5 L12.263,1.5 C12.072,2.637 12.441,3.71 13.314,4.22 C14.206,4.73 15.343,4.516 16.225,3.794 L18.487,7.714 C17.404,8.117 16.661,8.988 16.67,10.009 C16.672,11.018 17.415,11.88 18.488,12.285 L18.488,12.285 Z" /></svg>',comment:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M6,18.71 L6,14 L1,14 L1,1 L19,1 L19,14 L10.71,14 L6,18.71 L6,18.71 Z M2,13 L7,13 L7,16.29 L10.29,13 L18,13 L18,2 L2,2 L2,13 L2,13 Z" /></svg>',commenting:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon fill="none" stroke="#000" points="1.5,1.5 18.5,1.5 18.5,13.5 10.5,13.5 6.5,17.5 6.5,13.5 1.5,13.5" /> <circle cx="10" cy="8" r="1" /> <circle cx="6" cy="8" r="1" /> <circle cx="14" cy="8" r="1" /></svg>',comments:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polyline fill="none" stroke="#000" points="2 0.5 19.5 0.5 19.5 13" /> <path d="M5,19.71 L5,15 L0,15 L0,2 L18,2 L18,15 L9.71,15 L5,19.71 L5,19.71 L5,19.71 Z M1,14 L6,14 L6,17.29 L9.29,14 L17,14 L17,3 L1,3 L1,14 L1,14 L1,14 Z" /></svg>',copy:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect fill="none" stroke="#000" x="3.5" y="2.5" width="12" height="16" /> <polyline fill="none" stroke="#000" points="5 0.5 17.5 0.5 17.5 17" /></svg>',database:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <ellipse fill="none" stroke="#000" cx="10" cy="4.64" rx="7.5" ry="3.14" /> <path fill="none" stroke="#000" d="M17.5,8.11 C17.5,9.85 14.14,11.25 10,11.25 C5.86,11.25 2.5,9.84 2.5,8.11" /> <path fill="none" stroke="#000" d="M17.5,11.25 C17.5,12.99 14.14,14.39 10,14.39 C5.86,14.39 2.5,12.98 2.5,11.25" /> <path fill="none" stroke="#000" d="M17.49,4.64 L17.5,14.36 C17.5,16.1 14.14,17.5 10,17.5 C5.86,17.5 2.5,16.09 2.5,14.36 L2.5,4.64" /></svg>',desktop:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect x="8" y="15" width="1" height="2" /> <rect x="11" y="15" width="1" height="2" /> <rect x="5" y="16" width="10" height="1" /> <rect fill="none" stroke="#000" x="1.5" y="3.5" width="17" height="11" /></svg>',download:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polyline fill="none" stroke="#000" points="14,10 9.5,14.5 5,10" /> <rect x="3" y="17" width="13" height="1" /> <line fill="none" stroke="#000" x1="9.5" y1="13.91" x2="9.5" y2="3" /></svg>',dribbble:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" stroke-width="1.4" d="M1.3,8.9c0,0,5,0.1,8.6-1c1.4-0.4,2.6-0.9,4-1.9 c1.4-1.1,2.5-2.5,2.5-2.5" /> <path fill="none" stroke="#000" stroke-width="1.4" d="M3.9,16.6c0,0,1.7-2.8,3.5-4.2 c1.8-1.3,4-2,5.7-2.2C16,10,19,10.6,19,10.6" /> <path fill="none" stroke="#000" stroke-width="1.4" d="M6.9,1.6c0,0,3.3,4.6,4.2,6.8 c0.4,0.9,1.3,3.1,1.9,5.2c0.6,2,0.9,4.4,0.9,4.4" /> <circle fill="none" stroke="#000" stroke-width="1.4" cx="10" cy="10" r="9" /></svg>',expand:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="13 2 18 2 18 7 17 7 17 3 13 3" /> <polygon points="2 13 3 13 3 17 7 17 7 18 2 18" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M11,9 L17,3" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M3,17 L9,11" /></svg>',facebook:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M11,10h2.6l0.4-3H11V5.3c0-0.9,0.2-1.5,1.5-1.5H14V1.1c-0.3,0-1-0.1-2.1-0.1C9.6,1,8,2.4,8,5v2H5.5v3H8v8h3V10z" /></svg>',file:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect fill="none" stroke="#000" x="3.5" y="1.5" width="13" height="17" /></svg>',flickr:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle cx="5.5" cy="9.5" r="3.5" /> <circle cx="14.5" cy="9.5" r="3.5" /></svg>',folder:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon fill="none" stroke="#000" points="9.5 5.5 8.5 3.5 1.5 3.5 1.5 16.5 18.5 16.5 18.5 5.5" /></svg>',forward:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M2.47,13.11 C4.02,10.02 6.27,7.85 9.04,6.61 C9.48,6.41 10.27,6.13 11,5.91 L11,2 L18.89,9 L11,16 L11,12.13 C9.25,12.47 7.58,13.19 6.02,14.25 C3.03,16.28 1.63,18.54 1.63,18.54 C1.63,18.54 1.38,15.28 2.47,13.11 L2.47,13.11 Z M5.3,13.53 C6.92,12.4 9.04,11.4 12,10.92 L12,13.63 L17.36,9 L12,4.25 L12,6.8 C11.71,6.86 10.86,7.02 9.67,7.49 C6.79,8.65 4.58,10.96 3.49,13.08 C3.18,13.7 2.68,14.87 2.49,16 C3.28,15.05 4.4,14.15 5.3,13.53 L5.3,13.53 Z" /></svg>',foursquare:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M15.23,2 C15.96,2 16.4,2.41 16.5,2.86 C16.57,3.15 16.56,3.44 16.51,3.73 C16.46,4.04 14.86,11.72 14.75,12.03 C14.56,12.56 14.16,12.82 13.61,12.83 C13.03,12.84 11.09,12.51 10.69,13 C10.38,13.38 7.79,16.39 6.81,17.53 C6.61,17.76 6.4,17.96 6.08,17.99 C5.68,18.04 5.29,17.87 5.17,17.45 C5.12,17.28 5.1,17.09 5.1,16.91 C5.1,12.4 4.86,7.81 5.11,3.31 C5.17,2.5 5.81,2.12 6.53,2 L15.23,2 L15.23,2 Z M9.76,11.42 C9.94,11.19 10.17,11.1 10.45,11.1 L12.86,11.1 C13.12,11.1 13.31,10.94 13.36,10.69 C13.37,10.64 13.62,9.41 13.74,8.83 C13.81,8.52 13.53,8.28 13.27,8.28 C12.35,8.29 11.42,8.28 10.5,8.28 C9.84,8.28 9.83,7.69 9.82,7.21 C9.8,6.85 10.13,6.55 10.5,6.55 C11.59,6.56 12.67,6.55 13.76,6.55 C14.03,6.55 14.23,6.4 14.28,6.14 C14.34,5.87 14.67,4.29 14.67,4.29 C14.67,4.29 14.82,3.74 14.19,3.74 L7.34,3.74 C7,3.75 6.84,4.02 6.84,4.33 C6.84,7.58 6.85,14.95 6.85,14.99 C6.87,15 8.89,12.51 9.76,11.42 L9.76,11.42 Z" /></svg>',future:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polyline points="19 2 18 2 18 6 14 6 14 7 19 7 19 2" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M18,6.548 C16.709,3.29 13.354,1 9.6,1 C4.6,1 0.6,5 0.6,10 C0.6,15 4.6,19 9.6,19 C14.6,19 18.6,15 18.6,10" /> <rect x="9" y="4" width="1" height="7" /> <path d="M13.018,14.197 L9.445,10.625" fill="none" stroke="#000" stroke-width="1.1" /></svg>',github:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M10,1 C5.03,1 1,5.03 1,10 C1,13.98 3.58,17.35 7.16,18.54 C7.61,18.62 7.77,18.34 7.77,18.11 C7.77,17.9 7.76,17.33 7.76,16.58 C5.26,17.12 4.73,15.37 4.73,15.37 C4.32,14.33 3.73,14.05 3.73,14.05 C2.91,13.5 3.79,13.5 3.79,13.5 C4.69,13.56 5.17,14.43 5.17,14.43 C5.97,15.8 7.28,15.41 7.79,15.18 C7.87,14.6 8.1,14.2 8.36,13.98 C6.36,13.75 4.26,12.98 4.26,9.53 C4.26,8.55 4.61,7.74 5.19,7.11 C5.1,6.88 4.79,5.97 5.28,4.73 C5.28,4.73 6.04,4.49 7.75,5.65 C8.47,5.45 9.24,5.35 10,5.35 C10.76,5.35 11.53,5.45 12.25,5.65 C13.97,4.48 14.72,4.73 14.72,4.73 C15.21,5.97 14.9,6.88 14.81,7.11 C15.39,7.74 15.73,8.54 15.73,9.53 C15.73,12.99 13.63,13.75 11.62,13.97 C11.94,14.25 12.23,14.8 12.23,15.64 C12.23,16.84 12.22,17.81 12.22,18.11 C12.22,18.35 12.38,18.63 12.84,18.54 C16.42,17.35 19,13.98 19,10 C19,5.03 14.97,1 10,1 L10,1 Z" /></svg>',gitter:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect x="3.5" y="1" width="1.531" height="11.471" /> <rect x="7.324" y="4.059" width="1.529" height="15.294" /> <rect x="11.148" y="4.059" width="1.527" height="15.294" /> <rect x="14.971" y="4.059" width="1.529" height="8.412" /></svg>',google:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M17.86,9.09 C18.46,12.12 17.14,16.05 13.81,17.56 C9.45,19.53 4.13,17.68 2.47,12.87 C0.68,7.68 4.22,2.42 9.5,2.03 C11.57,1.88 13.42,2.37 15.05,3.65 C15.22,3.78 15.37,3.93 15.61,4.14 C14.9,4.81 14.23,5.45 13.5,6.14 C12.27,5.08 10.84,4.72 9.28,4.98 C8.12,5.17 7.16,5.76 6.37,6.63 C4.88,8.27 4.62,10.86 5.76,12.82 C6.95,14.87 9.17,15.8 11.57,15.25 C13.27,14.87 14.76,13.33 14.89,11.75 L10.51,11.75 L10.51,9.09 L17.86,9.09 L17.86,9.09 Z" /></svg>',grid:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect x="2" y="2" width="3" height="3" /> <rect x="8" y="2" width="3" height="3" /> <rect x="14" y="2" width="3" height="3" /> <rect x="2" y="8" width="3" height="3" /> <rect x="8" y="8" width="3" height="3" /> <rect x="14" y="8" width="3" height="3" /> <rect x="2" y="14" width="3" height="3" /> <rect x="8" y="14" width="3" height="3" /> <rect x="14" y="14" width="3" height="3" /></svg>',happy:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle cx="13" cy="7" r="1" /> <circle cx="7" cy="7" r="1" /> <circle fill="none" stroke="#000" cx="10" cy="10" r="8.5" /> <path fill="none" stroke="#000" d="M14.6,11.4 C13.9,13.3 12.1,14.5 10,14.5 C7.9,14.5 6.1,13.3 5.4,11.4" /></svg>',hashtag:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M15.431,8 L15.661,7 L12.911,7 L13.831,3 L12.901,3 L11.98,7 L9.29,7 L10.21,3 L9.281,3 L8.361,7 L5.23,7 L5,8 L8.13,8 L7.21,12 L4.23,12 L4,13 L6.98,13 L6.061,17 L6.991,17 L7.911,13 L10.601,13 L9.681,17 L10.611,17 L11.531,13 L14.431,13 L14.661,12 L11.76,12 L12.681,8 L15.431,8 Z M10.831,12 L8.141,12 L9.061,8 L11.75,8 L10.831,12 Z" /></svg>',heart:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" stroke-width="1.03" d="M10,4 C10,4 8.1,2 5.74,2 C3.38,2 1,3.55 1,6.73 C1,8.84 2.67,10.44 2.67,10.44 L10,18 L17.33,10.44 C17.33,10.44 19,8.84 19,6.73 C19,3.55 16.62,2 14.26,2 C11.9,2 10,4 10,4 L10,4 Z" /></svg>',history:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polyline fill="#000" points="1 2 2 2 2 6 6 6 6 7 1 7 1 2" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M2.1,6.548 C3.391,3.29 6.746,1 10.5,1 C15.5,1 19.5,5 19.5,10 C19.5,15 15.5,19 10.5,19 C5.5,19 1.5,15 1.5,10" /> <rect x="9" y="4" width="1" height="7" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M13.018,14.197 L9.445,10.625" id="Shape" /></svg>',home:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="18.65 11.35 10 2.71 1.35 11.35 0.65 10.65 10 1.29 19.35 10.65" /> <polygon points="15 4 18 4 18 7 17 7 17 5 15 5" /> <polygon points="3 11 4 11 4 18 7 18 7 12 12 12 12 18 16 18 16 11 17 11 17 19 11 19 11 13 8 13 8 19 3 19" /></svg>',image:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle cx="16.1" cy="6.1" r="1.1" /> <rect fill="none" stroke="#000" x="0.5" y="2.5" width="19" height="15" /> <polyline fill="none" stroke="#000" stroke-width="1.01" points="4,13 8,9 13,14" /> <polyline fill="none" stroke="#000" stroke-width="1.01" points="11,12 12.5,10.5 16,14" /></svg>',info:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M12.13,11.59 C11.97,12.84 10.35,14.12 9.1,14.16 C6.17,14.2 9.89,9.46 8.74,8.37 C9.3,8.16 10.62,7.83 10.62,8.81 C10.62,9.63 10.12,10.55 9.88,11.32 C8.66,15.16 12.13,11.15 12.14,11.18 C12.16,11.21 12.16,11.35 12.13,11.59 C12.08,11.95 12.16,11.35 12.13,11.59 L12.13,11.59 Z M11.56,5.67 C11.56,6.67 9.36,7.15 9.36,6.03 C9.36,5 11.56,4.54 11.56,5.67 L11.56,5.67 Z" /> <circle fill="none" stroke="#000" stroke-width="1.1" cx="10" cy="10" r="9" /></svg>',instagram:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M13.55,1H6.46C3.45,1,1,3.44,1,6.44v7.12c0,3,2.45,5.44,5.46,5.44h7.08c3.02,0,5.46-2.44,5.46-5.44V6.44 C19.01,3.44,16.56,1,13.55,1z M17.5,14c0,1.93-1.57,3.5-3.5,3.5H6c-1.93,0-3.5-1.57-3.5-3.5V6c0-1.93,1.57-3.5,3.5-3.5h8 c1.93,0,3.5,1.57,3.5,3.5V14z" /> <circle cx="14.87" cy="5.26" r="1.09" /> <path d="M10.03,5.45c-2.55,0-4.63,2.06-4.63,4.6c0,2.55,2.07,4.61,4.63,4.61c2.56,0,4.63-2.061,4.63-4.61 C14.65,7.51,12.58,5.45,10.03,5.45L10.03,5.45L10.03,5.45z M10.08,13c-1.66,0-3-1.34-3-2.99c0-1.65,1.34-2.99,3-2.99s3,1.34,3,2.99 C13.08,11.66,11.74,13,10.08,13L10.08,13L10.08,13z" /></svg>',italic:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M12.63,5.48 L10.15,14.52 C10,15.08 10.37,15.25 11.92,15.3 L11.72,16 L6,16 L6.2,15.31 C7.78,15.26 8.19,15.09 8.34,14.53 L10.82,5.49 C10.97,4.92 10.63,4.76 9.09,4.71 L9.28,4 L15,4 L14.81,4.69 C13.23,4.75 12.78,4.91 12.63,5.48 L12.63,5.48 Z" /></svg>',joomla:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M7.8,13.4l1.7-1.7L5.9,8c-0.6-0.5-0.6-1.5,0-2c0.6-0.6,1.4-0.6,2,0l1.7-1.7c-1-1-2.3-1.3-3.6-1C5.8,2.2,4.8,1.4,3.7,1.4 c-1.3,0-2.3,1-2.3,2.3c0,1.1,0.8,2,1.8,2.3c-0.4,1.3-0.1,2.8,1,3.8L7.8,13.4L7.8,13.4z" /> <path d="M10.2,4.3c1-1,2.5-1.4,3.8-1c0.2-1.1,1.1-2,2.3-2c1.3,0,2.3,1,2.3,2.3c0,1.2-0.9,2.2-2,2.3c0.4,1.3,0,2.8-1,3.8L13.9,8 c0.6-0.5,0.6-1.5,0-2c-0.5-0.6-1.5-0.6-2,0L8.2,9.7L6.5,8" /> <path d="M14.1,16.8c-1.3,0.4-2.8,0.1-3.8-1l1.7-1.7c0.6,0.6,1.5,0.6,2,0c0.5-0.6,0.6-1.5,0-2l-3.7-3.7L12,6.7l3.7,3.7 c1,1,1.3,2.4,1,3.6c1.1,0.2,2,1.1,2,2.3c0,1.3-1,2.3-2.3,2.3C15.2,18.6,14.3,17.8,14.1,16.8" /> <path d="M13.2,12.2l-3.7,3.7c-1,1-2.4,1.3-3.6,1c-0.2,1-1.2,1.8-2.2,1.8c-1.3,0-2.3-1-2.3-2.3c0-1.1,0.8-2,1.8-2.3 c-0.3-1.3,0-2.7,1-3.7l1.7,1.7c-0.6,0.6-0.6,1.5,0,2c0.6,0.6,1.4,0.6,2,0l3.7-3.7" /></svg>',laptop:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect y="16" width="20" height="1" /> <rect fill="none" stroke="#000" x="2.5" y="4.5" width="15" height="10" /></svg>',lifesaver:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M10,0.5 C4.76,0.5 0.5,4.76 0.5,10 C0.5,15.24 4.76,19.5 10,19.5 C15.24,19.5 19.5,15.24 19.5,10 C19.5,4.76 15.24,0.5 10,0.5 L10,0.5 Z M10,1.5 C11.49,1.5 12.89,1.88 14.11,2.56 L11.85,4.82 C11.27,4.61 10.65,4.5 10,4.5 C9.21,4.5 8.47,4.67 7.79,4.96 L5.58,2.75 C6.87,1.95 8.38,1.5 10,1.5 L10,1.5 Z M4.96,7.8 C4.67,8.48 4.5,9.21 4.5,10 C4.5,10.65 4.61,11.27 4.83,11.85 L2.56,14.11 C1.88,12.89 1.5,11.49 1.5,10 C1.5,8.38 1.95,6.87 2.75,5.58 L4.96,7.79 L4.96,7.8 L4.96,7.8 Z M10,18.5 C8.25,18.5 6.62,17.97 5.27,17.06 L7.46,14.87 C8.22,15.27 9.08,15.5 10,15.5 C10.79,15.5 11.53,15.33 12.21,15.04 L14.42,17.25 C13.13,18.05 11.62,18.5 10,18.5 L10,18.5 Z M10,14.5 C7.52,14.5 5.5,12.48 5.5,10 C5.5,7.52 7.52,5.5 10,5.5 C12.48,5.5 14.5,7.52 14.5,10 C14.5,12.48 12.48,14.5 10,14.5 L10,14.5 Z M15.04,12.21 C15.33,11.53 15.5,10.79 15.5,10 C15.5,9.08 15.27,8.22 14.87,7.46 L17.06,5.27 C17.97,6.62 18.5,8.25 18.5,10 C18.5,11.62 18.05,13.13 17.25,14.42 L15.04,12.21 L15.04,12.21 Z" /></svg>',link:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" stroke-width="1.1" d="M10.625,12.375 L7.525,15.475 C6.825,16.175 5.925,16.175 5.225,15.475 L4.525,14.775 C3.825,14.074 3.825,13.175 4.525,12.475 L7.625,9.375" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M9.325,7.375 L12.425,4.275 C13.125,3.575 14.025,3.575 14.724,4.275 L15.425,4.975 C16.125,5.675 16.125,6.575 15.425,7.275 L12.325,10.375" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M7.925,11.875 L11.925,7.975" /></svg>',linkedin:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M5.77,17.89 L5.77,7.17 L2.21,7.17 L2.21,17.89 L5.77,17.89 L5.77,17.89 Z M3.99,5.71 C5.23,5.71 6.01,4.89 6.01,3.86 C5.99,2.8 5.24,2 4.02,2 C2.8,2 2,2.8 2,3.85 C2,4.88 2.77,5.7 3.97,5.7 L3.99,5.7 L3.99,5.71 L3.99,5.71 Z" /> <path d="M7.75,17.89 L11.31,17.89 L11.31,11.9 C11.31,11.58 11.33,11.26 11.43,11.03 C11.69,10.39 12.27,9.73 13.26,9.73 C14.55,9.73 15.06,10.71 15.06,12.15 L15.06,17.89 L18.62,17.89 L18.62,11.74 C18.62,8.45 16.86,6.92 14.52,6.92 C12.6,6.92 11.75,7.99 11.28,8.73 L11.3,8.73 L11.3,7.17 L7.75,7.17 C7.79,8.17 7.75,17.89 7.75,17.89 L7.75,17.89 L7.75,17.89 Z" /></svg>',list:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect x="6" y="4" width="12" height="1" /> <rect x="6" y="9" width="12" height="1" /> <rect x="6" y="14" width="12" height="1" /> <rect x="2" y="4" width="2" height="1" /> <rect x="2" y="9" width="2" height="1" /> <rect x="2" y="14" width="2" height="1" /></svg>',location:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" stroke-width="1.01" d="M10,0.5 C6.41,0.5 3.5,3.39 3.5,6.98 C3.5,11.83 10,19 10,19 C10,19 16.5,11.83 16.5,6.98 C16.5,3.39 13.59,0.5 10,0.5 L10,0.5 Z" /> <circle fill="none" stroke="#000" cx="10" cy="6.8" r="2.3" /></svg>',lock:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect fill="none" stroke="#000" height="10" width="13" y="8.5" x="3.5" /> <path fill="none" stroke="#000" d="M6.5,8 L6.5,4.88 C6.5,3.01 8.07,1.5 10,1.5 C11.93,1.5 13.5,3.01 13.5,4.88 L13.5,8" /></svg>',mail:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polyline fill="none" stroke="#000" points="1.4,6.5 10,11 18.6,6.5" /> <path d="M 1,4 1,16 19,16 19,4 1,4 Z M 18,15 2,15 2,5 18,5 18,15 Z" /></svg>',menu:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect x="2" y="4" width="16" height="1" /> <rect x="2" y="9" width="16" height="1" /> <rect x="2" y="14" width="16" height="1" /></svg>',minus:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect height="1" width="18" y="9" x="1" /></svg>',more:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle cx="3" cy="10" r="2" /> <circle cx="10" cy="10" r="2" /> <circle cx="17" cy="10" r="2" /></svg>',move:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="4,5 1,5 1,9 2,9 2,6 4,6 " /> <polygon points="1,16 2,16 2,18 4,18 4,19 1,19 " /> <polygon points="14,16 14,19 11,19 11,18 13,18 13,16 " /> <rect fill="none" stroke="#000" x="5.5" y="1.5" width="13" height="13" /> <rect x="1" y="11" width="1" height="3" /> <rect x="6" y="18" width="3" height="1" /></svg>',nut:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon fill="none" stroke="#000" points="2.5,5.7 10,1.3 17.5,5.7 17.5,14.3 10,18.7 2.5,14.3" /> <circle fill="none" stroke="#000" cx="10" cy="10" r="3.5" /></svg>',pagekit:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="3,1 17,1 17,16 10,16 10,13 14,13 14,4 6,4 6,16 10,16 10,19 3,19 " /></svg>',pencil:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" d="M17.25,6.01 L7.12,16.1 L3.82,17.2 L5.02,13.9 L15.12,3.88 C15.71,3.29 16.66,3.29 17.25,3.88 C17.83,4.47 17.83,5.42 17.25,6.01 L17.25,6.01 Z" /> <path fill="none" stroke="#000" d="M15.98,7.268 L13.851,5.148" /></svg>',phone:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" d="M15.5,17 C15.5,17.8 14.8,18.5 14,18.5 L7,18.5 C6.2,18.5 5.5,17.8 5.5,17 L5.5,3 C5.5,2.2 6.2,1.5 7,1.5 L14,1.5 C14.8,1.5 15.5,2.2 15.5,3 L15.5,17 L15.5,17 L15.5,17 Z" /> <circle cx="10.5" cy="16.5" r="0.8" /></svg>',pinterest:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M10.21,1 C5.5,1 3,4.16 3,7.61 C3,9.21 3.85,11.2 5.22,11.84 C5.43,11.94 5.54,11.89 5.58,11.69 C5.62,11.54 5.8,10.8 5.88,10.45 C5.91,10.34 5.89,10.24 5.8,10.14 C5.36,9.59 5,8.58 5,7.65 C5,5.24 6.82,2.91 9.93,2.91 C12.61,2.91 14.49,4.74 14.49,7.35 C14.49,10.3 13,12.35 11.06,12.35 C9.99,12.35 9.19,11.47 9.44,10.38 C9.75,9.08 10.35,7.68 10.35,6.75 C10.35,5.91 9.9,5.21 8.97,5.21 C7.87,5.21 6.99,6.34 6.99,7.86 C6.99,8.83 7.32,9.48 7.32,9.48 C7.32,9.48 6.24,14.06 6.04,14.91 C5.7,16.35 6.08,18.7 6.12,18.9 C6.14,19.01 6.26,19.05 6.33,18.95 C6.44,18.81 7.74,16.85 8.11,15.44 C8.24,14.93 8.79,12.84 8.79,12.84 C9.15,13.52 10.19,14.09 11.29,14.09 C14.58,14.09 16.96,11.06 16.96,7.3 C16.94,3.7 14,1 10.21,1" /></svg>',play:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon fill="none" stroke="#000" points="6.5,5 14.5,10 6.5,15" /></svg>',plus:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect x="9" y="1" width="1" height="17" /> <rect x="1" y="9" width="17" height="1" /></svg>',pull:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="6.85,8 9.5,10.6 12.15,8 12.85,8.7 9.5,12 6.15,8.7" /> <line fill="none" stroke="#000" x1="9.5" y1="11" x2="9.5" y2="2" /> <polyline fill="none" stroke="#000" points="6,5.5 3.5,5.5 3.5,18.5 15.5,18.5 15.5,5.5 13,5.5" /></svg>',push:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="12.15,4 9.5,1.4 6.85,4 6.15,3.3 9.5,0 12.85,3.3" /> <line fill="none" stroke="#000" x1="9.5" y1="10" x2="9.5" y2="1" /> <polyline fill="none" stroke="#000" points="6 5.5 3.5 5.5 3.5 18.5 15.5 18.5 15.5 5.5 13 5.5" /></svg>',question:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#000" stroke-width="1.1" cx="10" cy="10" r="9" /> <circle cx="10.44" cy="14.42" r="1.05" /> <path fill="none" stroke="#000" stroke-width="1.2" d="M8.17,7.79 C8.17,4.75 12.72,4.73 12.72,7.72 C12.72,8.67 11.81,9.15 11.23,9.75 C10.75,10.24 10.51,10.73 10.45,11.4 C10.44,11.53 10.43,11.64 10.43,11.75" /></svg>',receiver:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" stroke-width="1.01" d="M6.189,13.611C8.134,15.525 11.097,18.239 13.867,18.257C16.47,18.275 18.2,16.241 18.2,16.241L14.509,12.551L11.539,13.639L6.189,8.29L7.313,5.355L3.76,1.8C3.76,1.8 1.732,3.537 1.7,6.092C1.667,8.809 4.347,11.738 6.189,13.611" /></svg>',refresh:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" stroke-width="1.1" d="M17.08,11.15 C17.09,11.31 17.1,11.47 17.1,11.64 C17.1,15.53 13.94,18.69 10.05,18.69 C6.16,18.68 3,15.53 3,11.63 C3,7.74 6.16,4.58 10.05,4.58 C10.9,4.58 11.71,4.73 12.46,5" /> <polyline fill="none" stroke="#000" points="9.9 2 12.79 4.89 9.79 7.9" /></svg>',reply:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M17.7,13.11 C16.12,10.02 13.84,7.85 11.02,6.61 C10.57,6.41 9.75,6.13 9,5.91 L9,2 L1,9 L9,16 L9,12.13 C10.78,12.47 12.5,13.19 14.09,14.25 C17.13,16.28 18.56,18.54 18.56,18.54 C18.56,18.54 18.81,15.28 17.7,13.11 L17.7,13.11 Z M14.82,13.53 C13.17,12.4 11.01,11.4 8,10.92 L8,13.63 L2.55,9 L8,4.25 L8,6.8 C8.3,6.86 9.16,7.02 10.37,7.49 C13.3,8.65 15.54,10.96 16.65,13.08 C16.97,13.7 17.48,14.86 17.68,16 C16.87,15.05 15.73,14.15 14.82,13.53 L14.82,13.53 Z" /></svg>',rss:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle cx="3.12" cy="16.8" r="1.85" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M1.5,8.2 C1.78,8.18 2.06,8.16 2.35,8.16 C7.57,8.16 11.81,12.37 11.81,17.57 C11.81,17.89 11.79,18.19 11.76,18.5" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M1.5,2.52 C1.78,2.51 2.06,2.5 2.35,2.5 C10.72,2.5 17.5,9.24 17.5,17.57 C17.5,17.89 17.49,18.19 17.47,18.5" /></svg>',search:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#000" stroke-width="1.1" cx="9" cy="9" r="7" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M14,14 L18,18 L14,14 Z" /></svg>',server:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect x="3" y="3" width="1" height="2" /> <rect x="5" y="3" width="1" height="2" /> <rect x="7" y="3" width="1" height="2" /> <rect x="16" y="3" width="1" height="1" /> <rect x="16" y="10" width="1" height="1" /> <circle fill="none" stroke="#000" cx="9.9" cy="17.4" r="1.4" /> <rect x="3" y="10" width="1" height="2" /> <rect x="5" y="10" width="1" height="2" /> <rect x="9.5" y="14" width="1" height="2" /> <rect x="3" y="17" width="6" height="1" /> <rect x="11" y="17" width="6" height="1" /> <rect fill="none" stroke="#000" x="1.5" y="1.5" width="17" height="5" /> <rect fill="none" stroke="#000" x="1.5" y="8.5" width="17" height="5" /></svg>',settings:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <ellipse fill="none" stroke="#000" cx="6.11" cy="3.55" rx="2.11" ry="2.15" /> <ellipse fill="none" stroke="#000" cx="6.11" cy="15.55" rx="2.11" ry="2.15" /> <circle fill="none" stroke="#000" cx="13.15" cy="9.55" r="2.15" /> <rect x="1" y="3" width="3" height="1" /> <rect x="10" y="3" width="8" height="1" /> <rect x="1" y="9" width="8" height="1" /> <rect x="15" y="9" width="3" height="1" /> <rect x="1" y="15" width="3" height="1" /> <rect x="10" y="15" width="8" height="1" /></svg>',shrink:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="11 4 12 4 12 8 16 8 16 9 11 9" /> <polygon points="4 11 9 11 9 16 8 16 8 12 4 12" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M12,8 L18,2" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M2,18 L8,12" /></svg>',social:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <line fill="none" stroke="#000" stroke-width="1.1" x1="13.4" y1="14" x2="6.3" y2="10.7" /> <line fill="none" stroke="#000" stroke-width="1.1" x1="13.5" y1="5.5" x2="6.5" y2="8.8" /> <circle fill="none" stroke="#000" stroke-width="1.1" cx="15.5" cy="4.6" r="2.3" /> <circle fill="none" stroke="#000" stroke-width="1.1" cx="15.5" cy="14.8" r="2.3" /> <circle fill="none" stroke="#000" stroke-width="1.1" cx="4.5" cy="9.8" r="2.3" /></svg>',soundcloud:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M17.2,9.4c-0.4,0-0.8,0.1-1.101,0.2c-0.199-2.5-2.399-4.5-5-4.5c-0.6,0-1.2,0.1-1.7,0.3C9.2,5.5,9.1,5.6,9.1,5.6V15h8 c1.601,0,2.801-1.2,2.801-2.8C20,10.7,18.7,9.4,17.2,9.4L17.2,9.4z" /> <rect x="6" y="6.5" width="1.5" height="8.5" /> <rect x="3" y="8" width="1.5" height="7" /> <rect y="10" width="1.5" height="5" /></svg>',star:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon fill="none" stroke="#000" stroke-width="1.01" points="10 2 12.63 7.27 18.5 8.12 14.25 12.22 15.25 18 10 15.27 4.75 18 5.75 12.22 1.5 8.12 7.37 7.27" /></svg>',strikethrough:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M6,13.02 L6.65,13.02 C7.64,15.16 8.86,16.12 10.41,16.12 C12.22,16.12 12.92,14.93 12.92,13.89 C12.92,12.55 11.99,12.03 9.74,11.23 C8.05,10.64 6.23,10.11 6.23,7.83 C6.23,5.5 8.09,4.09 10.4,4.09 C11.44,4.09 12.13,4.31 12.72,4.54 L13.33,4 L13.81,4 L13.81,7.59 L13.16,7.59 C12.55,5.88 11.52,4.89 10.07,4.89 C8.84,4.89 7.89,5.69 7.89,7.03 C7.89,8.29 8.89,8.78 10.88,9.45 C12.57,10.03 14.38,10.6 14.38,12.91 C14.38,14.75 13.27,16.93 10.18,16.93 C9.18,16.93 8.17,16.69 7.46,16.39 L6.52,17 L6,17 L6,13.02 L6,13.02 Z" /> <rect x="3" y="10" width="15" height="1" /></svg>',table:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect x="1" y="3" width="18" height="1" /> <rect x="1" y="7" width="18" height="1" /> <rect x="1" y="11" width="18" height="1" /> <rect x="1" y="15" width="18" height="1" /></svg>',tablet:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" d="M5,18.5 C4.2,18.5 3.5,17.8 3.5,17 L3.5,3 C3.5,2.2 4.2,1.5 5,1.5 L16,1.5 C16.8,1.5 17.5,2.2 17.5,3 L17.5,17 C17.5,17.8 16.8,18.5 16,18.5 L5,18.5 L5,18.5 L5,18.5 Z" /> <circle cx="10.5" cy="16.3" r="0.8" /></svg>',tag:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" stroke-width="1.1" d="M17.5,3.71 L17.5,7.72 C17.5,7.96 17.4,8.2 17.21,8.39 L8.39,17.2 C7.99,17.6 7.33,17.6 6.93,17.2 L2.8,13.07 C2.4,12.67 2.4,12.01 2.8,11.61 L11.61,2.8 C11.81,2.6 12.08,2.5 12.34,2.5 L16.19,2.5 C16.52,2.5 16.86,2.63 17.11,2.88 C17.35,3.11 17.48,3.4 17.5,3.71 L17.5,3.71 Z" /> <circle cx="14" cy="6" r="1" /></svg>',thumbnails:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect fill="none" stroke="#000" x="3.5" y="3.5" width="5" height="5" /> <rect fill="none" stroke="#000" x="11.5" y="3.5" width="5" height="5" /> <rect fill="none" stroke="#000" x="11.5" y="11.5" width="5" height="5" /> <rect fill="none" stroke="#000" x="3.5" y="11.5" width="5" height="5" /></svg>',trash:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polyline fill="none" stroke="#000" points="6.5 3 6.5 1.5 13.5 1.5 13.5 3" /> <polyline fill="none" stroke="#000" points="4.5 4 4.5 18.5 15.5 18.5 15.5 4" /> <rect x="8" y="7" width="1" height="9" /> <rect x="11" y="7" width="1" height="9" /> <rect x="2" y="3" width="16" height="1" /></svg>',tripadvisor:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M19.021,7.866C19.256,6.862,20,5.854,20,5.854h-3.346C14.781,4.641,12.504,4,9.98,4C7.363,4,4.999,4.651,3.135,5.876H0\tc0,0,0.738,0.987,0.976,1.988c-0.611,0.837-0.973,1.852-0.973,2.964c0,2.763,2.249,5.009,5.011,5.009\tc1.576,0,2.976-0.737,3.901-1.879l1.063,1.599l1.075-1.615c0.475,0.611,1.1,1.111,1.838,1.451c1.213,0.547,2.574,0.612,3.825,0.15\tc2.589-0.963,3.913-3.852,2.964-6.439c-0.175-0.463-0.4-0.876-0.675-1.238H19.021z M16.38,14.594\tc-1.002,0.371-2.088,0.328-3.06-0.119c-0.688-0.317-1.252-0.817-1.657-1.438c-0.164-0.25-0.313-0.52-0.417-0.811\tc-0.124-0.328-0.186-0.668-0.217-1.014c-0.063-0.689,0.037-1.396,0.339-2.043c0.448-0.971,1.251-1.71,2.25-2.079\tc2.075-0.765,4.375,0.3,5.14,2.366c0.762,2.066-0.301,4.37-2.363,5.134L16.38,14.594L16.38,14.594z M8.322,13.066\tc-0.72,1.059-1.935,1.76-3.309,1.76c-2.207,0-4.001-1.797-4.001-3.996c0-2.203,1.795-4.002,4.001-4.002\tc2.204,0,3.999,1.8,3.999,4.002c0,0.137-0.024,0.261-0.04,0.396c-0.067,0.678-0.284,1.313-0.648,1.853v-0.013H8.322z M2.472,10.775\tc0,1.367,1.112,2.479,2.476,2.479c1.363,0,2.472-1.11,2.472-2.479c0-1.359-1.11-2.468-2.472-2.468\tC3.584,8.306,2.473,9.416,2.472,10.775L2.472,10.775z M12.514,10.775c0,1.367,1.104,2.479,2.471,2.479\tc1.363,0,2.474-1.108,2.474-2.479c0-1.359-1.11-2.468-2.474-2.468c-1.364,0-2.477,1.109-2.477,2.468H12.514z M3.324,10.775\tc0-0.893,0.726-1.618,1.614-1.618c0.889,0,1.625,0.727,1.625,1.618c0,0.898-0.725,1.627-1.625,1.627\tc-0.901,0-1.625-0.729-1.625-1.627H3.324z M13.354,10.775c0-0.893,0.726-1.618,1.627-1.618c0.886,0,1.61,0.727,1.61,1.618\tc0,0.898-0.726,1.627-1.626,1.627s-1.625-0.729-1.625-1.627H13.354z M9.977,4.875c1.798,0,3.425,0.324,4.849,0.968\tc-0.535,0.015-1.061,0.108-1.586,0.3c-1.264,0.463-2.264,1.388-2.815,2.604c-0.262,0.551-0.398,1.133-0.448,1.72\tC9.79,7.905,7.677,5.873,5.076,5.82C6.501,5.208,8.153,4.875,9.94,4.875H9.977z" /></svg>',tumblr:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M6.885,8.598c0,0,0,3.393,0,4.996c0,0.282,0,0.66,0.094,0.942c0.377,1.509,1.131,2.545,2.545,3.11 c1.319,0.472,2.356,0.472,3.676,0c0.565-0.188,1.132-0.659,1.132-0.659l-0.849-2.263c0,0-1.036,0.378-1.603,0.283 c-0.565-0.094-1.226-0.66-1.226-1.508c0-1.603,0-4.902,0-4.902h2.828V5.771h-2.828V2H8.205c0,0-0.094,0.66-0.188,0.942 C7.828,3.791,7.262,4.733,6.603,5.394C5.848,6.147,5,6.43,5,6.43v2.168H6.885z" /></svg>',tv:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect x="7" y="16" width="6" height="1" /> <rect fill="none" stroke="#000" x="0.5" y="3.5" width="19" height="11" /></svg>',twitter:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M19,4.74 C18.339,5.029 17.626,5.229 16.881,5.32 C17.644,4.86 18.227,4.139 18.503,3.28 C17.79,3.7 17.001,4.009 16.159,4.17 C15.485,3.45 14.526,3 13.464,3 C11.423,3 9.771,4.66 9.771,6.7 C9.771,6.99 9.804,7.269 9.868,7.539 C6.795,7.38 4.076,5.919 2.254,3.679 C1.936,4.219 1.754,4.86 1.754,5.539 C1.754,6.82 2.405,7.95 3.397,8.61 C2.79,8.589 2.22,8.429 1.723,8.149 L1.723,8.189 C1.723,9.978 2.997,11.478 4.686,11.82 C4.376,11.899 4.049,11.939 3.713,11.939 C3.475,11.939 3.245,11.919 3.018,11.88 C3.49,13.349 4.852,14.419 6.469,14.449 C5.205,15.429 3.612,16.019 1.882,16.019 C1.583,16.019 1.29,16.009 1,15.969 C2.635,17.019 4.576,17.629 6.662,17.629 C13.454,17.629 17.17,12 17.17,7.129 C17.17,6.969 17.166,6.809 17.157,6.649 C17.879,6.129 18.504,5.478 19,4.74" /></svg>',uikit:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="14.4,3.1 11.3,5.1 15,7.3 15,12.9 10,15.7 5,12.9 5,8.5 2,6.8 2,14.8 9.9,19.5 18,14.8 18,5.3" /> <polygon points="9.8,4.2 6.7,2.4 9.8,0.4 12.9,2.3" /></svg>',unlock:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect fill="none" stroke="#000" x="3.5" y="8.5" width="13" height="10" /> <path fill="none" stroke="#000" d="M6.5,8.5 L6.5,4.9 C6.5,3 8.1,1.5 10,1.5 C11.9,1.5 13.5,3 13.5,4.9" /></svg>',upload:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polyline fill="none" stroke="#000" points="5 8 9.5 3.5 14 8 " /> <rect x="3" y="17" width="13" height="1" /> <line fill="none" stroke="#000" x1="9.5" y1="15" x2="9.5" y2="4" /></svg>',user:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#000" stroke-width="1.1" cx="9.9" cy="6.4" r="4.4" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M1.5,19 C2.3,14.5 5.8,11.2 10,11.2 C14.2,11.2 17.7,14.6 18.5,19.2" /></svg>',users:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#000" stroke-width="1.1" cx="7.7" cy="8.6" r="3.5" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M1,18.1 C1.7,14.6 4.4,12.1 7.6,12.1 C10.9,12.1 13.7,14.8 14.3,18.3" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M11.4,4 C12.8,2.4 15.4,2.8 16.3,4.7 C17.2,6.6 15.7,8.9 13.6,8.9 C16.5,8.9 18.8,11.3 19.2,14.1" /></svg>',vimeo:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M2.065,7.59C1.84,7.367,1.654,7.082,1.468,6.838c-0.332-0.42-0.137-0.411,0.274-0.772c1.026-0.91,2.004-1.896,3.127-2.688 c1.017-0.713,2.365-1.173,3.286-0.039c0.849,1.045,0.869,2.629,1.084,3.891c0.215,1.309,0.421,2.648,0.88,3.901 c0.127,0.352,0.37,1.018,0.81,1.074c0.567,0.078,1.145-0.917,1.408-1.289c0.684-0.987,1.611-2.317,1.494-3.587 c-0.115-1.349-1.572-1.095-2.482-0.773c0.146-1.514,1.555-3.216,2.912-3.792c1.439-0.597,3.579-0.587,4.302,1.036 c0.772,1.759,0.078,3.802-0.763,5.396c-0.918,1.731-2.1,3.333-3.363,4.829c-1.114,1.329-2.432,2.787-4.093,3.422 c-1.897,0.723-3.021-0.686-3.667-2.318c-0.705-1.777-1.056-3.771-1.565-5.621C4.898,8.726,4.644,7.836,4.136,7.191 C3.473,6.358,2.72,7.141,2.065,7.59C1.977,7.502,2.115,7.551,2.065,7.59L2.065,7.59z" /></svg>',warning:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle cx="10" cy="14" r="1" /> <circle fill="none" stroke="#000" stroke-width="1.1" cx="10" cy="10" r="9" /> <path d="M10.97,7.72 C10.85,9.54 10.56,11.29 10.56,11.29 C10.51,11.87 10.27,12 9.99,12 C9.69,12 9.49,11.87 9.43,11.29 C9.43,11.29 9.16,9.54 9.03,7.72 C8.96,6.54 9.03,6 9.03,6 C9.03,5.45 9.46,5.02 9.99,5 C10.53,5.01 10.97,5.44 10.97,6 C10.97,6 11.04,6.54 10.97,7.72 L10.97,7.72 Z" /></svg>',whatsapp:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M16.7,3.3c-1.8-1.8-4.1-2.8-6.7-2.8c-5.2,0-9.4,4.2-9.4,9.4c0,1.7,0.4,3.3,1.3,4.7l-1.3,4.9l5-1.3c1.4,0.8,2.9,1.2,4.5,1.2 l0,0l0,0c5.2,0,9.4-4.2,9.4-9.4C19.5,7.4,18.5,5,16.7,3.3 M10.1,17.7L10.1,17.7c-1.4,0-2.8-0.4-4-1.1l-0.3-0.2l-3,0.8l0.8-2.9 l-0.2-0.3c-0.8-1.2-1.2-2.7-1.2-4.2c0-4.3,3.5-7.8,7.8-7.8c2.1,0,4.1,0.8,5.5,2.3c1.5,1.5,2.3,3.4,2.3,5.5 C17.9,14.2,14.4,17.7,10.1,17.7 M14.4,11.9c-0.2-0.1-1.4-0.7-1.6-0.8c-0.2-0.1-0.4-0.1-0.5,0.1c-0.2,0.2-0.6,0.8-0.8,0.9 c-0.1,0.2-0.3,0.2-0.5,0.1c-0.2-0.1-1-0.4-1.9-1.2c-0.7-0.6-1.2-1.4-1.3-1.6c-0.1-0.2,0-0.4,0.1-0.5C8,8.8,8.1,8.7,8.2,8.5 c0.1-0.1,0.2-0.2,0.2-0.4c0.1-0.2,0-0.3,0-0.4C8.4,7.6,7.9,6.5,7.7,6C7.5,5.5,7.3,5.6,7.2,5.6c-0.1,0-0.3,0-0.4,0 c-0.2,0-0.4,0.1-0.6,0.3c-0.2,0.2-0.8,0.8-0.8,2c0,1.2,0.8,2.3,1,2.4c0.1,0.2,1.7,2.5,4,3.5c0.6,0.2,1,0.4,1.3,0.5 c0.6,0.2,1.1,0.2,1.5,0.1c0.5-0.1,1.4-0.6,1.6-1.1c0.2-0.5,0.2-1,0.1-1.1C14.8,12.1,14.6,12,14.4,11.9" /></svg>',wordpress:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M10,0.5c-5.2,0-9.5,4.3-9.5,9.5s4.3,9.5,9.5,9.5c5.2,0,9.5-4.3,9.5-9.5S15.2,0.5,10,0.5L10,0.5L10,0.5z M15.6,3.9h-0.1 c-0.8,0-1.4,0.7-1.4,1.5c0,0.7,0.4,1.3,0.8,1.9c0.3,0.6,0.7,1.3,0.7,2.3c0,0.7-0.3,1.5-0.6,2.7L14.1,15l-3-8.9 c0.5,0,0.9-0.1,0.9-0.1C12.5,6,12.5,5.3,12,5.4c0,0-1.3,0.1-2.2,0.1C9,5.5,7.7,5.4,7.7,5.4C7.2,5.3,7.2,6,7.6,6c0,0,0.4,0.1,0.9,0.1 l1.3,3.5L8,15L5,6.1C5.5,6.1,5.9,6,5.9,6C6.4,6,6.3,5.3,5.9,5.4c0,0-1.3,0.1-2.2,0.1c-0.2,0-0.3,0-0.5,0c1.5-2.2,4-3.7,6.9-3.7 C12.2,1.7,14.1,2.6,15.6,3.9L15.6,3.9L15.6,3.9z M2.5,6.6l3.9,10.8c-2.7-1.3-4.6-4.2-4.6-7.4C1.8,8.8,2,7.6,2.5,6.6L2.5,6.6L2.5,6.6 z M10.2,10.7l2.5,6.9c0,0,0,0.1,0.1,0.1C11.9,18,11,18.2,10,18.2c-0.8,0-1.6-0.1-2.3-0.3L10.2,10.7L10.2,10.7L10.2,10.7z M14.2,17.1 l2.5-7.3c0.5-1.2,0.6-2.1,0.6-2.9c0-0.3,0-0.6-0.1-0.8c0.6,1.2,1,2.5,1,4C18.3,13,16.6,15.7,14.2,17.1L14.2,17.1L14.2,17.1z" /></svg>',world:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" d="M1,10.5 L19,10.5" /> <path fill="none" stroke="#000" d="M2.35,15.5 L17.65,15.5" /> <path fill="none" stroke="#000" d="M2.35,5.5 L17.523,5.5" /> <path fill="none" stroke="#000" d="M10,19.46 L9.98,19.46 C7.31,17.33 5.61,14.141 5.61,10.58 C5.61,7.02 7.33,3.83 10,1.7 C10.01,1.7 9.99,1.7 10,1.7 L10,1.7 C12.67,3.83 14.4,7.02 14.4,10.58 C14.4,14.141 12.67,17.33 10,19.46 L10,19.46 L10,19.46 L10,19.46 Z" /> <circle fill="none" stroke="#000" cx="10" cy="10.5" r="9" /></svg>',xing:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M4.4,4.56 C4.24,4.56 4.11,4.61 4.05,4.72 C3.98,4.83 3.99,4.97 4.07,5.12 L5.82,8.16 L5.82,8.17 L3.06,13.04 C2.99,13.18 2.99,13.33 3.06,13.44 C3.12,13.55 3.24,13.62 3.4,13.62 L6,13.62 C6.39,13.62 6.57,13.36 6.71,13.12 C6.71,13.12 9.41,8.35 9.51,8.16 C9.49,8.14 7.72,5.04 7.72,5.04 C7.58,4.81 7.39,4.56 6.99,4.56 L4.4,4.56 L4.4,4.56 Z" /> <path d="M15.3,1 C14.91,1 14.74,1.25 14.6,1.5 C14.6,1.5 9.01,11.42 8.82,11.74 C8.83,11.76 12.51,18.51 12.51,18.51 C12.64,18.74 12.84,19 13.23,19 L15.82,19 C15.98,19 16.1,18.94 16.16,18.83 C16.23,18.72 16.23,18.57 16.16,18.43 L12.5,11.74 L12.5,11.72 L18.25,1.56 C18.32,1.42 18.32,1.27 18.25,1.16 C18.21,1.06 18.08,1 17.93,1 L15.3,1 L15.3,1 Z" /></svg>',yelp:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M17.175,14.971c-0.112,0.77-1.686,2.767-2.406,3.054c-0.246,0.1-0.487,0.076-0.675-0.069\tc-0.122-0.096-2.446-3.859-2.446-3.859c-0.194-0.293-0.157-0.682,0.083-0.978c0.234-0.284,0.581-0.393,0.881-0.276\tc0.016,0.01,4.21,1.394,4.332,1.482c0.178,0.148,0.263,0.379,0.225,0.646L17.175,14.971L17.175,14.971z M11.464,10.789\tc-0.203-0.307-0.199-0.666,0.009-0.916c0,0,2.625-3.574,2.745-3.657c0.203-0.135,0.452-0.141,0.69-0.025\tc0.691,0.335,2.085,2.405,2.167,3.199v0.027c0.024,0.271-0.082,0.491-0.273,0.623c-0.132,0.083-4.43,1.155-4.43,1.155\tc-0.322,0.096-0.68-0.06-0.882-0.381L11.464,10.789z M9.475,9.563C9.32,9.609,8.848,9.757,8.269,8.817c0,0-3.916-6.16-4.007-6.351\tc-0.057-0.212,0.011-0.455,0.202-0.65C5.047,1.211,8.21,0.327,9.037,0.529c0.27,0.069,0.457,0.238,0.522,0.479\tc0.047,0.266,0.433,5.982,0.488,7.264C10.098,9.368,9.629,9.517,9.475,9.563z M9.927,19.066c-0.083,0.225-0.273,0.373-0.54,0.421\tc-0.762,0.13-3.15-0.751-3.647-1.342c-0.096-0.131-0.155-0.262-0.167-0.394c-0.011-0.095,0-0.189,0.036-0.272\tc0.061-0.155,2.917-3.538,2.917-3.538c0.214-0.272,0.595-0.355,0.952-0.213c0.345,0.13,0.56,0.428,0.536,0.749\tC10.014,14.479,9.977,18.923,9.927,19.066z M3.495,13.912c-0.235-0.009-0.444-0.148-0.568-0.382c-0.089-0.17-0.151-0.453-0.19-0.794\tC2.63,11.701,2.761,10.144,3.07,9.648c0.145-0.226,0.357-0.345,0.592-0.336c0.154,0,4.255,1.667,4.255,1.667\tc0.321,0.118,0.521,0.453,0.5,0.833c-0.023,0.37-0.236,0.655-0.551,0.738L3.495,13.912z" /></svg>',youtube:'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M15,4.1c1,0.1,2.3,0,3,0.8c0.8,0.8,0.9,2.1,0.9,3.1C19,9.2,19,10.9,19,12c-0.1,1.1,0,2.4-0.5,3.4c-0.5,1.1-1.4,1.5-2.5,1.6 c-1.2,0.1-8.6,0.1-11,0c-1.1-0.1-2.4-0.1-3.2-1c-0.7-0.8-0.7-2-0.8-3C1,11.8,1,10.1,1,8.9c0-1.1,0-2.4,0.5-3.4C2,4.5,3,4.3,4.1,4.2 C5.3,4.1,12.6,4,15,4.1z M8,7.5v6l5.5-3L8,7.5z" /></svg>',"500px":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M9.624,11.866c-0.141,0.132,0.479,0.658,0.662,0.418c0.051-0.046,0.607-0.61,0.662-0.664c0,0,0.738,0.719,0.814,0.719\t\tc0.1,0,0.207-0.055,0.322-0.17c0.27-0.269,0.135-0.416,0.066-0.495l-0.631-0.616l0.658-0.668c0.146-0.156,0.021-0.314-0.1-0.449\t\tc-0.182-0.18-0.359-0.226-0.471-0.125l-0.656,0.654l-0.654-0.654c-0.033-0.034-0.08-0.045-0.124-0.045\t\tc-0.079,0-0.191,0.068-0.307,0.181c-0.202,0.202-0.247,0.351-0.133,0.462l0.665,0.665L9.624,11.866z" /> <path d="M11.066,2.884c-1.061,0-2.185,0.248-3.011,0.604c-0.087,0.034-0.141,0.106-0.15,0.205C7.893,3.784,7.919,3.909,7.982,4.066\t\tc0.05,0.136,0.187,0.474,0.452,0.372c0.844-0.326,1.779-0.507,2.633-0.507c0.963,0,1.9,0.191,2.781,0.564\t\tc0.695,0.292,1.357,0.719,2.078,1.34c0.051,0.044,0.105,0.068,0.164,0.068c0.143,0,0.273-0.137,0.389-0.271\t\tc0.191-0.214,0.324-0.395,0.135-0.575c-0.686-0.654-1.436-1.138-2.363-1.533C13.24,3.097,12.168,2.884,11.066,2.884z" /> <path d="M16.43,15.747c-0.092-0.028-0.242,0.05-0.309,0.119l0,0c-0.652,0.652-1.42,1.169-2.268,1.521\t\tc-0.877,0.371-1.814,0.551-2.779,0.551c-0.961,0-1.896-0.189-2.775-0.564c-0.848-0.36-1.612-0.879-2.268-1.53\t\tc-0.682-0.688-1.196-1.455-1.529-2.268c-0.325-0.799-0.471-1.643-0.471-1.643c-0.045-0.24-0.258-0.249-0.567-0.203\t\tc-0.128,0.021-0.519,0.079-0.483,0.36v0.01c0.105,0.644,0.289,1.284,0.545,1.895c0.417,0.969,1.002,1.849,1.756,2.604\t\tc0.757,0.754,1.636,1.34,2.604,1.757C8.901,18.785,9.97,19,11.088,19c1.104,0,2.186-0.215,3.188-0.645\t\tc1.838-0.896,2.604-1.757,2.604-1.757c0.182-0.204,0.227-0.317-0.1-0.643C16.779,15.956,16.525,15.774,16.43,15.747z" /> <path d="M5.633,13.287c0.293,0.71,0.723,1.341,1.262,1.882c0.54,0.54,1.172,0.971,1.882,1.264c0.731,0.303,1.509,0.461,2.298,0.461\t\tc0.801,0,1.578-0.158,2.297-0.461c0.711-0.293,1.344-0.724,1.883-1.264c0.543-0.541,0.971-1.172,1.264-1.882\t\tc0.314-0.721,0.463-1.5,0.463-2.298c0-0.79-0.148-1.569-0.463-2.289c-0.293-0.699-0.721-1.329-1.264-1.881\t\tc-0.539-0.541-1.172-0.959-1.867-1.263c-0.721-0.303-1.5-0.461-2.299-0.461c-0.802,0-1.613,0.159-2.322,0.461\t\tc-0.577,0.25-1.544,0.867-2.119,1.454v0.012V2.108h8.16C15.1,2.104,15.1,1.69,15.1,1.552C15.1,1.417,15.1,1,14.809,1H5.915\t\tC5.676,1,5.527,1.192,5.527,1.384v6.84c0,0.214,0.273,0.372,0.529,0.428c0.5,0.105,0.614-0.056,0.737-0.224l0,0\t\tc0.18-0.273,0.776-0.884,0.787-0.894c0.901-0.905,2.117-1.408,3.416-1.408c1.285,0,2.5,0.501,3.412,1.408\t\tc0.914,0.914,1.408,2.122,1.408,3.405c0,1.288-0.508,2.496-1.408,3.405c-0.9,0.896-2.152,1.406-3.438,1.406\t\tc-0.877,0-1.711-0.229-2.433-0.671v-4.158c0-0.553,0.237-1.151,0.643-1.614c0.462-0.519,1.094-0.799,1.782-0.799\t\tc0.664,0,1.293,0.253,1.758,0.715c0.459,0.459,0.709,1.071,0.709,1.723c0,1.385-1.094,2.468-2.488,2.468\t\tc-0.273,0-0.769-0.121-0.781-0.125c-0.281-0.087-0.405,0.306-0.438,0.436c-0.159,0.496,0.079,0.585,0.123,0.607\t\tc0.452,0.137,0.743,0.157,1.129,0.157c1.973,0,3.572-1.6,3.572-3.57c0-1.964-1.6-3.552-3.572-3.552c-0.97,0-1.872,0.36-2.546,1.038\t\tc-0.656,0.631-1.027,1.487-1.027,2.322v3.438v-0.011c-0.372-0.42-0.732-1.041-0.981-1.682c-0.102-0.248-0.315-0.202-0.607-0.113\t\tc-0.135,0.035-0.519,0.157-0.44,0.439C5.372,12.799,5.577,13.164,5.633,13.287z" /></svg>',"arrow-down":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="10.5,16.08 5.63,10.66 6.37,10 10.5,14.58 14.63,10 15.37,10.66" /> <line fill="none" stroke="#000" x1="10.5" y1="4" x2="10.5" y2="15" /></svg>',"arrow-left":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polyline fill="none" stroke="#000" points="10 14 5 9.5 10 5" /> <line fill="none" stroke="#000" x1="16" y1="9.5" x2="5" y2="9.52" /></svg>',"arrow-right":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polyline fill="none" stroke="#000" points="10 5 15 9.5 10 14" /> <line fill="none" stroke="#000" x1="4" y1="9.5" x2="15" y2="9.5" /></svg>',"arrow-up":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="10.5,4 15.37,9.4 14.63,10.08 10.5,5.49 6.37,10.08 5.63,9.4" /> <line fill="none" stroke="#000" x1="10.5" y1="16" x2="10.5" y2="5" /></svg>',"chevron-down":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polyline fill="none" stroke="#000" stroke-width="1.03" points="16 7 10 13 4 7" /></svg>',"chevron-left":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polyline fill="none" stroke="#000" stroke-width="1.03" points="13 16 7 10 13 4" /></svg>',"chevron-right":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polyline fill="none" stroke="#000" stroke-width="1.03" points="7 4 13 10 7 16" /></svg>',"chevron-up":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polyline fill="none" stroke="#000" stroke-width="1.03" points="4 13 10 7 16 13" /></svg>',"cloud-download":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" stroke-width="1.1" d="M6.5,14.61 L3.75,14.61 C1.96,14.61 0.5,13.17 0.5,11.39 C0.5,9.76 1.72,8.41 3.3,8.2 C3.38,5.31 5.75,3 8.68,3 C11.19,3 13.31,4.71 13.89,7.02 C14.39,6.8 14.93,6.68 15.5,6.68 C17.71,6.68 19.5,8.45 19.5,10.64 C19.5,12.83 17.71,14.6 15.5,14.6 L12.5,14.6" /> <polyline fill="none" stroke="#000" points="11.75 16 9.5 18.25 7.25 16" /> <path fill="none" stroke="#000" d="M9.5,18 L9.5,9.5" /></svg>',"cloud-upload":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" stroke-width="1.1" d="M6.5,14.61 L3.75,14.61 C1.96,14.61 0.5,13.17 0.5,11.39 C0.5,9.76 1.72,8.41 3.31,8.2 C3.38,5.31 5.75,3 8.68,3 C11.19,3 13.31,4.71 13.89,7.02 C14.39,6.8 14.93,6.68 15.5,6.68 C17.71,6.68 19.5,8.45 19.5,10.64 C19.5,12.83 17.71,14.6 15.5,14.6 L12.5,14.6" /> <polyline fill="none" stroke="#000" points="7.25 11.75 9.5 9.5 11.75 11.75" /> <path fill="none" stroke="#000" d="M9.5,18 L9.5,9.5" /></svg>',"credit-card":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <rect fill="none" stroke="#000" x="1.5" y="4.5" width="17" height="12" /> <rect x="1" y="7" width="18" height="3" /></svg>',"file-edit":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" d="M18.65,1.68 C18.41,1.45 18.109,1.33 17.81,1.33 C17.499,1.33 17.209,1.45 16.98,1.68 L8.92,9.76 L8,12.33 L10.55,11.41 L18.651,3.34 C19.12,2.87 19.12,2.15 18.65,1.68 L18.65,1.68 L18.65,1.68 Z" /> <polyline fill="none" stroke="#000" points="16.5 8.482 16.5 18.5 3.5 18.5 3.5 1.5 14.211 1.5" /></svg>',"git-branch":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#000" stroke-width="1.2" cx="7" cy="3" r="2" /> <circle fill="none" stroke="#000" stroke-width="1.2" cx="14" cy="6" r="2" /> <circle fill="none" stroke="#000" stroke-width="1.2" cx="7" cy="17" r="2" /> <path fill="none" stroke="#000" stroke-width="2" d="M14,8 C14,10.41 12.43,10.87 10.56,11.25 C9.09,11.54 7,12.06 7,15 L7,5" /></svg>',"git-fork":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#000" stroke-width="1.2" cx="5.79" cy="2.79" r="1.79" /> <circle fill="none" stroke="#000" stroke-width="1.2" cx="14.19" cy="2.79" r="1.79" /> <ellipse fill="none" stroke="#000" stroke-width="1.2" cx="10.03" cy="16.79" rx="1.79" ry="1.79" /> <path fill="none" stroke="#000" stroke-width="2" d="M5.79,4.57 L5.79,6.56 C5.79,9.19 10.03,10.22 10.03,13.31 C10.03,14.86 10.04,14.55 10.04,14.55 C10.04,14.37 10.04,14.86 10.04,13.31 C10.04,10.22 14.2,9.19 14.2,6.56 L14.2,4.57" /></svg>',"github-alt":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M10,0.5 C4.75,0.5 0.5,4.76 0.5,10.01 C0.5,15.26 4.75,19.51 10,19.51 C15.24,19.51 19.5,15.26 19.5,10.01 C19.5,4.76 15.25,0.5 10,0.5 L10,0.5 Z M12.81,17.69 C12.81,17.69 12.81,17.7 12.79,17.69 C12.47,17.75 12.35,17.59 12.35,17.36 L12.35,16.17 C12.35,15.45 12.09,14.92 11.58,14.56 C12.2,14.51 12.77,14.39 13.26,14.21 C13.87,13.98 14.36,13.69 14.74,13.29 C15.42,12.59 15.76,11.55 15.76,10.17 C15.76,9.25 15.45,8.46 14.83,7.8 C15.1,7.08 15.07,6.29 14.75,5.44 L14.51,5.42 C14.34,5.4 14.06,5.46 13.67,5.61 C13.25,5.78 12.79,6.03 12.31,6.35 C11.55,6.16 10.81,6.05 10.09,6.05 C9.36,6.05 8.61,6.15 7.88,6.35 C7.28,5.96 6.75,5.68 6.26,5.54 C6.07,5.47 5.9,5.44 5.78,5.44 L5.42,5.44 C5.06,6.29 5.04,7.08 5.32,7.8 C4.7,8.46 4.4,9.25 4.4,10.17 C4.4,11.94 4.96,13.16 6.08,13.84 C6.53,14.13 7.05,14.32 7.69,14.43 C8.03,14.5 8.32,14.54 8.55,14.55 C8.07,14.89 7.82,15.42 7.82,16.16 L7.82,17.51 C7.8,17.69 7.7,17.8 7.51,17.8 C4.21,16.74 1.82,13.65 1.82,10.01 C1.82,5.5 5.49,1.83 10,1.83 C14.5,1.83 18.17,5.5 18.17,10.01 C18.18,13.53 15.94,16.54 12.81,17.69 L12.81,17.69 Z" /></svg>',"google-plus":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M12.9,9c0,2.7-0.6,5-3.2,6.3c-3.7,1.8-8.1,0.2-9.4-3.6C-1.1,7.6,1.9,3.3,6.1,3c1.7-0.1,3.2,0.3,4.6,1.3 c0.1,0.1,0.3,0.2,0.4,0.4c-0.5,0.5-1.2,1-1.7,1.6c-1-0.8-2.1-1.1-3.5-0.9C5,5.6,4.2,6,3.6,6.7c-1.3,1.3-1.5,3.4-0.5,5 c1,1.7,2.6,2.3,4.6,1.9c1.4-0.3,2.4-1.2,2.6-2.6H6.9V9H12.9z" /> <polygon points="20,9 20,11 18,11 18,13 16,13 16,11 14,11 14,9 16,9 16,7 18,7 18,9 " /></svg>',"minus-circle":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#000" stroke-width="1.1" cx="9.5" cy="9.5" r="9" /> <line fill="none" stroke="#000" x1="5" y1="9.5" x2="14" y2="9.5" /></svg>',"more-vertical":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle cx="10" cy="3" r="2" /> <circle cx="10" cy="10" r="2" /> <circle cx="10" cy="17" r="2" /></svg>',"paint-bucket":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M10.21,1 L0,11.21 L8.1,19.31 L18.31,9.1 L10.21,1 L10.21,1 Z M16.89,9.1 L15,11 L1.7,11 L10.21,2.42 L16.89,9.1 Z" /> <path fill="none" stroke="#000" stroke-width="1.1" d="M6.42,2.33 L11.7,7.61" /> <path d="M18.49,12 C18.49,12 20,14.06 20,15.36 C20,16.28 19.24,17 18.49,17 L18.49,17 C17.74,17 17,16.28 17,15.36 C17,14.06 18.49,12 18.49,12 L18.49,12 Z" /></svg>',"phone-landscape":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" d="M17,5.5 C17.8,5.5 18.5,6.2 18.5,7 L18.5,14 C18.5,14.8 17.8,15.5 17,15.5 L3,15.5 C2.2,15.5 1.5,14.8 1.5,14 L1.5,7 C1.5,6.2 2.2,5.5 3,5.5 L17,5.5 L17,5.5 L17,5.5 Z" /> <circle cx="3.8" cy="10.5" r="0.8" /></svg>',"play-circle":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon fill="none" stroke="#000" stroke-width="1.1" points="8.5 7 13.5 10 8.5 13" /> <circle fill="none" stroke="#000" stroke-width="1.1" cx="10" cy="10" r="9" /></svg>',"plus-circle":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <circle fill="none" stroke="#000" stroke-width="1.1" cx="9.5" cy="9.5" r="9" /> <line fill="none" stroke="#000" x1="9.5" y1="5" x2="9.5" y2="14" /> <line fill="none" stroke="#000" x1="5" y1="9.5" x2="14" y2="9.5" /></svg>',"quote-right":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path d="M17.27,7.79 C17.27,9.45 16.97,10.43 15.99,12.02 C14.98,13.64 13,15.23 11.56,15.97 L11.1,15.08 C12.34,14.2 13.14,13.51 14.02,11.82 C14.27,11.34 14.41,10.92 14.49,10.54 C14.3,10.58 14.09,10.6 13.88,10.6 C12.06,10.6 10.59,9.12 10.59,7.3 C10.59,5.48 12.06,4 13.88,4 C15.39,4 16.67,5.02 17.05,6.42 C17.19,6.82 17.27,7.27 17.27,7.79 L17.27,7.79 Z" /> <path d="M8.68,7.79 C8.68,9.45 8.38,10.43 7.4,12.02 C6.39,13.64 4.41,15.23 2.97,15.97 L2.51,15.08 C3.75,14.2 4.55,13.51 5.43,11.82 C5.68,11.34 5.82,10.92 5.9,10.54 C5.71,10.58 5.5,10.6 5.29,10.6 C3.47,10.6 2,9.12 2,7.3 C2,5.48 3.47,4 5.29,4 C6.8,4 8.08,5.02 8.46,6.42 C8.6,6.82 8.68,7.27 8.68,7.79 L8.68,7.79 Z" /></svg>',"sign-in":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="7 2 17 2 17 17 7 17 7 16 16 16 16 3 7 3" /> <polygon points="9.1 13.4 8.5 12.8 11.28 10 4 10 4 9 11.28 9 8.5 6.2 9.1 5.62 13 9.5" /></svg>',"sign-out":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="13.1 13.4 12.5 12.8 15.28 10 8 10 8 9 15.28 9 12.5 6.2 13.1 5.62 17 9.5" /> <polygon points="13 2 3 2 3 17 13 17 13 16 4 16 4 3 13 3" /></svg>',"tablet-landscape":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <path fill="none" stroke="#000" d="M1.5,5 C1.5,4.2 2.2,3.5 3,3.5 L17,3.5 C17.8,3.5 18.5,4.2 18.5,5 L18.5,16 C18.5,16.8 17.8,17.5 17,17.5 L3,17.5 C2.2,17.5 1.5,16.8 1.5,16 L1.5,5 L1.5,5 L1.5,5 Z" /> <circle cx="3.7" cy="10.5" r="0.8" /></svg>',"triangle-down":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="5 7 15 7 10 12" /></svg>',"triangle-left":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="12 5 7 10 12 15" /></svg>',"triangle-right":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="8 5 13 10 8 15" /></svg>',"triangle-up":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="5 13 10 8 15 13" /></svg>',"video-camera":'<svg width="20" height="20" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> <polygon points="18,6 18,14 12,10 " /> <rect x="2" y="5" width="12" height="10" /></svg>'};function i(e){i.installed||e.icon.add(t)}return"undefined"!=typeof window&&window.UIkit&&window.UIkit.use(i),i});/* flatpickr v4.3.2,, @license MIT */
!function(e,t){"object"==typeof exports&&"undefined"!=typeof module?t(exports):"function"==typeof define&&define.amd?define(["exports"],t):t(e.flatpickr={})}(this,function(e){"use strict";var t=Object.assign||function(e){for(var t,n=1,a=arguments.length;n<a;n++)for(var i in t=arguments[n])Object.prototype.hasOwnProperty.call(t,i)&&(e[i]=t[i]);return e},n=function(e){return("0"+e).slice(-2)},a=function(e){return!0===e?1:0};function i(e,t,n){var a;return void 0===n&&(n=!1),function(){var i=this,o=arguments;null!==a&&clearTimeout(a),a=window.setTimeout(function(){a=null,n||e.apply(i,o)},t),n&&!a&&e.apply(i,o)}}var o=function(e){return e instanceof Array?e:[e]},r=function(){},l={D:r,F:function(e,t,n){e.setMonth(n.months.longhand.indexOf(t))},G:function(e,t){e.setHours(parseFloat(t))},H:function(e,t){e.setHours(parseFloat(t))},J:function(e,t){e.setDate(parseFloat(t))},K:function(e,t,n){e.setHours(e.getHours()%12+12*a(new RegExp(n.amPM[1],"i").test(t)))},M:function(e,t,n){e.setMonth(n.months.shorthand.indexOf(t))},S:function(e,t){e.setSeconds(parseFloat(t))},U:function(e,t){return new Date(1e3*parseFloat(t))},W:function(e,t){var n=parseInt(t);return new Date(e.getFullYear(),0,2+7*(n-1),0,0,0,0)},Y:function(e,t){e.setFullYear(parseFloat(t))},Z:function(e,t){return new Date(t)},d:function(e,t){e.setDate(parseFloat(t))},h:function(e,t){e.setHours(parseFloat(t))},i:function(e,t){e.setMinutes(parseFloat(t))},j:function(e,t){e.setDate(parseFloat(t))},l:r,m:function(e,t){e.setMonth(parseFloat(t)-1)},n:function(e,t){e.setMonth(parseFloat(t)-1)},s:function(e,t){e.setSeconds(parseFloat(t))},w:r,y:function(e,t){e.setFullYear(2e3+parseFloat(t))}},c={D:"(\\w+)",F:"(\\w+)",G:"(\\d\\d|\\d)",H:"(\\d\\d|\\d)",J:"(\\d\\d|\\d)\\w+",K:"",M:"(\\w+)",S:"(\\d\\d|\\d)",U:"(.+)",W:"(\\d\\d|\\d)",Y:"(\\d{4})",Z:"(.+)",d:"(\\d\\d|\\d)",h:"(\\d\\d|\\d)",i:"(\\d\\d|\\d)",j:"(\\d\\d|\\d)",l:"(\\w+)",m:"(\\d\\d|\\d)",n:"(\\d\\d|\\d)",s:"(\\d\\d|\\d)",w:"(\\d\\d|\\d)",y:"(\\d{2})"},d={Z:function(e){return e.toISOString()},D:function(e,t,n){return t.weekdays.shorthand[d.w(e,t,n)]},F:function(e,t,n){return g(d.n(e,t,n)-1,!1,t)},G:function(e,t,a){return n(d.h(e,t,a))},H:function(e){return n(e.getHours())},J:function(e,t){return void 0!==t.ordinal?e.getDate()+t.ordinal(e.getDate()):e.getDate()},K:function(e,t){return t.amPM[a(e.getHours()>11)]},M:function(e,t){return g(e.getMonth(),!0,t)},S:function(e){return n(e.getSeconds())},U:function(e){return e.getTime()/1e3},W:function(e,t,n){return n.getWeek(e)},Y:function(e){return e.getFullYear()},d:function(e){return n(e.getDate())},h:function(e){return e.getHours()%12?e.getHours()%12:12},i:function(e){return n(e.getMinutes())},j:function(e){return e.getDate()},l:function(e,t){return t.weekdays.longhand[e.getDay()]},m:function(e){return n(e.getMonth()+1)},n:function(e){return e.getMonth()+1},s:function(e){return e.getSeconds()},w:function(e){return e.getDay()},y:function(e){return String(e.getFullYear()).substring(2)}},s={weekdays:{shorthand:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],longhand:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"]},months:{shorthand:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],longhand:["January","February","March","April","May","June","July","August","September","October","November","December"]},daysInMonth:[31,28,31,30,31,30,31,31,30,31,30,31],firstDayOfWeek:0,ordinal:function(e){var t=e%100;if(t>3&&t<21)return"th";switch(t%10){case 1:return"st";case 2:return"nd";case 3:return"rd";default:return"th"}},rangeSeparator:" to ",weekAbbreviation:"Wk",scrollTitle:"Scroll to increment",toggleTitle:"Click to toggle",amPM:["AM","PM"]},u=function(e){var t=e.config,n=void 0===t?h:t,a=e.l10n,i=void 0===a?s:a;return function(e,t,a){if(void 0!==n.formatDate)return n.formatDate(e,t);var o=a||i;return t.split("").map(function(t,a,i){return d[t]&&"\\"!==i[a-1]?d[t](e,o,n):"\\"!==t?t:""}).join("")}},f=function(e){var t=e.config,n=void 0===t?h:t,a=e.l10n,i=void 0===a?s:a;return function(e,t,a){if(0===e||e){var o,r=e;if(e instanceof Date)o=new Date(e.getTime());else if("string"!=typeof e&&void 0!==e.toFixed)o=new Date(e);else if("string"==typeof e){var d=t||(n||h).dateFormat,s=String(e).trim();if("today"===s)o=new Date,a=!0;else if(/Z$/.test(s)||/GMT$/.test(s))o=new Date(e);else if(n&&n.parseDate)o=n.parseDate(e,d);else{o=n&&n.noCalendar?new Date((new Date).setHours(0,0,0,0)):new Date((new Date).getFullYear(),0,1,0,0,0,0);for(var u=void 0,f=[],m=0,g=0,p="";m<d.length;m++){var v=d[m],D="\\"===v,b="\\"===d[m-1]||D;if(c[v]&&!b){p+=c[v];var w=new RegExp(p).exec(e);w&&(u=!0)&&f["Y"!==v?"push":"unshift"]({fn:l[v],val:w[++g]})}else D||(p+=".");f.forEach(function(e){var t=e.fn,n=e.val;return o=t(o,n,i)||o})}o=u?o:void 0}}if(o instanceof Date)return!0===a&&o.setHours(0,0,0,0),o;n.errorHandler(new Error("Invalid date provided: "+r))}}};function m(e,t,n){return void 0===n&&(n=!0),!1!==n?new Date(e.getTime()).setHours(0,0,0,0)-new Date(t.getTime()).setHours(0,0,0,0):e.getTime()-t.getTime()}var g=function(e,t,n){return n.months[t?"shorthand":"longhand"][e]},p={DAY:864e5},h={_disable:[],_enable:[],allowInput:!1,altFormat:"F j, Y",altInput:!1,altInputClass:"form-control input",animate:"object"==typeof window&&-1===window.navigator.userAgent.indexOf("MSIE"),ariaDateFormat:"F j, Y",clickOpens:!0,closeOnSelect:!0,conjunction:", ",dateFormat:"Y-m-d",defaultHour:12,defaultMinute:0,defaultSeconds:0,disable:[],disableMobile:!1,enable:[],enableSeconds:!1,enableTime:!1,errorHandler:console.warn,getWeek:function(e){var t=new Date(e.getTime());t.setHours(0,0,0,0),t.setDate(t.getDate()+3-(t.getDay()+6)%7);var n=new Date(t.getFullYear(),0,4);return 1+Math.round(((t.getTime()-n.getTime())/864e5-3+(n.getDay()+6)%7)/7)},hourIncrement:1,ignoredFocusElements:[],inline:!1,locale:"default",minuteIncrement:5,mode:"single",nextArrow:"<svg version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 17 17'><g></g><path d='M13.207 8.472l-7.854 7.854-0.707-0.707 7.146-7.146-7.146-7.148 0.707-0.707 7.854 7.854z' /></svg>",noCalendar:!1,onChange:[],onClose:[],onDayCreate:[],onDestroy:[],onKeyDown:[],onMonthChange:[],onOpen:[],onParseConfig:[],onReady:[],onValueUpdate:[],onYearChange:[],onPreCalendarPosition:[],plugins:[],position:"auto",positionElement:void 0,prevArrow:"<svg version='1.1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' viewBox='0 0 17 17'><g></g><path d='M5.207 8.471l7.146 7.147-0.707 0.707-7.853-7.854 7.854-7.853 0.707 0.707-7.147 7.146z' /></svg>",shorthandCurrentMonth:!1,static:!1,time_24hr:!1,weekNumbers:!1,wrap:!1};function v(e,t,n){if(!0===n)return e.classList.add(t);e.classList.remove(t)}function D(e,t,n){var a=window.document.createElement(e);return t=t||"",n=n||"",a.className=t,void 0!==n&&(a.textContent=n),a}function b(e,t){var n=D("div","numInputWrapper"),a=D("input","numInput "+e),i=D("span","arrowUp"),o=D("span","arrowDown");if(a.type="text",a.pattern="\\d*",void 0!==t)for(var r in t)a.setAttribute(r,t[r]);return n.appendChild(a),n.appendChild(i),n.appendChild(o),n}"function"!=typeof Object.assign&&(Object.assign=function(e){for(var t=[],n=1;n<arguments.length;n++)t[n-1]=arguments[n];if(!e)throw TypeError("Cannot convert undefined or null to object");for(var a=function(t){t&&Object.keys(t).forEach(function(n){return e[n]=t[n]})},i=0,o=t;i<o.length;i++){a(o[i])}return e});var w,M=300;function C(e,r){var l={config:t({},w.defaultConfig),l10n:s};function d(e){return e.bind(l)}function h(e){l.config.noCalendar&&0===l.selectedDates.length&&(l.setDate(void 0!==l.config.minDate?new Date(l.config.minDate.getTime()):(new Date).setHours(l.config.defaultHour,l.config.defaultMinute,l.config.defaultSeconds,0),!1),C(),ne()),function(e){e.preventDefault();var t="keydown"===e.type,i=e.target;void 0!==l.amPM&&e.target===l.amPM&&(l.amPM.textContent=l.l10n.amPM[a(l.amPM.textContent===l.l10n.amPM[0])]);var o=parseFloat(i.getAttribute("data-min")),r=parseFloat(i.getAttribute("data-max")),c=parseFloat(i.getAttribute("data-step")),d=parseInt(i.value,10),s=e.delta||(t?38===e.which?1:-1:0),u=d+c*s;if(void 0!==i.value&&2===i.value.length){var f=i===l.hourElement,m=i===l.minuteElement;u<o?(u=r+u+a(!f)+(a(f)&&a(!l.amPM)),m&&Y(void 0,-1,l.hourElement)):u>r&&(u=i===l.hourElement?u-r-a(!l.amPM):o,m&&Y(void 0,1,l.hourElement)),l.amPM&&f&&(1===c?u+d===23:Math.abs(u-d)>c)&&(l.amPM.textContent=l.l10n.amPM[a(l.amPM.textContent===l.l10n.amPM[0])]),i.value=n(u)}}(e),0!==l.selectedDates.length&&("input"!==e.type?(C(),ne()):setTimeout(function(){C(),ne()},M))}function C(){if(void 0!==l.hourElement&&void 0!==l.minuteElement){var e,t,n=(parseInt(l.hourElement.value.slice(-2),10)||0)%24,i=(parseInt(l.minuteElement.value,10)||0)%60,o=void 0!==l.secondElement?(parseInt(l.secondElement.value,10)||0)%60:0;void 0!==l.amPM&&(e=n,t=l.amPM.textContent,n=e%12+12*a(t===l.l10n.amPM[1]));var r=void 0!==l.config.minTime||l.config.minDate&&l.minDateHasTime&&l.latestSelectedDateObj&&0===m(l.latestSelectedDateObj,l.config.minDate,!0);if(void 0!==l.config.maxTime||l.config.maxDate&&l.maxDateHasTime&&l.latestSelectedDateObj&&0===m(l.latestSelectedDateObj,l.config.maxDate,!0)){var c=void 0!==l.config.maxTime?l.config.maxTime:l.config.maxDate;(n=Math.min(n,c.getHours()))===c.getHours()&&(i=Math.min(i,c.getMinutes()))}if(r){var d=void 0!==l.config.minTime?l.config.minTime:l.config.minDate;(n=Math.max(n,d.getHours()))===d.getHours()&&(i=Math.max(i,d.getMinutes()))}x(n,i,o)}}function y(e){var t=e||l.latestSelectedDateObj;t&&x(t.getHours(),t.getMinutes(),t.getSeconds())}function x(e,t,i){void 0!==l.latestSelectedDateObj&&l.latestSelectedDateObj.setHours(e%24,t,i||0,0),l.hourElement&&l.minuteElement&&!l.isMobile&&(l.hourElement.value=n(l.config.time_24hr?e:(12+e)%12+12*a(e%12==0)),l.minuteElement.value=n(t),void 0!==l.amPM&&(l.amPM.textContent=l.l10n.amPM[a(e>=12)]),void 0!==l.secondElement&&(l.secondElement.value=n(i)))}function E(e){var t=parseInt(e.target.value)+(e.delta||0);4!==t.toString().length&&"Enter"!==e.key||(l.currentYearElement.blur(),/[^\d]/.test(t.toString())||L(t))}function T(e,t,n,a){return t instanceof Array?t.forEach(function(t){return T(e,t,n,a)}):e instanceof Array?e.forEach(function(e){return T(e,t,n,a)}):(e.addEventListener(t,n,a),void l._handlers.push({element:e,event:t,handler:n}))}function k(e){return function(t){1===t.which&&e(t)}}function I(){Q("onChange")}function _(e){var t=void 0!==e?l.parseDate(e):l.latestSelectedDateObj||(l.config.minDate&&l.config.minDate>l.now?l.config.minDate:l.config.maxDate&&l.config.maxDate<l.now?l.config.maxDate:l.now);try{void 0!==t&&(l.currentYear=t.getFullYear(),l.currentMonth=t.getMonth())}catch(e){e.message="Invalid date supplied: "+t,l.config.errorHandler(e)}l.redraw()}function S(e){~e.target.className.indexOf("arrow")&&Y(e,e.target.classList.contains("arrowUp")?1:-1)}function Y(e,t,n){var a=e&&e.target,i=n||a&&a.parentNode&&a.parentNode.firstChild,o=X("increment");o.delta=t,i&&i.dispatchEvent(o)}function N(e,t,n,a){var i,o=R(t,!0),r=D("span","flatpickr-day "+e,t.getDate().toString());return r.dateObj=t,r.$i=a,r.setAttribute("aria-label",l.formatDate(t,l.config.ariaDateFormat)),0===m(t,l.now)&&(l.todayDateElem=r,r.classList.add("today")),o?(r.tabIndex=-1,ee(t)&&(r.classList.add("selected"),l.selectedDateElem=r,"range"===l.config.mode&&(v(r,"startRange",l.selectedDates[0]&&0===m(t,l.selectedDates[0])),v(r,"endRange",l.selectedDates[1]&&0===m(t,l.selectedDates[1]))))):(r.classList.add("disabled"),l.selectedDates[0]&&l.minRangeDate&&t>l.minRangeDate&&t<l.selectedDates[0]?l.minRangeDate=t:l.selectedDates[0]&&l.maxRangeDate&&t<l.maxRangeDate&&t>l.selectedDates[0]&&(l.maxRangeDate=t)),"range"===l.config.mode&&(i=t,!("range"!==l.config.mode||l.selectedDates.length<2)&&m(i,l.selectedDates[0])>=0&&m(i,l.selectedDates[1])<=0&&!ee(t)&&r.classList.add("inRange"),1===l.selectedDates.length&&void 0!==l.minRangeDate&&void 0!==l.maxRangeDate&&(t<l.minRangeDate||t>l.maxRangeDate)&&r.classList.add("notAllowed")),l.weekNumbers&&"prevMonthDay"!==e&&n%7==1&&l.weekNumbers.insertAdjacentHTML("beforeend","<span class='flatpickr-day'>"+l.config.getWeek(t)+"</span>"),Q("onDayCreate",r),r}function O(e,t){var n=e+t||0,a=void 0!==e?l.days.childNodes[n]:l.selectedDateElem||l.todayDateElem||l.days.childNodes[0];void 0===a&&0!==t&&(t>0?(l.changeMonth(1,!0,!0),n%=42):t<0&&(l.changeMonth(-1,!0,!0),n+=42)),(a=a||l.days.childNodes[n]).focus(),"range"===l.config.mode&&J(a)}function P(){if(void 0!==l.daysContainer){var e=(new Date(l.currentYear,l.currentMonth,1).getDay()-l.l10n.firstDayOfWeek+7)%7,t="range"===l.config.mode,n=l.utils.getDaysInMonth((l.currentMonth-1+12)%12),a=l.utils.getDaysInMonth(),i=window.document.createDocumentFragment(),o=n+1-e,r=0;for(l.weekNumbers&&l.weekNumbers.firstChild&&(l.weekNumbers.textContent=""),t&&(l.minRangeDate=new Date(l.currentYear,l.currentMonth-1,o),l.maxRangeDate=new Date(l.currentYear,l.currentMonth+1,(42-e)%a));o<=n;o++,r++)i.appendChild(N("prevMonthDay",new Date(l.currentYear,l.currentMonth-1,o),o,r));for(o=1;o<=a;o++,r++)i.appendChild(N("",new Date(l.currentYear,l.currentMonth,o),o,r));for(var c=a+1;c<=42-e;c++,r++)i.appendChild(N("nextMonthDay",new Date(l.currentYear,l.currentMonth+1,c%a),c,r));t&&1===l.selectedDates.length&&i.childNodes[0]?(l._hidePrevMonthArrow=l._hidePrevMonthArrow||!!l.minRangeDate&&l.minRangeDate>i.childNodes[0].dateObj,l._hideNextMonthArrow=l._hideNextMonthArrow||!!l.maxRangeDate&&l.maxRangeDate<new Date(l.currentYear,l.currentMonth+1,1)):te();var d=D("div","dayContainer");d.appendChild(i),function(e){for(;e.firstChild;)e.removeChild(e.firstChild)}(l.daysContainer),l.daysContainer.insertBefore(d,l.daysContainer.firstChild),l.days=l.daysContainer.firstChild}}function A(){l.weekdayContainer||(l.weekdayContainer=D("div","flatpickr-weekdays"));var e=l.l10n.firstDayOfWeek,t=l.l10n.weekdays.shorthand.slice();return e>0&&e<t.length&&(t=t.splice(e,t.length).concat(t.splice(0,e))),l.weekdayContainer.innerHTML="\n    <span class=flatpickr-weekday>\n      "+t.join("</span><span class=flatpickr-weekday>")+"\n    </span>\n    ",l.weekdayContainer}function F(e,t,n){void 0===t&&(t=!0),void 0===n&&(n=!1);var a=t?e:e-l.currentMonth;a<0&&l._hidePrevMonthArrow||a>0&&l._hideNextMonthArrow||(l.currentMonth+=a,(l.currentMonth<0||l.currentMonth>11)&&(l.currentYear+=l.currentMonth>11?1:-1,l.currentMonth=(l.currentMonth+12)%12,Q("onYearChange")),P(),Q("onMonthChange"),te(),n&&document.activeElement&&document.activeElement.$i&&O(document.activeElement.$i,0))}function j(e){return!(!l.config.appendTo||!l.config.appendTo.contains(e))||l.calendarContainer.contains(e)}function H(e){if(l.isOpen&&!l.config.inline){var t=j(e.target),n=e.target===l.input||e.target===l.altInput||l.element.contains(e.target)||e.path&&e.path.indexOf&&(~e.path.indexOf(l.input)||~e.path.indexOf(l.altInput)),a="blur"===e.type?n&&e.relatedTarget&&!j(e.relatedTarget):!n&&!t,i=!l.config.ignoredFocusElements.some(function(t){return t.contains(e.target)});a&&i&&(l.close(),"range"===l.config.mode&&1===l.selectedDates.length&&(l.clear(!1),l.redraw()))}}function L(e){if(!(!e||l.currentYearElement.getAttribute("data-min")&&e<parseInt(l.currentYearElement.getAttribute("data-min"))||l.currentYearElement.getAttribute("data-max")&&e>parseInt(l.currentYearElement.getAttribute("data-max")))){var t=e,n=l.currentYear!==t;l.currentYear=t||l.currentYear,l.config.maxDate&&l.currentYear===l.config.maxDate.getFullYear()?l.currentMonth=Math.min(l.config.maxDate.getMonth(),l.currentMonth):l.config.minDate&&l.currentYear===l.config.minDate.getFullYear()&&(l.currentMonth=Math.max(l.config.minDate.getMonth(),l.currentMonth)),n&&(l.redraw(),Q("onYearChange"))}}function R(e,t){void 0===t&&(t=!0);var n=l.parseDate(e,void 0,t);if(l.config.minDate&&n&&m(n,l.config.minDate,void 0!==t?t:!l.minDateHasTime)<0||l.config.maxDate&&n&&m(n,l.config.maxDate,void 0!==t?t:!l.maxDateHasTime)>0)return!1;if(!l.config.enable.length&&!l.config.disable.length)return!0;if(void 0===n)return!1;for(var a=l.config.enable.length>0,i=a?l.config.enable:l.config.disable,o=0,r=void 0;o<i.length;o++){if("function"==typeof(r=i[o])&&r(n))return a;if(r instanceof Date&&void 0!==n&&r.getTime()===n.getTime())return a;if("string"==typeof r&&void 0!==n){var c=l.parseDate(r,void 0,!0);return c&&c.getTime()===n.getTime()?a:!a}if("object"==typeof r&&void 0!==n&&r.from&&r.to&&n.getTime()>=r.from.getTime()&&n.getTime()<=r.to.getTime())return a}return!a}function W(e){var t=e.target===l._input,n=j(e.target),a=l.config.allowInput,i=l.isOpen&&(!a||!t),o=l.config.inline&&t&&!a;if(13===e.keyCode&&t){if(a)return l.setDate(l._input.value,!0,e.target===l.altInput?l.config.altFormat:l.config.dateFormat),e.target.blur();l.open()}else if(n||i||o){var r=!!l.timeContainer&&l.timeContainer.contains(e.target);switch(e.keyCode){case 13:r?ne():z(e);break;case 27:e.preventDefault(),l.close();break;case 8:case 46:t&&!l.config.allowInput&&l.clear();break;case 37:case 39:if(r)l.hourElement&&l.hourElement.focus();else if(e.preventDefault(),l.daysContainer){var c=39===e.keyCode?1:-1;e.ctrlKey?F(c,!0,!0):O(e.target.$i,c)}break;case 38:case 40:e.preventDefault();var d=40===e.keyCode?1:-1;l.daysContainer&&void 0!==e.target.$i?e.ctrlKey?(L(l.currentYear-d),O(e.target.$i,0)):r||O(e.target.$i,7*d):l.config.enableTime&&(!r&&l.hourElement&&l.hourElement.focus(),h(e),l._debouncedChange());break;case 9:e.target===l.hourElement?(e.preventDefault(),l.minuteElement.select()):e.target===l.minuteElement&&(l.secondElement||l.amPM)?(e.preventDefault(),void 0!==l.secondElement?l.secondElement.focus():void 0!==l.amPM&&l.amPM.focus()):e.target===l.secondElement&&l.amPM&&(e.preventDefault(),l.amPM.focus())}switch(e.key){case l.l10n.amPM[0].charAt(0):void 0!==l.amPM&&e.target===l.amPM&&(l.amPM.textContent=l.l10n.amPM[0],C(),ne());break;case l.l10n.amPM[1].charAt(0):void 0!==l.amPM&&e.target===l.amPM&&(l.amPM.textContent=l.l10n.amPM[1],C(),ne())}Q("onKeyDown",e)}}function J(e){if(1===l.selectedDates.length&&e.classList.contains("flatpickr-day")&&!e.classList.contains("disabled")&&void 0!==l.minRangeDate&&void 0!==l.maxRangeDate){for(var t=e.dateObj,n=l.parseDate(l.selectedDates[0],void 0,!0),a=Math.min(t.getTime(),l.selectedDates[0].getTime()),i=Math.max(t.getTime(),l.selectedDates[0].getTime()),o=!1,r=a;r<i;r+=p.DAY)if(!R(new Date(r))){o=!0;break}for(var c=function(r,c){var d=c.getTime(),s=d<l.minRangeDate.getTime()||d>l.maxRangeDate.getTime(),u=l.days.childNodes[r];if(s)return u.classList.add("notAllowed"),["inRange","startRange","endRange"].forEach(function(e){u.classList.remove(e)}),"continue";if(o&&!s)return"continue";["startRange","inRange","endRange","notAllowed"].forEach(function(e){u.classList.remove(e)});var f=Math.max(l.minRangeDate.getTime(),a),m=Math.min(l.maxRangeDate.getTime(),i);e.classList.add(t<l.selectedDates[0]?"startRange":"endRange"),n<t&&d===n.getTime()?u.classList.add("startRange"):n>t&&d===n.getTime()&&u.classList.add("endRange"),d>=f&&d<=m&&u.classList.add("inRange")},d=0,s=l.days.childNodes[d].dateObj;d<42;d++,s=l.days.childNodes[d]&&l.days.childNodes[d].dateObj)c(d,s)}}function K(){!l.isOpen||l.config.static||l.config.inline||U()}function B(e){return function(t){var n=l.config["_"+e+"Date"]=l.parseDate(t,l.config.dateFormat),a=l.config["_"+("min"===e?"max":"min")+"Date"];void 0!==n&&(l["min"===e?"minDateHasTime":"maxDateHasTime"]=n.getHours()>0||n.getMinutes()>0||n.getSeconds()>0),l.selectedDates&&(l.selectedDates=l.selectedDates.filter(function(e){return R(e)}),l.selectedDates.length||"min"!==e||y(n),ne()),l.daysContainer&&(q(),void 0!==n?l.currentYearElement[e]=n.getFullYear().toString():l.currentYearElement.removeAttribute(e),l.currentYearElement.disabled=!!a&&void 0!==n&&a.getFullYear()===n.getFullYear())}}function $(){"object"!=typeof l.config.locale&&void 0===w.l10ns[l.config.locale]&&l.config.errorHandler(new Error("flatpickr: invalid locale "+l.config.locale)),l.l10n=t({},w.l10ns.default,"object"==typeof l.config.locale?l.config.locale:"default"!==l.config.locale?w.l10ns[l.config.locale]:void 0),c.K="("+l.l10n.amPM[0]+"|"+l.l10n.amPM[1]+"|"+l.l10n.amPM[0].toLowerCase()+"|"+l.l10n.amPM[1].toLowerCase()+")",l.formatDate=u(l)}function U(e){if(void 0!==l.calendarContainer){Q("onPreCalendarPosition");var t=e||l._positionElement,n=Array.prototype.reduce.call(l.calendarContainer.children,function(e,t){return e+t.offsetHeight},0),a=l.calendarContainer.offsetWidth,i=l.config.position,o=t.getBoundingClientRect(),r=window.innerHeight-o.bottom,c="above"===i||"below"!==i&&r<n&&o.top>n,d=window.pageYOffset+o.top+(c?-n-2:t.offsetHeight+2);if(v(l.calendarContainer,"arrowTop",!c),v(l.calendarContainer,"arrowBottom",c),!l.config.inline){var s=window.pageXOffset+o.left,u=window.document.body.offsetWidth-o.right,f=s+a>window.document.body.offsetWidth;v(l.calendarContainer,"rightMost",f),l.config.static||(l.calendarContainer.style.top=d+"px",f?(l.calendarContainer.style.left="auto",l.calendarContainer.style.right=u+"px"):(l.calendarContainer.style.left=s+"px",l.calendarContainer.style.right="auto"))}}}function q(){l.config.noCalendar||l.isMobile||(A(),te(),P())}function z(e){e.preventDefault(),e.stopPropagation();var t=function e(t,n){return n(t)?t:t.parentNode?e(t.parentNode,n):void 0}(e.target,function(e){return e.classList&&e.classList.contains("flatpickr-day")&&!e.classList.contains("disabled")&&!e.classList.contains("notAllowed")});if(void 0!==t){var n=t,a=l.latestSelectedDateObj=new Date(n.dateObj.getTime()),i=a.getMonth()!==l.currentMonth&&"range"!==l.config.mode;if(l.selectedDateElem=n,"single"===l.config.mode)l.selectedDates=[a];else if("multiple"===l.config.mode){var o=ee(a);o?l.selectedDates.splice(parseInt(o),1):l.selectedDates.push(a)}else"range"===l.config.mode&&(2===l.selectedDates.length&&l.clear(),l.selectedDates.push(a),0!==m(a,l.selectedDates[0],!0)&&l.selectedDates.sort(function(e,t){return e.getTime()-t.getTime()}));if(C(),i){var r=l.currentYear!==a.getFullYear();l.currentYear=a.getFullYear(),l.currentMonth=a.getMonth(),r&&Q("onYearChange"),Q("onMonthChange")}if(P(),l.config.minDate&&l.minDateHasTime&&l.config.enableTime&&0===m(a,l.config.minDate)&&y(l.config.minDate),ne(),l.config.enableTime&&setTimeout(function(){return l.showTimeInput=!0},50),"range"===l.config.mode&&(1===l.selectedDates.length?(J(n),l._hidePrevMonthArrow=l._hidePrevMonthArrow||void 0!==l.minRangeDate&&l.minRangeDate>l.days.childNodes[0].dateObj,l._hideNextMonthArrow=l._hideNextMonthArrow||void 0!==l.maxRangeDate&&l.maxRangeDate<new Date(l.currentYear,l.currentMonth+1,1)):te()),i?l.selectedDateElem&&l.selectedDateElem.focus():O(n.$i,0),void 0!==l.hourElement&&setTimeout(function(){return void 0!==l.hourElement&&l.hourElement.select()},451),l.config.closeOnSelect){var c="single"===l.config.mode&&!l.config.enableTime,d="range"===l.config.mode&&2===l.selectedDates.length&&!l.config.enableTime;(c||d)&&(l._input.focus(),-1!==window.navigator.userAgent.indexOf("MSIE")||void 0!==navigator.msMaxTouchPoints?setTimeout(l.close,0):l.close())}I()}}l.parseDate=f({config:l.config,l10n:l.l10n}),l._handlers=[],l._bind=T,l._setHoursFromDate=y,l.changeMonth=F,l.changeYear=L,l.clear=function(e){void 0===e&&(e=!0);l.input.value="",l.altInput&&(l.altInput.value="");l.mobileInput&&(l.mobileInput.value="");l.selectedDates=[],l.latestSelectedDateObj=void 0,l.showTimeInput=!1,l.config.enableTime&&(void 0!==l.config.minDate?y(l.config.minDate):x(l.config.defaultHour,l.config.defaultMinute,l.config.defaultSeconds));l.redraw(),e&&Q("onChange")},l.close=function(){l.isOpen=!1,l.isMobile||(l.calendarContainer.classList.remove("open"),l._input.classList.remove("active"));Q("onClose")},l._createElement=D,l.destroy=function(){void 0!==l.config&&Q("onDestroy");for(var e=l._handlers.length;e--;){var t=l._handlers[e];t.element.removeEventListener(t.event,t.handler)}l._handlers=[],l.mobileInput?(l.mobileInput.parentNode&&l.mobileInput.parentNode.removeChild(l.mobileInput),l.mobileInput=void 0):l.calendarContainer&&l.calendarContainer.parentNode&&l.calendarContainer.parentNode.removeChild(l.calendarContainer);l.altInput&&(l.input.type="text",l.altInput.parentNode&&l.altInput.parentNode.removeChild(l.altInput),delete l.altInput);l.input&&(l.input.type=l.input._type,l.input.classList.remove("flatpickr-input"),l.input.removeAttribute("readonly"),l.input.value="");["_showTimeInput","latestSelectedDateObj","_hideNextMonthArrow","_hidePrevMonthArrow","__hideNextMonthArrow","__hidePrevMonthArrow","isMobile","isOpen","selectedDateElem","minDateHasTime","maxDateHasTime","days","daysContainer","_input","_positionElement","innerContainer","rContainer","monthNav","todayDateElem","calendarContainer","weekdayContainer","prevMonthNav","nextMonthNav","currentMonthElement","currentYearElement","navigationCurrentMonth","selectedDateElem","config"].forEach(function(e){try{delete l[e]}catch(e){}})},l.isEnabled=R,l.jumpToDate=_,l.open=function(e,t){void 0===t&&(t=l._input);if(l.isMobile)return e&&(e.preventDefault(),e.target&&e.target.blur()),setTimeout(function(){void 0!==l.mobileInput&&l.mobileInput.click()},0),void Q("onOpen");if(l._input.disabled||l.config.inline)return;var n=l.isOpen;l.isOpen=!0,n||(l.calendarContainer.classList.add("open"),l._input.classList.add("active"),Q("onOpen"),U(t))},l.redraw=q,l.set=function(e,t){null!==e&&"object"==typeof e?Object.assign(l.config,e):(l.config[e]=t,void 0!==G[e]&&G[e].forEach(function(e){return e()}));l.redraw(),_()},l.setDate=function(e,t,n){void 0===t&&(t=!1);void 0===n&&(n=l.config.dateFormat);if(0!==e&&!e)return l.clear(t);V(e,n),l.showTimeInput=l.selectedDates.length>0,l.latestSelectedDateObj=l.selectedDates[0],l.redraw(),_(),y(),ne(t),t&&Q("onChange")},l.toggle=function(){if(l.isOpen)return l.close();l.open()};var G={locale:[$]};function V(e,t){var n=[];if(e instanceof Array)n=e.map(function(e){return l.parseDate(e,t)});else if(e instanceof Date||"number"==typeof e)n=[l.parseDate(e,t)];else if("string"==typeof e)switch(l.config.mode){case"single":n=[l.parseDate(e,t)];break;case"multiple":n=e.split(l.config.conjunction).map(function(e){return l.parseDate(e,t)});break;case"range":n=e.split(l.l10n.rangeSeparator).map(function(e){return l.parseDate(e,t)})}else l.config.errorHandler(new Error("Invalid date supplied: "+JSON.stringify(e)));l.selectedDates=n.filter(function(e){return e instanceof Date&&R(e,!1)}),"range"===l.config.mode&&l.selectedDates.sort(function(e,t){return e.getTime()-t.getTime()})}function Z(e){return e.map(function(e){return"string"==typeof e||"number"==typeof e||e instanceof Date?l.parseDate(e,void 0,!0):e&&"object"==typeof e&&e.from&&e.to?{from:l.parseDate(e.from,void 0),to:l.parseDate(e.to,void 0)}:e}).filter(function(e){return e})}function Q(e,t){var n=l.config[e];if(void 0!==n&&n.length>0)for(var a=0;n[a]&&a<n.length;a++)n[a](l.selectedDates,l.input.value,l,t);"onChange"===e&&(l.input.dispatchEvent(X("change")),l.input.dispatchEvent(X("input")))}function X(e){var t=document.createEvent("Event");return t.initEvent(e,!0,!0),t}function ee(e){for(var t=0;t<l.selectedDates.length;t++)if(0===m(l.selectedDates[t],e))return""+t;return!1}function te(){l.config.noCalendar||l.isMobile||!l.monthNav||(l.currentMonthElement.textContent=g(l.currentMonth,l.config.shorthandCurrentMonth,l.l10n)+" ",l.currentYearElement.value=l.currentYear.toString(),l._hidePrevMonthArrow=void 0!==l.config.minDate&&(l.currentYear===l.config.minDate.getFullYear()?l.currentMonth<=l.config.minDate.getMonth():l.currentYear<l.config.minDate.getFullYear()),l._hideNextMonthArrow=void 0!==l.config.maxDate&&(l.currentYear===l.config.maxDate.getFullYear()?l.currentMonth+1>l.config.maxDate.getMonth():l.currentYear>l.config.maxDate.getFullYear()))}function ne(e){if(void 0===e&&(e=!0),!l.selectedDates.length)return l.clear(e);void 0!==l.mobileInput&&l.mobileFormatStr&&(l.mobileInput.value=void 0!==l.latestSelectedDateObj?l.formatDate(l.latestSelectedDateObj,l.mobileFormatStr):"");var t="range"!==l.config.mode?l.config.conjunction:l.l10n.rangeSeparator;l.input.value=l.selectedDates.map(function(e){return l.formatDate(e,l.config.dateFormat)}).join(t),void 0!==l.altInput&&(l.altInput.value=l.selectedDates.map(function(e){return l.formatDate(e,l.config.altFormat)}).join(t)),!1!==e&&Q("onValueUpdate")}function ae(e){e.preventDefault();var t=l.prevMonthNav.contains(e.target),n=l.nextMonthNav.contains(e.target);t||n?F(t?-1:1):e.target===l.currentYearElement?l.currentYearElement.select():"arrowUp"===e.target.className?l.changeYear(l.currentYear+1):"arrowDown"===e.target.className&&l.changeYear(l.currentYear-1)}return function(){l.element=l.input=e,l.isOpen=!1,function(){var n=["wrap","weekNumbers","allowInput","clickOpens","time_24hr","enableTime","noCalendar","altInput","shorthandCurrentMonth","inline","static","enableSeconds","disableMobile"],a=["onChange","onClose","onDayCreate","onDestroy","onKeyDown","onMonthChange","onOpen","onParseConfig","onReady","onValueUpdate","onYearChange","onPreCalendarPosition"],i=t({},r,JSON.parse(JSON.stringify(e.dataset||{}))),c={};l.config.parseDate=i.parseDate,l.config.formatDate=i.formatDate,Object.defineProperty(l.config,"enable",{get:function(){return l.config._enable||[]},set:function(e){l.config._enable=Z(e)}}),Object.defineProperty(l.config,"disable",{get:function(){return l.config._disable||[]},set:function(e){l.config._disable=Z(e)}}),!i.dateFormat&&i.enableTime&&(c.dateFormat=i.noCalendar?"H:i"+(i.enableSeconds?":S":""):w.defaultConfig.dateFormat+" H:i"+(i.enableSeconds?":S":"")),i.altInput&&i.enableTime&&!i.altFormat&&(c.altFormat=i.noCalendar?"h:i"+(i.enableSeconds?":S K":" K"):w.defaultConfig.altFormat+" h:i"+(i.enableSeconds?":S":"")+" K"),Object.defineProperty(l.config,"minDate",{get:function(){return l.config._minDate},set:B("min")}),Object.defineProperty(l.config,"maxDate",{get:function(){return l.config._maxDate},set:B("max")});var s=function(e){return function(t){l.config["min"===e?"_minTime":"_maxTime"]=l.parseDate(t,"H:i")}};Object.defineProperty(l.config,"minTime",{get:function(){return l.config._minTime},set:s("min")}),Object.defineProperty(l.config,"maxTime",{get:function(){return l.config._maxTime},set:s("max")}),Object.assign(l.config,c,i);for(var u=0;u<n.length;u++)l.config[n[u]]=!0===l.config[n[u]]||"true"===l.config[n[u]];for(var u=a.length;u--;)void 0!==l.config[a[u]]&&(l.config[a[u]]=o(l.config[a[u]]||[]).map(d));for(var u=0;u<l.config.plugins.length;u++){var f=l.config.plugins[u](l)||{};for(var m in f)~a.indexOf(m)?l.config[m]=o(f[m]).map(d).concat(l.config[m]):void 0===i[m]&&(l.config[m]=f[m])}l.isMobile=!l.config.disableMobile&&!l.config.inline&&"single"===l.config.mode&&!l.config.disable.length&&!l.config.enable.length&&!l.config.weekNumbers&&/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent),Q("onParseConfig")}(),$(),l.input=l.config.wrap?e.querySelector("[data-input]"):e,l.input?(l.input._type=l.input.type,l.input.type="text",l.input.classList.add("flatpickr-input"),l._input=l.input,l.config.altInput&&(l.altInput=D(l.input.nodeName,l.input.className+" "+l.config.altInputClass),l._input=l.altInput,l.altInput.placeholder=l.input.placeholder,l.altInput.disabled=l.input.disabled,l.altInput.required=l.input.required,l.altInput.tabIndex=l.input.tabIndex,l.altInput.type="text",l.input.type="hidden",!l.config.static&&l.input.parentNode&&l.input.parentNode.insertBefore(l.altInput,l.input.nextSibling)),l.config.allowInput||l._input.setAttribute("readonly","readonly"),l._positionElement=l.config.positionElement||l._input):l.config.errorHandler(new Error("Invalid input element specified")),function(){l.selectedDates=[],l.now=new Date;var e=l.config.defaultDate||l.input.value;e&&V(e,l.config.dateFormat);var t=l.selectedDates.length?l.selectedDates[0]:l.config.minDate&&l.config.minDate.getTime()>l.now.getTime()?l.config.minDate:l.config.maxDate&&l.config.maxDate.getTime()<l.now.getTime()?l.config.maxDate:l.now;l.currentYear=t.getFullYear(),l.currentMonth=t.getMonth(),l.selectedDates.length&&(l.latestSelectedDateObj=l.selectedDates[0]),void 0!==l.config.minTime&&(l.config.minTime=l.parseDate(l.config.minTime,"H:i")),void 0!==l.config.maxTime&&(l.config.maxTime=l.parseDate(l.config.maxTime,"H:i")),l.minDateHasTime=!!l.config.minDate&&(l.config.minDate.getHours()>0||l.config.minDate.getMinutes()>0||l.config.minDate.getSeconds()>0),l.maxDateHasTime=!!l.config.maxDate&&(l.config.maxDate.getHours()>0||l.config.maxDate.getMinutes()>0||l.config.maxDate.getSeconds()>0),Object.defineProperty(l,"showTimeInput",{get:function(){return l._showTimeInput},set:function(e){l._showTimeInput=e,l.calendarContainer&&v(l.calendarContainer,"showTimeInput",e),l.isOpen&&U()}})}(),l.utils={getDaysInMonth:function(e,t){return void 0===e&&(e=l.currentMonth),void 0===t&&(t=l.currentYear),1===e&&(t%4==0&&t%100!=0||t%400==0)?29:l.l10n.daysInMonth[e]}},l.isMobile||function(){var e=window.document.createDocumentFragment();if(l.calendarContainer=D("div","flatpickr-calendar"),l.calendarContainer.tabIndex=-1,!l.config.noCalendar){if(e.appendChild(function(){var e=window.document.createDocumentFragment();l.monthNav=D("div","flatpickr-month"),l.prevMonthNav=D("span","flatpickr-prev-month"),l.prevMonthNav.innerHTML=l.config.prevArrow,l.currentMonthElement=D("span","cur-month");var t=b("cur-year",{tabindex:"-1"});return l.currentYearElement=t.childNodes[0],l.config.minDate&&l.currentYearElement.setAttribute("data-min",l.config.minDate.getFullYear().toString()),l.config.maxDate&&(l.currentYearElement.setAttribute("data-max",l.config.maxDate.getFullYear().toString()),l.currentYearElement.disabled=!!l.config.minDate&&l.config.minDate.getFullYear()===l.config.maxDate.getFullYear()),l.nextMonthNav=D("span","flatpickr-next-month"),l.nextMonthNav.innerHTML=l.config.nextArrow,l.navigationCurrentMonth=D("div","flatpickr-current-month"),l.navigationCurrentMonth.appendChild(l.currentMonthElement),l.navigationCurrentMonth.appendChild(t),e.appendChild(l.prevMonthNav),e.appendChild(l.navigationCurrentMonth),e.appendChild(l.nextMonthNav),l.monthNav.appendChild(e),Object.defineProperty(l,"_hidePrevMonthArrow",{get:function(){return l.__hidePrevMonthArrow},set:function(e){l.__hidePrevMonthArrow!==e&&(l.prevMonthNav.style.display=e?"none":"block"),l.__hidePrevMonthArrow=e}}),Object.defineProperty(l,"_hideNextMonthArrow",{get:function(){return l.__hideNextMonthArrow},set:function(e){l.__hideNextMonthArrow!==e&&(l.nextMonthNav.style.display=e?"none":"block"),l.__hideNextMonthArrow=e}}),te(),l.monthNav}()),l.innerContainer=D("div","flatpickr-innerContainer"),l.config.weekNumbers){var t=function(){l.calendarContainer.classList.add("hasWeeks");var e=D("div","flatpickr-weekwrapper");e.appendChild(D("span","flatpickr-weekday",l.l10n.weekAbbreviation));var t=D("div","flatpickr-weeks");return e.appendChild(t),{weekWrapper:e,weekNumbers:t}}(),i=t.weekWrapper,o=t.weekNumbers;l.innerContainer.appendChild(i),l.weekNumbers=o,l.weekWrapper=i}l.rContainer=D("div","flatpickr-rContainer"),l.rContainer.appendChild(A()),l.daysContainer||(l.daysContainer=D("div","flatpickr-days"),l.daysContainer.tabIndex=-1),P(),l.rContainer.appendChild(l.daysContainer),l.innerContainer.appendChild(l.rContainer),e.appendChild(l.innerContainer)}l.config.enableTime&&e.appendChild(function(){l.calendarContainer.classList.add("hasTime"),l.config.noCalendar&&l.calendarContainer.classList.add("noCalendar"),l.timeContainer=D("div","flatpickr-time"),l.timeContainer.tabIndex=-1;var e=D("span","flatpickr-time-separator",":"),t=b("flatpickr-hour");l.hourElement=t.childNodes[0];var i=b("flatpickr-minute");if(l.minuteElement=i.childNodes[0],l.hourElement.tabIndex=l.minuteElement.tabIndex=-1,l.hourElement.value=n(l.latestSelectedDateObj?l.latestSelectedDateObj.getHours():l.config.time_24hr?l.config.defaultHour:function(e){switch(e%24){case 0:case 12:return 12;default:return e%12}}(l.config.defaultHour)),l.minuteElement.value=n(l.latestSelectedDateObj?l.latestSelectedDateObj.getMinutes():l.config.defaultMinute),l.hourElement.setAttribute("data-step",l.config.hourIncrement.toString()),l.minuteElement.setAttribute("data-step",l.config.minuteIncrement.toString()),l.hourElement.setAttribute("data-min",l.config.time_24hr?"0":"1"),l.hourElement.setAttribute("data-max",l.config.time_24hr?"23":"12"),l.minuteElement.setAttribute("data-min","0"),l.minuteElement.setAttribute("data-max","59"),l.timeContainer.appendChild(t),l.timeContainer.appendChild(e),l.timeContainer.appendChild(i),l.config.time_24hr&&l.timeContainer.classList.add("time24hr"),l.config.enableSeconds){l.timeContainer.classList.add("hasSeconds");var o=b("flatpickr-second");l.secondElement=o.childNodes[0],l.secondElement.value=n(l.latestSelectedDateObj?l.latestSelectedDateObj.getSeconds():l.config.defaultSeconds),l.secondElement.setAttribute("data-step",l.minuteElement.getAttribute("data-step")),l.secondElement.setAttribute("data-min",l.minuteElement.getAttribute("data-min")),l.secondElement.setAttribute("data-max",l.minuteElement.getAttribute("data-max")),l.timeContainer.appendChild(D("span","flatpickr-time-separator",":")),l.timeContainer.appendChild(o)}return l.config.time_24hr||(l.amPM=D("span","flatpickr-am-pm",l.l10n.amPM[a((l.latestSelectedDateObj?l.hourElement.value:l.config.defaultHour)>11)]),l.amPM.title=l.l10n.toggleTitle,l.amPM.tabIndex=-1,l.timeContainer.appendChild(l.amPM)),l.timeContainer}()),v(l.calendarContainer,"rangeMode","range"===l.config.mode),v(l.calendarContainer,"animate",l.config.animate),l.calendarContainer.appendChild(e);var r=void 0!==l.config.appendTo&&l.config.appendTo.nodeType;if((l.config.inline||l.config.static)&&(l.calendarContainer.classList.add(l.config.inline?"inline":"static"),l.config.inline&&(!r&&l.element.parentNode?l.element.parentNode.insertBefore(l.calendarContainer,l._input.nextSibling):void 0!==l.config.appendTo&&l.config.appendTo.appendChild(l.calendarContainer)),l.config.static)){var c=D("div","flatpickr-wrapper");l.element.parentNode&&l.element.parentNode.insertBefore(c,l.element),c.appendChild(l.element),l.altInput&&c.appendChild(l.altInput),c.appendChild(l.calendarContainer)}l.config.static||l.config.inline||(void 0!==l.config.appendTo?l.config.appendTo:window.document.body).appendChild(l.calendarContainer)}(),function(){if(l.config.wrap&&["open","close","toggle","clear"].forEach(function(e){Array.prototype.forEach.call(l.element.querySelectorAll("[data-"+e+"]"),function(t){return T(t,"click",l[e])})}),l.isMobile)!function(){var e=l.config.enableTime?l.config.noCalendar?"time":"datetime-local":"date";l.mobileInput=D("input",l.input.className+" flatpickr-mobile"),l.mobileInput.step=l.input.getAttribute("step")||"any",l.mobileInput.tabIndex=1,l.mobileInput.type=e,l.mobileInput.disabled=l.input.disabled,l.mobileInput.required=l.input.required,l.mobileInput.placeholder=l.input.placeholder,l.mobileFormatStr="datetime-local"===e?"Y-m-d\\TH:i:S":"date"===e?"Y-m-d":"H:i:S",l.selectedDates.length&&(l.mobileInput.defaultValue=l.mobileInput.value=l.formatDate(l.selectedDates[0],l.mobileFormatStr)),l.config.minDate&&(l.mobileInput.min=l.formatDate(l.config.minDate,"Y-m-d")),l.config.maxDate&&(l.mobileInput.max=l.formatDate(l.config.maxDate,"Y-m-d")),l.input.type="hidden",void 0!==l.altInput&&(l.altInput.type="hidden");try{l.input.parentNode&&l.input.parentNode.insertBefore(l.mobileInput,l.input.nextSibling)}catch(e){}T(l.mobileInput,"change",function(e){l.setDate(e.target.value,!1,l.mobileFormatStr),Q("onChange"),Q("onClose")})}();else{var e=i(K,50);l._debouncedChange=i(I,M),l.daysContainer&&!/iPhone|iPad|iPod/i.test(navigator.userAgent)&&T(l.daysContainer,"mouseover",function(e){"range"===l.config.mode&&J(e.target)}),T(window.document.body,"keydown",W),l.config.static||T(l._input,"keydown",W),l.config.inline||l.config.static||T(window,"resize",e),void 0!==window.ontouchstart&&T(window.document,"touchstart",H),T(window.document,"mousedown",k(H)),T(window.document,"focus",H,{capture:!0}),!0===l.config.clickOpens&&(T(l._input,"focus",l.open),T(l._input,"mousedown",k(l.open))),void 0!==l.daysContainer&&(T(l.monthNav,"mousedown",k(ae)),T(l.monthNav,["keyup","increment"],E),T(l.daysContainer,"mousedown",k(z))),void 0!==l.timeContainer&&void 0!==l.minuteElement&&void 0!==l.hourElement&&(T(l.timeContainer,["input","increment"],h),T(l.timeContainer,"mousedown",k(S)),T(l.timeContainer,["input","increment"],l._debouncedChange,{passive:!0}),T([l.hourElement,l.minuteElement],["focus","click"],function(e){return e.target.select()}),void 0!==l.secondElement&&T(l.secondElement,"focus",function(){return l.secondElement&&l.secondElement.select()}),void 0!==l.amPM&&T(l.amPM,"mousedown",k(function(e){h(e),I()})))}}(),(l.selectedDates.length||l.config.noCalendar)&&(l.config.enableTime&&y(l.config.noCalendar?l.latestSelectedDateObj||l.config.minDate:void 0),ne(!1)),l.showTimeInput=l.selectedDates.length>0||l.config.noCalendar,void 0!==l.weekWrapper&&void 0!==l.daysContainer&&(l.calendarContainer.style.visibility="hidden",l.calendarContainer.style.display="block",l.calendarContainer.style.width=l.daysContainer.offsetWidth+l.weekWrapper.offsetWidth+"px",l.calendarContainer.style.visibility="visible",l.calendarContainer.style.display=null);var c=/^((?!chrome|android).)*safari/i.test(navigator.userAgent);!l.isMobile&&c&&U(),Q("onReady")}(),l}function y(e,t){for(var n=Array.prototype.slice.call(e),a=[],i=0;i<n.length;i++){var o=n[i];try{if(null!==o.getAttribute("data-fp-omit"))continue;void 0!==o._flatpickr&&(o._flatpickr.destroy(),o._flatpickr=void 0),o._flatpickr=C(o,t||{}),a.push(o._flatpickr)}catch(e){console.error(e)}}return 1===a.length?a[0]:a}"undefined"!=typeof HTMLElement&&(HTMLCollection.prototype.flatpickr=NodeList.prototype.flatpickr=function(e){return y(this,e)},HTMLElement.prototype.flatpickr=function(e){return y([this],e)}),w=function(e,t){return e instanceof NodeList?y(e,t):y("string"==typeof e?window.document.querySelectorAll(e):[e],t)},"object"==typeof window&&(window.flatpickr=w),w.defaultConfig=h,w.l10ns={en:t({},s),default:t({},s)},w.localize=function(e){w.l10ns.default=t({},w.l10ns.default,e)},w.setDefaults=function(e){w.defaultConfig=t({},w.defaultConfig,e)},w.parseDate=f({}),w.formatDate=u({}),w.compareDates=m,"undefined"!=typeof jQuery&&(jQuery.fn.flatpickr=function(e){return y(this,e)}),Date.prototype.fp_incr=function(e){return new Date(this.getFullYear(),this.getMonth(),this.getDate()+("string"==typeof e?parseInt(e,10):e))};var x=w;e.default=x,Object.defineProperty(e,"__esModule",{value:!0})});$(document).ready(function(){
	$(".flatpickr").flatpickr({
		dateFormat: "d.m.Y"
	});
});

//Recaptcha validation
$(document).ready(function(){
	if ($(".g-recaptcha").length > 0){
		//$('<script src="https://www.google.com/recaptcha/api.js" defer></script>').appendTo($("head"));
	}
	$(".g-recaptcha").on("click",function(event){
		event.preventDefault();
		grecaptcha.execute();
	});

	function onSubmit(token) {
	    alert('thanks ');
	}
});

//Google Maps
	function loadmap() {
      $('[data-google-map]').each(function(){
            initGmaps('googlemap_'+$(this).attr('data-google-map'), $(this).attr('data-google-map-address'), $(this).attr('data-google-map-options'), $(this).html());
            $(this).fadeIn();
        });
    }

	function initGmaps(id, address,options, label){

        var geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(0,0);
        options = $.parseJSON(options);
        console.log(options);
        var map = new google.maps.Map(
            document.getElementById(id),
            options
        );

        geocoder.geocode( { 'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
              map.setCenter(results[0].geometry.location);
            } else {
              alert('Geocode was not successful for the following reason: ' + status);
            }

            var infowindow = new google.maps.InfoWindow({
              content: label,
              position: results[0].geometry.location
            });

            infowindow.open(map);
        });
    }
	$(document).ready(function(){
	    if ($(".google-map").length > 0){
	 		$('<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCbrDquBmMxiRMZz6itPir8xKX7HLa7xZE&callback=loadmap"></script>').appendTo($("body"));
	 	}
	});


//Table

$(".element table").each(function(){
    $(this).addClass("uk-table uk-table-striped uk-table-small uk-table-responsive");
    if ($(this).width() > $(window).width()){
        divContainer = $("<div></div>");
        divContainer.addClass("uk-overflow-auto");
        $(this).detach().appendTo(divContainer);
    }
});


//Parent Block

    $(".parentblock .uk-accordion").each(function(){
        $(this).find("h3").each(function(){
            var html = $(this).html();
            var a = $('<a></a>');
            a.addClass("uk-accordion-title uk-width-1-1").html(html);
            $(this).html(a);
        });
        var expandedBlocks = $(this).attr('data-element-expanded');
        expandedBlocks = $.parseJSON(expandedBlocks);
        $.each(expandedBlocks, function(index, value){
            console.log(value);
            $("#e"+value).addClass("uk-open");
        });
    });
 
