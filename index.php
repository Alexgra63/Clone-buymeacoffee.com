<?php
// Set page title
$page_title = "Home";

// Include header
include_once 'includes/header.php';
?>

<section class="hero">
    <div class="container">
        <h1>Fund your creative work</h1>
        <p>Accept support. Start a membership. Setup a shop. It's easier than you think.</p>
        <a href="<?php echo BASE_URL; ?>/signup.php" class="cta-button">Start my page</a>
        <p class="hero-subtitle">It's free and takes less than a minute!</p>
    </div>
</section>

<section class="features">
    <div class="container">
        <h2 class="section-title">Support</h2>
        <h3 class="section-subtitle">Give your audience an easy way to say thanks.</h3>
        <p class="section-description">Buy Me a Coffee makes supporting fun and easy. In just a couple of taps, your fans can make the payment (buy you a coffee) and leave a message.</p>

        <div class="support-demo">
            <div class="demo-left">
                <div class="demo-card">
                    <div class="demo-header">
                        <h4>Buy Juliet a coffee</h4>
                        <span class="demo-count">1351</span>
                    </div>
                    <div class="demo-input">
                        <input type="text" placeholder="Say something nice...">
                        <button>Support $3</button>
                    </div>
                    <div class="demo-supporters">
                        <h5>Recent Supporters</h5>
                        <div class="supporter-item">
                            <div class="supporter-avatar">
                                <img src="https://ext.same-assets.com/1865676449/509642580.png" alt="Supporter">
                            </div>
                            <div class="supporter-info">
                                <p><strong>Cathy G</strong> bought a coffee.</p>
                                <div class="creator-reply">
                                    <img src="https://ext.same-assets.com/1865676449/509642580.png" alt="Creator">
                                    <p>Thanks Cathy!</p>
                                </div>
                            </div>
                        </div>
                        <div class="supporter-item">
                            <div class="supporter-avatar">
                                <img src="https://ext.same-assets.com/1865676449/509642580.png" alt="Supporter">
                            </div>
                            <div class="supporter-info">
                                <p><strong>Tony Steel</strong> bought 3 coffees.</p>
                                <p>Have a coffee or three, cream AND sugar :)</p>
                                <div class="creator-reply">
                                    <img src="https://ext.same-assets.com/1865676449/509642580.png" alt="Creator">
                                    <p>Thanks Tony!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="features alt-bg">
    <div class="container">
        <h2 class="section-title">Memberships</h2>
        <h3 class="section-subtitle">Start a membership for your biggest fans.</h3>
        <p class="section-description">Earn a recurring income by accepting monthly or yearly subscriptions. Share exclusive content, or just give them a way to support your work on an ongoing basis.</p>

        <div class="membership-demo">
            <div class="membership-tiers">
                <div class="membership-tier">
                    <h4>Pro membership</h4>
                    <div class="tier-price">$15/month</div>
                    <ul class="tier-benefits">
                        <li>Support me on a monthly basis</li>
                        <li>Email alert for new posts</li>
                        <li>Exclusive posts and messages</li>
                    </ul>
                    <button class="tier-button">Join</button>
                </div>
                <div class="membership-tier">
                    <h4>Basic membership</h4>
                    <div class="tier-price">$5/month</div>
                    <ul class="tier-benefits">
                        <li>33% OFF all my eBooks & services</li>
                        <li>Access to members-only Discord</li>
                        <li>Exclusive posts and messages</li>
                    </ul>
                    <button class="tier-button">Join</button>
                </div>
                <div class="membership-tier">
                    <h4>Advanced membership</h4>
                    <div class="tier-price">$25/month</div>
                    <ul class="tier-benefits">
                        <li>Monthly printable journal pages</li>
                        <li>Email alert for new posts</li>
                        <li>Work in progress updates</li>
                    </ul>
                    <button class="tier-button">Join</button>
                </div>
            </div>
            <div class="membership-stats">
                <div class="stat-box">
                    <div class="stat-number">286</div>
                    <div class="stat-label">Members</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">$1,500</div>
                    <div class="stat-label">Earned this month</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="features">
    <div class="container">
        <h2 class="section-title">Shop</h2>
        <h3 class="section-subtitle">Introducing Shop, the creative way to sell.</h3>
        <p class="section-description">The things you'd like to sell probably do not belong in a Shopify store. Shop is designed from the ground up with creators in mind. Whether it's a 1-1 Zoom call, art commissions, or an ebook, Shop is for you.</p>

        <div class="shop-demo">
            <div class="product-card">
                <div class="product-image">
                    <span class="product-format">.PDF</span>
                    <img src="https://ext.same-assets.com/2256122184/3810376176.svg" alt="Product">
                </div>
                <div class="product-info">
                    <h4>Design E-book</h4>
                    <div class="product-price">$20</div>
                    <div class="product-rating">
                        <img src="https://ext.same-assets.com/2256122184/2335248737.svg" alt="Rating">
                        <span>4.9 (36)</span>
                    </div>
                </div>
                <button class="product-button">Buy</button>
            </div>
            <div class="product-stats">
                <div class="stat-item">
                    <div class="stat-value">One-tap checkout</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">753</div>
                    <div class="stat-label">Sales</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">One-tap checkout</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">Liked it? give rating</div>
                    <div class="stat-subtitle">4 star</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">$244</div>
                    <div class="stat-label">Earnings</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="features alt-bg">
    <div class="container">
        <h2 class="section-title">Posts, audio & email</h2>
        <h3 class="section-subtitle">Publish your best work</h3>
        <p class="section-description">Buy Me a Coffee makes it easy to publish free and exclusive content. Try different formats such as audio, and make it members-only to drive more memberships.</p>

        <div class="posts-demo">
            <img src="https://cdn.buymeacoffee.com/assets/img/homepage/images/posts_mobile_v8.png" alt="Posts on mobile" class="posts-image">
        </div>
    </div>
</section>

<section class="features">
    <div class="container">
        <h2 class="section-title">Designed for creators, not for businesses.</h2>

        <div class="benefits-grid">
            <div class="benefit-item">
                <h3>We don't call them "customers" or transactions. They are your supporters.</h3>
            </div>
            <div class="benefit-item">
                <h3>You have 100% ownership of your supporters. We never email them, and you can export the list any time you like.</h3>
            </div>
            <div class="benefit-item">
                <h3>You get to talk to a human for help, or if you just like some advice to hit the ground running.</h3>
            </div>
            <div class="benefit-item">
                <h3>You get paid instantly to your bank account. No more 30-day delays.</h3>
            </div>
        </div>
    </div>
</section>

<section class="features alt-bg">
    <div class="container">
        <h2 class="section-title">Make 20% or more, compared to other platforms.</h2>

        <div class="advantages-grid">
            <div class="advantage-item">
                <h3>Not just a membership</h3>
                <p>Creators who previously only used Patreon noticed a massive increase in earnings after accepting one-off payments.</p>
            </div>
            <div class="advantage-item">
                <h3>6 new languages</h3>
                <p>We now support Spanish, French, Italian, German and Ukrainian—making it easier for your global audience to support you.</p>
            </div>
            <div class="advantage-item">
                <h3>Email marketing</h3>
                <p>Instead of paying separately for email marketing tools like Mailchimp, send unlimited emails to your fans for free.</p>
            </div>
            <div class="advantage-item">
                <h3>Being friendly converts</h3>
                <p>ICYMI, we make it simple and fun for your supporters. While you cannot put a number on feelings, it tends to show on the results.</p>
            </div>
            <div class="advantage-item">
                <h3>Your privacy comes first</h3>
                <p>Receive fan support safely without disclosing your identity or address. We'll do the heavy-lifting.</p>
            </div>
        </div>
    </div>
</section>

<?php
// Include footer
include_once 'includes/footer.php';
?>
