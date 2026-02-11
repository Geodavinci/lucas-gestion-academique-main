import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Show({ student, memoires, recus }) {
    return (
        <AuthenticatedLayout>
            <Head title="Détails étudiant" />
            <div className="mx-auto max-w-7xl px-4 py-8">
                <div className="flex items-center justify-between mb-6">
                    <div>
                        <h1 className="text-2xl font-semibold">{student.nom} {student.prenom}</h1>
                        <p className="text-sm text-slate-600">Matricule: {student.matricule}</p>
                    </div>
                    <div className="flex gap-3">
                        <Link href={route('students.memoires', student.id)} className="rounded bg-slate-900 text-white px-4 py-2 text-sm">Voir mémoires</Link>
                        <Link href={route('soutenances.createForStudent', student.id)} className="rounded bg-emerald-600 text-white px-4 py-2 text-sm">Ajouter soutenance</Link>
                        <Link href={route('students.edit', student.id)} className="rounded border border-slate-300 px-4 py-2 text-sm">Modifier</Link>
                    </div>
                </div>

                <div className="bg-white rounded border border-slate-200 shadow-sm p-6 mb-8">
                    <dl className="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <dt className="text-slate-500">Email</dt>
                            <dd className="font-medium">{student.email || '-'}</dd>
                        </div>
                        <div>
                            <dt className="text-slate-500">Téléphone</dt>
                            <dd className="font-medium">{student.telephone || '-'}</dd>
                        </div>
                        <div>
                            <dt className="text-slate-500">Filière</dt>
                            <dd className="font-medium">{student.filiere}</dd>
                        </div>
                        <div>
                            <dt className="text-slate-500">Niveau</dt>
                            <dd className="font-medium">{student.niveau}</dd>
                        </div>
                    </dl>
                </div>

                <div className="flex items-center justify-between mb-4">
                    <h2 className="text-xl font-semibold">Mémoires</h2>
                    <Link href={route('memoires.create')} className="rounded bg-slate-900 text-white px-4 py-2 text-sm">Ajouter un mémoire</Link>
                </div>

                <div className="bg-white rounded border border-slate-200 shadow-sm mb-8">
                    <table className="w-full text-sm">
                        <thead className="bg-slate-50">
                            <tr>
                                <th className="text-left px-4 py-3">Titre</th>
                                <th className="text-left px-4 py-3">Année</th>
                                <th className="text-right px-4 py-3">Fichier</th>
                            </tr>
                        </thead>
                        <tbody>
                            {memoires.map((m) => (
                                <tr key={m.id} className="border-t">
                                    <td className="px-4 py-3">{m.titre}</td>
                                    <td className="px-4 py-3">{m.annee}</td>
                                    <td className="px-4 py-3 text-right">
                                        <a href={route('memoires.download', m.id)} className="text-slate-700">Voir PDF</a>
                                    </td>
                                </tr>
                            ))}
                            {memoires.length === 0 && (
                                <tr className="border-t">
                                    <td className="px-4 py-6 text-center text-slate-500" colSpan="3">Aucun mémoire trouvé.</td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>

                <div className="flex items-center justify-between mb-4">
                    <h2 className="text-xl font-semibold">Reçus de paiement</h2>
                    <Link href={route('recu-paiements.create')} className="rounded bg-slate-900 text-white px-4 py-2 text-sm">Ajouter un reçu</Link>
                </div>

                <div className="bg-white rounded border border-slate-200 shadow-sm">
                    <table className="w-full text-sm">
                        <thead className="bg-slate-50">
                            <tr>
                                <th className="text-left px-4 py-3">Numéro</th>
                                <th className="text-left px-4 py-3">Montant</th>
                                <th className="text-left px-4 py-3">Date</th>
                                <th className="text-right px-4 py-3">Fichier</th>
                            </tr>
                        </thead>
                        <tbody>
                            {recus.map((r) => (
                                <tr key={r.id} className="border-t">
                                    <td className="px-4 py-3">{r.numero_recu}</td>
                                    <td className="px-4 py-3">{r.montant}</td>
                                    <td className="px-4 py-3">{r.date_paiement}</td>
                                    <td className="px-4 py-3 text-right">
                                        {r.fichier_pdf ? (
                                            <a href={route('recu-paiements.download', r.id)} className="text-slate-700">Voir PDF</a>
                                        ) : (
                                            '-'
                                        )}
                                    </td>
                                </tr>
                            ))}
                            {recus.length === 0 && (
                                <tr className="border-t">
                                    <td className="px-4 py-6 text-center text-slate-500" colSpan="4">Aucun reçu enregistré.</td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
