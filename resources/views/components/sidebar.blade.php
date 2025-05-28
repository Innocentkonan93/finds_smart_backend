<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <a href="{{ route('index') }}" class="sidebar-logo">
            <img src="{{ asset('assets/images/logo.png') }}" alt="site logo" class="light-logo">
            <img src="{{ asset('assets/images/logo-light.png') }}" alt="site logo" class="dark-logo">
            <img src="{{ asset('assets/images/logo-icon.png') }}" alt="site logo" class="logo-icon">
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span>Dashboard</span>
                 </a>
            </li>
            <li class="sidebar-menu-group-title">Application</li>
            <li>
                  <a href="{{ route('usersList') }}">
                    <iconify-icon icon="hugeicons:user-group-02" class="menu-icon"></iconify-icon>
                    <span>Utilisateurs</span>
                </a>
            </li>
            <li>
                <a href="{{ route('clientsList') }}">
                  <iconify-icon icon="hugeicons:user-group-02" class="menu-icon"></iconify-icon>
                  <span>Clients</span>
              </a>
            </li>
            <li>
                <a href="{{ route('professionalsList') }}">
                    <iconify-icon icon="hugeicons:graduate-male" class="menu-icon"></iconify-icon>
                    <span>Professionnels</span>
                </a>
            </li>
            <li>
                <a href="{{ route('documentsList') }}">
                    <iconify-icon icon="hugeicons:files-01" class="menu-icon"></iconify-icon>
                    <span>Documents</span>
                </a>
            </li>
            <li>
                <a href="{{ route('jobsList') }}">
                    <iconify-icon icon="hugeicons:work" class="menu-icon"></iconify-icon>
                    <span>Metiers</span>
                </a>
            </li>
            <li>
                <a href="{{ route('adsList') }}">
                    <iconify-icon icon="hugeicons:shopping-bag-add" class="menu-icon"></iconify-icon>
                    <span>Annonces</span>
                </a>
            </li>
            <li>
                <a href="{{ route('ordersList') }}">
                    <iconify-icon icon="hugeicons:shopping-cart-check-02" class="menu-icon"></iconify-icon>
                    <span>Commandes</span>
                </a>
            </li>
            <li>
                <a  href="{{ route('servicesList') }}">
                    <iconify-icon icon="hugeicons:robot-02" class="menu-icon"></iconify-icon>
                    <span>Services</span>
                </a>
            </li>

            <li>
                <a  href="{{ route('packsList') }}">
                    <iconify-icon icon="hugeicons:package" class="menu-icon"></iconify-icon>
                    <span>Packs</span>
                </a>
            </li>
            <li>
                <a  href="{{ route('transactionsList') }}">
                    <iconify-icon icon="hugeicons:money-send-square" class="menu-icon"></iconify-icon>
                    <span>Transactions</span>
                </a>
            </li>
            <li class="sidebar-menu-group-title">Mentions légales</li>
            <li>
                <a  href="{{ route('editTermsCondition') }}">
                    <iconify-icon icon="hugeicons:file-locked" class="menu-icon"></iconify-icon>
                    <span>Termes & Conditions</span>
                </a>
            </li>
            <li>
                <a  href="{{ route('editPrivacyPolicy') }}">
                    <iconify-icon icon="hugeicons:shield-user" class="menu-icon"></iconify-icon>
                    <span>Confidentialité</span>
                </a>
            </li>
        </ul>
    </div>
</aside>