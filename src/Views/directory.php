<style>
    #markdoc-container {
        display: grid;
        grid-template-columns: 1fr 3fr;
        gap: 2rem;
        overflow-y: hidden;
    }

    nav ul {
        list-style: none;
    }

    nav ul li a {
        text-decoration: none;

    }

    main {
        overflow-y: auto;
    }
</style>

<div id="markdoc-container">

    <aside>
        <nav>
            <?= $this->menu ?>
        </nav>
    </aside>

    <main>
        <?php foreach ($this->menu->getItems() as $name => $item) : ?>
            <section id="<?= $item->getFilename() ?>">
                <?= $this->getFile($item->getFilename()) ?>
            </section>
        <?php endforeach; ?>
    </main>
</div>

<script>
    // (function() {
    //     window.onhashchange = function(event) {
    //         window.scrollTo({
    //             top: document.querySelector(window.location.hash).
    //         });
    //     }
    // })();
</script>