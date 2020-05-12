<% if $Locales %><% loop $Locales %><% if $LinkingMode != 'invalid' %>
<link rel="alternate" hreflang="$LocaleRFC1766.ATT" href="{$AbsoluteLink.ATT}<% if $LocaleRFC1766.ATT == "de-DE" %>kategorie<% else_if $LocaleRFC1766.ATT == "en-US" %>category<% else %>categoria<% end_if %>/ %>" />
<% end_if %><% end_loop %><% end_if %>