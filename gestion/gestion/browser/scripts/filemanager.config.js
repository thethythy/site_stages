{
    "options": {
        "culture": "fr",
        "lang": "php",
        "defaultViewMode": "list",
        "autoload": true,
        "showFullPath": true,
        "showTitleAttr": false,
        "browseOnly": false,
        "showConfirmation": true,
        "showThumbs": false,
        "generateThumbnails": false,
        "searchBox": true,
        "listFiles": true,
        "fileSorting": "default",
        "chars_only_latin": true,
        "dateFormat": "d M Y H:i",
        "serverRoot": true,
        "fileRoot": "documents/",
        "relPath": false,
        "logger": false,
        "capabilities": ["select", "download", "rename", "move", "delete", "replace"],
        "plugins": []
    },
    "security": {
        "uploadPolicy": "DISALLOW_ALL",
        "uploadRestrictions": [
            "jpg",
            "jpeg",
            "gif",
            "png",
            "svg",
            "txt",
            "pdf",
            "odp",
            "ods",
            "odt",
            "rtf",
            "doc",
            "docx",
            "xls",
            "xlsx",
            "ppt",
            "pptx",
            "ogv",
            "mp4",
            "webm",
            "m4v",
            "ogg",
            "mp3",
            "wav"
        ]
    },
    "upload": {
        "overwrite": false,
        "imagesOnly": false,
        "fileSizeLimit": 16
    },
    "exclude": {
        "unallowed_files": [
            ".htaccess"
        ],
        "unallowed_dirs": [
            "_thumbs",
            ".CDN_ACCESS_LOGS",
            "cloudservers"
        ],
        "unallowed_files_REGEXP": "/^\\./uis",
        "unallowed_dirs_REGEXP": "/^\\./uis"
    },
    "images": {
        "imagesExt": [
            "jpg",
            "jpeg",
            "gif",
            "png",
            "svg"
        ],
        "resize": {
        	"enabled":false,
        	"maxWidth": 1280,
            "maxHeight": 1024
        }
    },
    "videos": {
        "showVideoPlayer": false,
        "videosExt": [
            "ogv",
            "mp4",
            "webm",
            "m4v"
        ],
        "videosPlayerWidth": 400,
        "videosPlayerHeight": 222
    },
    "audios": {
        "showAudioPlayer": false,
        "audiosExt": [
            "ogg",
            "mp3",
            "wav"
        ]
    },
    "pdfs": {
        "showPDFViewer": true,
        "pdfsViewerWidth": 600,
        "pdfsViewerHeight": 400
    },
    "extras": {
        "extra_js": [],
        "extra_js_async": true
    },
    "icons": {
        "path": "images/fileicons/",
        "directory": "_Open.png",
        "default": "default.png"
    }
}