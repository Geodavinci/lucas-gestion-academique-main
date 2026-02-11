import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Index({ students, filters }) {
    const form = useForm({
        filiere: filters.filiere || '',
        niveau: filters.niveau || '',
        matricule: filters.matricule || '',
    });

    return (
        <AuthenticatedLayout>
            <Head title="Étudiants" />
            <div className="mx-auto max-w-7xl px-4 py-8">
                <div className="flex items-center justify-between mb-6">
                    <div>
                        <h1 className="text-2xl font-semibold">Étudiants</h1>
                        <p className="text-sm text-slate-600">Liste des étudiants.</p>
                    </div>
                    <Link href={route('students.create')} className="rounded bg-slate-900 text-white px-4 py-2 text-sm">
                        Ajouter
                    </Link>
                </div>

                <form
                    className="mb-4 flex flex-wrap items-end gap-3"
                    onSubmit={(e) => {
                        e.preventDefault();
                        form.get(route('students.index'));
                    }}
                >
                    <div>
                        <label className="block text-sm font-medium">Filière</label>
                        <input
                            className="mt-1 w-56 rounded border-slate-300"
                            value={form.data.filiere}
                            onChange={(e) => form.setData('filiere', e.target.value)}
                        />
                    </div>
                    <div>
                        <label className="block text-sm font-medium">Niveau</label>
                        <input
                            className="mt-1 w-40 rounded border-slate-300"
                            value={form.data.niveau}
                            onChange={(e) => form.setData('niveau', e.target.value)}
                        />
                    </div>
                    <div>
                        <label className="block text-sm font-medium">Matricule</label>
                        <input
                            className="mt-1 w-40 rounded border-slate-300"
                            value={form.data.matricule}
                            onChange={(e) => form.setData('matricule', e.target.value)}
                        />
                    </div>
                    <button className="rounded border border-slate-300 px-3 py-2 text-sm">Filtrer</button>
                </form>

                <div className="bg-white rounded border border-slate-200">
                    <table className="w-full text-sm">
                        <thead className="bg-slate-50 text-slate-600">
                            <tr>
                                <th className="text-left px-4 py-3">Matricule</th>
                                <th className="text-left px-4 py-3">Nom</th>
                                <th className="text-left px-4 py-3">Filière</th>
                                <th className="text-right px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {students.data.map((s) => (
                                <tr key={s.id} className="border-t">
                                    <td className="px-4 py-3">{s.matricule}</td>
                                    <td className="px-4 py-3">{s.nom} {s.prenom}</td>
                                    <td className="px-4 py-3">{s.filiere}</td>
                                    <td className="px-4 py-3 text-right space-x-2">
                                        <Link href={route('students.show', s.id)} className="text-slate-700">Voir</Link>
                                        <Link href={route('students.edit', s.id)} className="text-slate-700">Éditer</Link>
                                    </td>
                                </tr>
                            ))}
                            {students.data.length === 0 && (
                                <tr className="border-t">
                                    <td className="px-4 py-6 text-center text-slate-500" colSpan="4">Aucun étudiant.</td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
