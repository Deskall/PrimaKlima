$ElementalArea
<section class="uk-section uk-section-small">
    <div class="uk-container $SiteConfig.ContainerSize">
        <div id="Content" class="searchResults">
            <div class="dk-text-content uk-text-lead">
                <p ><%t SearchPage.QUERY 'Sie suchten nach' %> &quot;{$Query.XML}&quot;</p>
            </div>
            <% if $Results %>
               <ul class="uk-list uk-list-divider">
               <% loop $Results %>
                    <li>
                        <% if $BaseClass == 'SilverStripe\CMS\Model\SiteTree' %>
                            <h3><% if $MenuTitle %>$MenuTitle<% else %><% if $Title %>$Title.LimitWordCount<% else %>$Parent.MenuTitle.LimitWordCount<% end_if %><% end_if %></h3>
                            <p>$Content.ContextSummary(200,$Query.XML,true)</p>
                        <% else_if $BaseClass == 'DNADesign\Elemental\Models\BaseElement' %>
                            <% with $getPage %><h3><% if $MenuTitle %>$MenuTitle.LimitWordCount<% else %><% if $Title %>$Title.LimitWordCount<% else %>$Parent.MenuTitle.LimitWordCount<% end_if %><% end_if %></h3><% end_with %>
                            <% if Title %><strong>$Title.LimitWordCount</strong><% end_if %>
                            <p>$Content.ContextSummary(200,$Query.XML,true)</p>
                        <% else %>
                            <% if $Title %><h3>$Title.LimitWordCount</h3><% end_if %>
                            <p>$Content.ContextSummary(200,$Query.XML,true)</p>
                        <% end_if %>
                        <div>
                            <a href="$Link" class="uk-link" data-uk-icon="chevron-right"><%t SearchPage.Read 'Seite anzeigen' %></a>
                        </div>
                    </li>
                <% end_loop %>
            </ul>
            <% else %>
                <p><%t SearchPage.NORESULT 'Ihre Suche ergab keine Treffer' %>.</p> 
            <% end_if %>
            <% if $Results.MoreThanOnePage %>    
            <ul class="uk-pagination uk-flex-center" data-uk-margin>
                <li><a href="$Results.PrevLink" title="<%t SearchPage.PREV 'Zurück' %>"><span data-uk-pagination-previous></span></a></li>
                <% loop $Results.Pages %>
                <% if $CurrentBool %><li class="uk-active"><span>$PageNum</span></li>
                <% else %><li><a href="$Link" title="<%t SearchPage.SEEPAGE 'Seite anzeigen' %>">$PageNum</a></li>
                <% end_if %>
                <% end_loop %>
                <li><a href="$Results.NextLink" title="<%t SearchPage.NEXT 'Weiter' %>"><span data-uk-pagination-next></span></a></li>
            </ul>
            <% end_if %>
            $clearSearchresultSession
        </div>
    </div>
</section>
