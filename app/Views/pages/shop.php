<section class="shop">
  <div class="shop__container">
    <header>
      <h1>Shopping</h1>
      <div class="shopping">
        <i class="fa-solid fa-bag-shopping"></i>
        <span class="quantity">0</span>
      </div>
    </header>

    <div class="list"></div>
  </div>

  <div class="card">
    <h1>Card</h1>
    <ul class="listCard"></ul>
    <div class="checkOut">
      <div class="total">0</div>
      <div class="closeShopping">Close</div>
    </div>
  </div>
</section>

<!-- Tombol WhatsApp & Shop -->
<div class="floating-buttons">
  <a target="_blank" href="<?= esc('https://wa.me/' . $kontak['no_hp']) ?>" class="btn-floating btn-whatsapp" title='Hubungi Kami'>
    <i class="ri-whatsapp-fill"></i>
  </a>
  <a target="_blank" href="https://maps.app.goo.gl/Cu246KuzoBk2Dvph8" class="btn-floating btn-shop" title="Shop">
    <i class="ri-shopping-bag-fill"></i>
  </a>
</div>