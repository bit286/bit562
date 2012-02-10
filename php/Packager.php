<?php

// A Packager gets a fileline and the bracecounter on its way to placing
// HTML around the fileline.  Each file type will get its own packager, and so
// there will be a phpPackager, a jsPackager, and so on.  All of the packagers
// will implement the Packager interface, making them polymorphic.
interface Packager {
   public function packager($fileLine, &$braceCounter);
}

?>
