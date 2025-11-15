<style>
    .ads-page {
        padding: 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    .ads-section {
        margin-bottom: 3rem;
    }

    .ads-section__header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .ads-section__title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #111;
        margin: 0;
    }

    .ads-section__link {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        color: #2563eb;
        text-decoration: none;
        font-weight: 500;
        transition: color .2s ease;
    }

    .ads-section__link svg {
        width: 16px;
        height: 16px;
    }

    .ads-section__link:hover {
        color: #1d4ed8;
    }

    .ads-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 1.5rem;
    }

    .ad-card,
    .ad-card__link {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .ad-card {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .ad-card__link {
        text-decoration: none;
        color: inherit;
    }

    .ad-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 30px rgba(0, 0, 0, 0.12);
    }

    .ad-card__image-wrapper {
        position: relative;
        padding-top: 65%;
        background: #f3f4f6;
    }

    .ad-card__image-wrapper img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .ad-card__body {
        padding: 1rem;
        display: flex;
        flex-direction: column;
        gap: .5rem;
    }

    .ad-card__title {
        font-size: 1rem;
        font-weight: 600;
        color: #111;
        margin: 0;
        line-height: 1.4;
    }

    .ad-card__meta,
    .ad-card__price {
        font-size: .9rem;
        color: #6b7280;
        display: flex;
        align-items: center;
        gap: .5rem;
        flex-wrap: wrap;
    }

    .ad-card__price strong {
        font-size: 1rem;
        font-weight: 700;
        color: #111827;
    }

    .ads-empty-state {
        text-align: center;
        padding: 4rem 1rem;
        color: #6b7280;
        font-size: 1.1rem;
    }

    @media (max-width: 768px) {
        .ads-page {
            padding: 1.5rem 1rem;
        }

        .ads-section__header {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
