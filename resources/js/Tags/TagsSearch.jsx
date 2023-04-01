import React from "react";
import { useState, useEffect } from "react";
import { customAxios } from "../config";

const TagsSearch = () => {
    const [tags, setTags] = useState([]);

    // get initial tags
    useEffect(() => {
        customAxios
            .get("/tags")
            .then(function (result) {
                setTags(result.data.data.tags);
            })
            .catch(function (err) {
                console.log(err);
            });
    }, [setTags]);

    return (
        <div>
            {tags.map((tag) => (
                <div key={tag.slug} className="hover:bg-slate-100 px-2 py-1 rounded-lg">
                    {tag.title}
                </div>
            ))}
        </div>
    );
};

export default TagsSearch;
