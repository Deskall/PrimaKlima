<script id="products-template" type="text/x-handlebars-template">
    {{#if products}}
        {{#each products}}
            <div class="product">
                <div data-uk-grid>
                    <div class="uk-width-1-4@m">
                        <a href="{{link}}"><img src="{{img}}" alt="{{name}}" /></a>
                    </div>
                    <div class="uk-width-3-4@m">
                        <h3>{{name}}</h3>
                        {{#if description}}
                        <p class="description">{{description}}</p>
                        {{else}}
                            {{#if features}}
                            <p class="description">{{features}}</p>
                            {{/if}}
                            {{#if number}}
                            <p class="description">{{number}}</p>
                            {{/if}}
                        {{/if}}
                        <div class="uk-text-right">
                            <a href="{{link}}">{{linkText}}<span class="icon ion-ios-arrow-right"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        {{/each}}
    {{else}}
        <div class="product"><h3><%t ProductOverviewPage.NOPRODUCTS "Keine Produkte gefunden" %></h3></div>
    {{/if}}
</script>