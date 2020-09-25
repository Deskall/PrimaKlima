    <% if activeCart.exists %>
    <% include MobileCartContainer %>
    <% end_if %>
    <% if $PageLevel > 1 %>
    <div class="breadcrumbs-container">
        <div class="uk-container">
            $BreadCrumbs
        </div>
    </div>
    <% end_if %>

   
<section class="uk-section uk-section-small">
    <div class="uk-container">
            <h1>$Title</h1>
            <form class="search-form uk-flex uk-flex-between" method="GET" action="{$Link}SearchForm">
                <input type="text" class="uk-input" minlength="3" required name="Search" placeholder="<%t Search.PLACEHOLDER 'Suche auf dieser Website...' %>" />
                <button type="submit"><i data-uk-icon="search"></i></button>
            </form>
            <div class="uk-margin-top faq-container">
                <h3>Häufig gestellte Fragen</h3>
                <ul data-uk-accordion>
                    <% loop activeFAQS %>
                    <li>
                        <a class="uk-accordion-title uk-text-truncate">$Title</a>
                        <div class="uk-accordion-content">
                           <% if Summary %>
                           $Summary
                           <% else %>
                           $Text.limitWordCount(100)
                           <% end_if %>
                        </div>
                    </li>
                    <% end_loop %>
                </ul>
            </div>
            <hr>
            <p>Finden Sie <a href="$FAQPageLink">hier</a> alle Antworten für häufig gestellte Fragen über Dienste, Geräte, Zahlungsarten und Vieles mehr.</p>
    </div>
</section>

$ElementalArea
    