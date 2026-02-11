import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Index({ recus, filters }) {
    const form = useForm({ search: filters.search || '', date: filters.date || '' });

    return (
        <AuthenticatedLayout>
            <Head title="Reçus" />
            <div className="mx-auto max-w-7xl px-4 py-8">
                <div className="flex items-center justify-between mb-6">
                    <div>
                        <h1 className="text-2xl font-semibold">Reçus</h1>
                        <p className="text-sm text-slate-600">Reçus de paiement.</p>
                    </div>
                    <div className="flex gap-2">
                        <Link href={route('dashboard')} className="rounded border border-slate-300 px-4 py-2 text-sm">Retour Dashboard</Link>
                        <Link href={route('recu-paiements.create')} className="rounded bg-slate-900 text-white px-4 py-2 text-sm">Ajouter</Link>
                    </div>
                </div>

                <form
                    className="mb-4 flex flex-wrap items-end gap-3"
                    onSubmit={(e) => {
                        e.preventDefault();
                        form.get(route('recu-paiements.index'));
                    }}
                >
                    <div>
                        <label className="block text-sm font-medium">Recherche</label>
                        <input className="mt-1 w-56 rounded border-slate-300" value={form.data.search} onChange={(e) => form.setData('search', e.target.value)} />
                    </div>
                    <div>
                        <label className="block text-sm font-medium">Date</label>
                        <input type="date" className="mt-1 w-40 rounded border-slate-300" value={form.data.date} onChange={(e) => form.setData('date', e.target.value)} />
                    </div>
                    <button className="rounded border border-slate-300 px-3 py-2 text-sm">Filtrer</button>
                </form>

                <div className="bg-white rounded border border-slate-200">
                    <table className="w-full text-sm">
                        <thead className="bg-slate-50 text-slate-600">
                            <tr>
                                <th className="text-left px-4 py-3">Numéro</th>
                                <th className="text-left px-4 py-3">Étudiant</th>
                                <th className="text-left px-4 py-3">Montant</th>
                                <th className="text-left px-4 py-3">Date</th>
                                <th className="text-right px-4 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {recus.data.map((r) => (
                                <tr key={r.id} className="border-t">
                                    <td className="px-4 py-3">{r.numero_recu}</td>
                                    <td className="px-4 py-3">{r.student?.nom} {r.student?.prenom}</td>
                                    <td className="px-4 py-3">{r.montant}</td>
                                    <td className="px-4 py-3">{r.date_paiement}</td>
                                    <td className="px-4 py-3 text-right space-x-2">
                                        <Link href={route('recu-paiements.show', r.id)} className="text-slate-700">Voir</Link>
                                        <Link href={route('recu-paiements.edit', r.id)} className="text-slate-700">Éditer</Link>
                                    </td>
                                </tr>
                            ))}
                            {recus.data.length === 0 && (
                                <tr className="border-t"><td className="px-4 py-6 text-center text-slate-500" colSpan="5">Aucun reçu.</td></tr>
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
