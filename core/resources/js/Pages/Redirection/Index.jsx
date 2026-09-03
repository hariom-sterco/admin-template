import React, { useEffect, useRef, useState } from "react";
import { ToastContainer, toast } from "react-toastify";
import { debounce } from "lodash";
import { router, usePage } from "@inertiajs/react";
import TableHeader from "@/Components/TableHeader";
import { Link, useForm } from "@inertiajs/react";
import { useDeleteConfirmation } from "@/hooks/useDeleteConfirmation";
import DeleteConfirmationModal from "@/Components/DeleteConfirmationModal";
import Pagination from "@/Components/Pagination";

export default function index({ redirections, searchTerm }) {
    const [query, setQuery] = useState(searchTerm || "");

    const { flash } = usePage().props;

    const { processing } = useForm();

    const truncateText = (text, length = 100) => {
        if (!text) return "—";
        return text.length > length ? text.substring(0, length) + "..." : text;
    };

    const { modalRef, itemToDelete, confirmDelete, handleDelete } =
        useDeleteConfirmation("redirection.destroy");

    useEffect(() => {
        const delaySearch = debounce(() => {
            router.get(
                "redirection",
                { search: query },
                { preserveState: true, replace: true },
            );
        }, 300);

        delaySearch();
        return () => delaySearch.cancel();
    }, [query]);

    useEffect(() => {
        if (flash.success) {
            toast.success(flash.success);
        }
    }, [flash.success]);

    return (
        <>
            <h1 className="text-muted">Redirection</h1>
            <ToastContainer />

            <div className="card">
                <TableHeader
                    searchValue={query}
                    onSearchChange={setQuery}
                    searchPlaceholder="Search By Redirection Link..."
                    addButtonText="Add Redirection"
                    addButtonRoute={route("redirection.create")}
                    searchColClass="col-md-6 col-12"
                    filterColClass=""
                    buttonColClass="col-md-6 col-12"
                />

                <div className="table-responsive text-nowrap">
                    <table className="table table-hover my-table">
                        <thead>
                            <tr>
                                <th>OLD URL</th>
                                <th>NEW URL</th>
                                <th>STATUS</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {redirections.data.map((item) => (
                                <tr key={item.id}>
                                    <td>
                                        <i className="bx bx-link bx-sm me-3"></i>
                                        {truncateText(item.old_url)}
                                    </td>
                                    <td>
                                        <i className="bx bx-link bx-sm me-3"></i>
                                        {truncateText(item.new_url)}
                                    </td>

                                    <td>
                                        <span
                                            className={`badge ${item.status ? "bg-label-success" : "bg-label-danger"}`}
                                        >
                                            {item.status
                                                ? "Active"
                                                : "Inactive"}
                                        </span>
                                    </td>

                                    <td>
                                        <div className="d-flex align-items-center gap-1">
                                            <div className="dropdown">
                                                <button
                                                    className="btn btn-outline-secondary p-1 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown"
                                                >
                                                    <i className="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div className="dropdown-menu">
                                                    <Link
                                                        className="dropdown-item"
                                                        href={route(
                                                            "redirection.edit",
                                                            item.id,
                                                        )}
                                                    >
                                                        <i className="bx bx-edit-alt me-1"></i>{" "}
                                                        Edit
                                                    </Link>
                                                    <a
                                                        onClick={() =>
                                                            confirmDelete(
                                                                item.id,
                                                                {
                                                                    name: item.name,
                                                                },
                                                            )
                                                        }
                                                        className="dropdown-item"
                                                        href="#"
                                                    >
                                                        <i className="bx bx-trash me-1"></i>{" "}
                                                        Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>

            <DeleteConfirmationModal
                modalRef={modalRef}
                title="Confirm Deletion"
                message="Are you sure you want to delete this redirection?"
                itemName={itemToDelete?.name}
                onConfirm={() => handleDelete()}
                processing={processing}
            />

            {/* Pagination */}
            {redirections.links.length > 3 && (
                <div className="row m-2">
                    <div className="col-md-4">
                        <p className="text-dark mb-0 mt-2">
                            Showing {redirections.from ?? 0} to{" "}
                            {redirections.to ?? 0} of {redirections.total}{" "}
                            entries
                        </p>
                    </div>
                    <div className="col-md-8">
                        <div className="float-end">
                            <Pagination
                                links={redirections.links}
                                query={query}
                            />
                        </div>
                    </div>
                </div>
            )}
        </>
    );
}
