<?php

namespace App\Controller;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Contacto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
final class ContactoController extends AbstractController
{

    #[Route('/contacto/{codigo}', name: 'contacto', requirements: ['codigo' => '[0-9]+'])]
    public function ficha(ManagerRegistry $doctrine, int $codigo = 1): Response
    {

        $repositorio = $doctrine->getRepository(Contacto::class);
        $contacto = $repositorio->find($codigo);

        return $this->render('ficha_contacto.html.twig', [
            'contacto' => $contacto
        ]);
    }

    #[Route('/contacto/nuevo/{nombre}/{telefono}/{email}', name: 'nuevo-con-datos')]
    public function nuevoConDatos(
        ManagerRegistry $doctrine,
        Request $request,
        string $nombre,
        string $telefono,
        string $email,
    ) {
        // Crear un nuevo contacto
        $contacto = new Contacto();

        // Asignar los datos del contacto
        $contacto->setNombre($nombre);
        $contacto->setTelefono($telefono);
        $contacto->setEmail($email);

        // Guardar el contacto
        $entityManager = $doctrine->getManager();
        $entityManager->persist($contacto);
        $entityManager->flush();

        // Redirigir a la ficha del contacto
        return $this->redirectToRoute('contacto', ["codigo" => $contacto->getId()]);
    }
    #[Route('/contacto/empieza/{letra}', name: 'empieza-por')]
    public function empieza(
        ManagerRegistry $doctrine,
        string $letra
    ): Response {
        $repositorio = $doctrine->getRepository(Contacto::class);

        $contactos = $repositorio->startsWith($letra);

        return $this->render('lista_contactos.html.twig', [
            'contactos' => $contactos,
            'letra' => $letra
        ]);
    }
    #[Route('/contacto/modificar/{id}/{nombre}', name: 'modificar')]

    public function modificar(
        ManagerRegistry $doctrine,
        int $id,
        string $nombre
    ): Response {

        $contacto = $doctrine->getRepository(Contacto::class)->find($id);

        $contacto->setNombre($nombre);



        $entityManager = $doctrine->getManager();

        $entityManager->persist($contacto);

        $entityManager->flush();



        // Devolvemos como respuesta el html

        return $this->redirectToRoute('contacto', ['codigo' => $contacto->getId()]);

    }
    #[Route('/contacto/borrar/{codigo}', name: 'borrar')]
    public function borrar(ManagerRegistry $doctrine, int $codigo)
    {
        // Obtenemos el contacto por id
        $contacto = $doctrine->getRepository(Contacto::class)->find($codigo);
        if ($contacto) {
            // Obtenemos el manager
            $entityManager = $doctrine->getManager();
            try {
                // Eliminamos el contacto
                $entityManager->remove($contacto);
                // Hacemos flush
                $entityManager->flush();
                // Redirigimos a inicio para que se actualice la lista
                return $this->redirectToRoute('inicio');
            } catch (Exception $e) {
                // En una aplicación real, deberiamos mostrar una página de error y hacer el log del error.
                error_log("Error insertando objeto" . $e->getMessage());
                return new Response("Error insertando objeto " . $e->getMessage());
            }
        } else {
            // Aquí hay que crear una página de error
            return new Response("No se ha encontrado el contacto");
        }
    }
}
?>