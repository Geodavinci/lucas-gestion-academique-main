import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';

export default function Profile({ student }) {
    return (
        <AuthenticatedLayout>
            <Head title="Mon dossier" />
            <div className="mx-auto max-w-5xl px-4 py-8">
                <div className="flex items-center justify-between mb-6">
                    <div>
                        <h1 className="text-2xl font-semibold">Mon dossier</h1>
                        <p className="text-sm text-slate-600">Informations personnelles et détails de soutenance.</p>
                    </div>
                    <Link href={route('student.profile.pdf')} className="rounded bg-slate-900 text-white px-4 py-2 text-sm">Télécharger PDF</Link>
                </div>

                {!student && (
                    <div className="rounded border border-amber-200 bg-amber-50 px-4 py-3 text-amber-800">
                        Aucune fiche étudiant n'est liée à votre compte.
                    </div>
                )}

                {student && (
                    <>
                        <div className="bg-white rounded border border-slate-200 p-6 mb-6">
                            <h2 className="text-lg font-semibold mb-4">Informations</h2>
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div><span className="text-slate-500">Matricule:</span> {student.matricule}</div>
                                <div><span className="text-slate-500">Nom:</span> {student.nom} {student.prenom}</div>
                                <div><span className="text-slate-500">Email:</span> {student.email}</div>
                                <div><span className="text-slate-500">Téléphone:</span> {student.telephone}</div>
                                <div><span className="text-slate-500">Filière:</span> {student.filiere}</div>
                                <div><span className="text-slate-500">Niveau:</span> {student.niveau}</div>
                            </div>
                        </div>

                        <div className="bg-white rounded border border-slate-200 p-6 mb-6">
                            <h2 className="text-lg font-semibold mb-4">Mémoires</h2>
                            {(student.memoires || []).length > 0 ? (
                                <ul className="space-y-2 text-sm">
                                    {student.memoires.map((m) => (
                                        <li key={m.id} className="flex items-center justify-between">
                                            <span>{m.titre} ({m.annee})</span>
                                            {m.fichier_pdf ? (
                                                <a href={route('memoires.download', m.id)} className="text-slate-700">Voir PDF</a>
                                            ) : (
                                                <span className="text-slate-500">Aucun fichier</span>
                                            )}
                                        </li>
                                    ))}
                                </ul>
                            ) : (
                                <p className="text-sm text-slate-500">Aucun mémoire.</p>
                            )}
                        </div>

                        <div className="bg-white rounded border border-slate-200 p-6 mb-6">
                            <h2 className="text-lg font-semibold mb-4">Soutenances</h2>
                            {(student.soutenances || []).length > 0 ? (
                                <div className="text-sm">{student.soutenances[0].date_soutenance}</div>
                            ) : (
                                <p className="text-sm text-slate-500">Aucune soutenance.</p>
                            )}
                        </div>

                        <div className="bg-white rounded border border-slate-200 p-6">
                            <h2 className="text-lg font-semibold mb-4">Notes</h2>
                            {(student.grades || []).length > 0 ? (
                                <table className="w-full text-sm">
                                    <thead className="bg-slate-50 text-slate-600">
                                        <tr>
                                            <th className="text-left px-4 py-3">Cours</th>
                                            <th className="text-left px-4 py-3">Code</th>
                                            <th className="text-left px-4 py-3">Note</th>
                                            <th className="text-left px-4 py-3">Session</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {student.grades.map((g) => (
                                            <tr key={g.id} className="border-t">
                                                <td className="px-4 py-3">{g.course?.nom}</td>
                                                <td className="px-4 py-3">{g.course?.code}</td>
                                                <td className="px-4 py-3">{g.note}</td>
                                                <td className="px-4 py-3">{g.session}</td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                            ) : (
                                <p className="text-sm text-slate-500">Aucune note disponible.</p>
                            )}
                        </div>
                    </>
                )}
            </div>
        </AuthenticatedLayout>
    );
}
