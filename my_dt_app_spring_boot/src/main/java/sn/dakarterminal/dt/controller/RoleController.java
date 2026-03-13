package sn.dakarterminal.dt.controller;

import lombok.RequiredArgsConstructor;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;
import sn.dakarterminal.dt.dto.RoleDto;
import sn.dakarterminal.dt.service.RoleService;

import java.util.List;

@RestController
@RequestMapping("/api/roles")
@RequiredArgsConstructor
public class RoleController {

    private final RoleService roleService;

    @GetMapping
    public ResponseEntity<List<RoleDto>> findAll() {
        return ResponseEntity.ok(roleService.findAll());
    }

    @GetMapping("/{id}")
    public ResponseEntity<RoleDto> findById(@PathVariable Long id) {
        return ResponseEntity.ok(roleService.findById(id));
    }
}
