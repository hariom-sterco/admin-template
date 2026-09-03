import { useForm } from "@inertiajs/react";
import React, { useRef, useState } from "react";
import RedirectionForm from "./partials/RedirectionForm";
import FormLayout from "../../Components/FormLayout";
import FormActions from "@/Components/FormActions";

const RedirectionCreate = ({ redirection }) => {
    const [keywordInput, setKeywordInput] = useState("");
    const [searchTermsInput, setSearchTermsInput] = useState("");
    const { data, setData, post, progress, errors, processing } = useForm({
        _method: "PUT",
        old_url: redirection.old_url || "",
        new_url: redirection.new_url || "",
        status: redirection.status || "1",
        search_terms: redirection.search_terms || [],
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route("redirection.update", redirection.id));
    };

    const addKeyword = () => {
        if (
            keywordInput.trim() &&
            !data.keywords.includes(keywordInput.trim())
        ) {
            setData("keywords", [...data.keywords, keywordInput.trim()]);
            setKeywordInput("");
        }
    };

    const handleKeyPress = (e) => {
        if (e.key === "Enter") {
            e.preventDefault();
            addKeyword();
        }
    };

    const addSearchTerm = () => {
        if (
            searchTermsInput.trim() &&
            !data.search_terms.includes(searchTermsInput.trim())
        ) {
            setData("search_terms", [
                ...data.search_terms,
                searchTermsInput.trim(),
            ]);
            setSearchTermsInput("");
        }
    };

    const removeSearchTerm = (index) => {
        const updatedSearchTerms = data.search_terms.filter(
            (_, i) => i !== index,
        );
        setData("search_terms", updatedSearchTerms);
    };

    const handleSearchTermKeyPress = (e) => {
        if (e.key === "Enter") {
            e.preventDefault();
            addSearchTerm();
        }
    };

    const handleDataChange = (field, value) => {
        setData(field, value);
    };

    return (
        <>
            <FormLayout
                title="Update Redirection"
                subtitle="Modify an existing redirection"
                onSubmit={handleSubmit}
                processing={processing}
            >
                <RedirectionForm
                    data={data}
                    errors={errors}
                    processing={processing}
                    onDataChange={handleDataChange}
                    handleKeyPress={handleKeyPress}
                    progress={progress}
                    setData={setData}
                >
                    <FormActions
                        processing={processing}
                        submitText="Update Redirection"
                        cancelText="Cancel"
                        submitButtonProps={{
                            variant: "primary",
                        }}
                    />
                </RedirectionForm>
            </FormLayout>
        </>
    );
};

export default RedirectionCreate;
