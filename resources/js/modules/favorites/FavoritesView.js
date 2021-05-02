class FavoritesView {
    static toggleIcon(node) {
        if (node.style.backgroundImage === `url("${location.origin}/images/heart-icon.svg")`) {
            node.style.backgroundImage = `url("${location.origin}/images/active-heart-icon.svg")`;
        } else {
            node.style.backgroundImage = `url("${location.origin}/images/heart-icon.svg")`;
        }
    }
}

export default FavoritesView;
