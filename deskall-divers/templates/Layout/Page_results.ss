<div id="Content" class="searchResults">
    <section class="uk-section">
        <div class="uk-container">
        
        <h1><%t Page.SEARCHRESULTS 'Suchergebnisse' %></h1>





        <div class="dk-text-content uk-text-lead">
            <p ><%t SearchPage.QUERY 'Sie suchten nach' %> &quot;{$Query.XML}&quot;</p>
        </div>






        <% if $Results %>
           <ul class="uk-list uk-list-divider">
           <% loop $Results %>
                <li>
                        <% if $BaseClass == 'SilverStripe\CMS\Model\SiteTree' %>
                                    <h3><% if $MenuTitle %>$MenuTitle<% else %><% if $Title %>$Title.LimitWordCount<% else %>$Parent.MenuTitle.LimitWordCount<% end_if %><% end_if %></h3>
                                    <p>$Content.ContextSummary(100,$Query.XML,true)</p>
                                    <a href="$Link" class="uk-link" data-uk-icon="chevron-right"><%t SearchPage.Read 'weiter lesen' %></a>

                     <% else_if $BaseClass == 'DNADesign\Elemental\Models\BaseElement' %>
                                <% with $getPage %><h3><% if $MenuTitle %>$MenuTitle.LimitWordCount<% else %><% if $Title %>$Title.LimitWordCount<% else %>$Parent.MenuTitle.LimitWordCount<% end_if %><% end_if %></h3><% end_with %>
                                <% if Title %><strong>$Title.LimitWordCount</strong><% end_if %>
                                <p>$Content.ContextSummary(100,$Query.XML,true)</p>
                                <a href="$Link" class="uk-link" data-uk-icon="chevron-right"><%t SearchPage.Read 'weiter lesen' %></a>
                        
                    <% end_if %>
                </li>
            <% end_loop %>
        </ul>
        <% else %>
            
                    <p><%t SearchPage.NORESULT 'Ihre Suche ergab keine Treffer' %>.</p> 
        <% end_if %>


    <% if $Results.MoreThanOnePage %>    
        <ul class="uk-pagination" uk-margin>
          
            <li><a href="$Results.PrevLink" title="<%t SearchPage.PREV 'Zurück' %>"><span class="uk-pagination uk-pagination-previous"></span></a></li>
            
            <% loop $Results.Pages %>
                <li><a href="$Link" title="<%t SearchPage.SEEPAGE 'Seite anzeigen' %>" class="<% if $CurrentBool %>uk-active<% end_if %>">
                $PageNum</a></li>
            <% end_loop %>
          
            <li><a href="$Results.NextLink" title="<%t SearchPage.NEXT 'Weiter' %>"><span class="uk-pagination uk-pagination-next"></span></a></li>
            
        </ul>
    <% end_if %>



$clearSearchresultSession

    </div>



      <%-- <% include NavigationSidebar %> --%>

        </div>
    </section>
</div>