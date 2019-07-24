var $collectionHolder;
var $collectionHolderPicture;
var $message;
var $addMusicButton = $('<button class="add_music_button">Add a musicfile</button>');
var $addPictureButton = $('<button class="add_music_button">Add a Picture</button>');
var $newLinkLi = $('<li></li>').append($addMusicButton);
var $newLinkLiPicture = $('<li></li>').append($addPictureButton);


jQuery(document).ready(function () {
    // Get the ul that holds the collection of tags
    $collectionHolder = $('div#musicfile');
    $collectionHolderPicture = $('div#picturefile');

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);
    $collectionHolderPicture.append($newLinkLiPicture);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);
    $collectionHolderPicture.data('index', $collectionHolderPicture.find(':input').length);

    var index = $collectionHolder.find(':input').length;
    var indexpicture = $collectionHolderPicture.find(':input').length;

    $addMusicButton.on('click', function (e) {
        // add a new tag form (see next code block)
        addMusicForm($collectionHolder, $newLinkLi);
    });

    $addPictureButton.on('click', function (e) {
        // add a new tag form (see next code block)
        addMusicForm($collectionHolderPicture, $newLinkLiPicture);
    });

    if (index === 1) {
        addMusicForm($collectionHolder, $newLinkLi);
    } else {
        $collectionHolder.children('div').each(function () {
        });
    }

    if (indexpicture === 1) {
        addMusicForm($collectionHolderPicture, $newLinkLiPicture);
    } else {
        $collectionHolderPicture.children('div').each(function () {
        });
    }
});

function addMusicForm($collectionHolder, $newLinkLi) {

    var prototype = $collectionHolder.data('prototype');
    var index = $collectionHolder.data('index');
    var newForm = prototype;

    newForm = newForm.replace(/__name__/g, index);
    $collectionHolder.data('index', index + 1);

    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);

    addMusicFormDeleteLink($newFormLi);
}

function addMusicFormDeleteLink($newFormLi) {
    var $removeFormButton = $('<button type="button">Delete</button>');
    $newFormLi.append($removeFormButton);

    $removeFormButton.on('click', function (e) {
        // remove the li for the tag form
        $newFormLi.remove();
    });
}

